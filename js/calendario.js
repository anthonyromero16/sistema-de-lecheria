document.addEventListener("DOMContentLoaded", function () {

    const calendarGrid = document.getElementById("calendarGrid");
    const currentMonthLabel = document.getElementById("currentMonth");
    const upcomingList = document.getElementById("upcomingList");
    const cowsGrid = document.getElementById("cowsGrid");
    const searchCow = document.getElementById("searchCow");

    let currentDate = new Date();

    // --- FUNCIONES PRINCIPALES ---

    function renderCalendar() {
        calendarGrid.innerHTML = "";

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const monthName = currentDate.toLocaleString("es-ES", { month: "long" });
        currentMonthLabel.textContent = `${monthName} ${year}`;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Espacios vacíos antes del día 1
        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement("div");
            empty.classList.add("empty-cell");
            calendarGrid.appendChild(empty);
        }

        // Días del mes
        for (let d = 1; d <= daysInMonth; d++) {
            const dayCell = document.createElement("div");
            dayCell.classList.add("day-cell");
            dayCell.textContent = d;

            dayCell.dataset.date = `${year}-${String(month + 1).padStart(2, "0")}-${String(d).padStart(2, "0")}`;

            dayCell.addEventListener("click", () => {
                mostrarEventosDeDia(dayCell.dataset.date);
            });

            calendarGrid.appendChild(dayCell);
        }
    }

    // Cargar eventos desde el backend
    function loadEvents() {
        fetch("index.php?r=veterinaria/get-events")
            .then(res => res.json())
            .then(events => renderUpcoming(events));
    }

    function renderUpcoming(events) {
        upcomingList.innerHTML = "";

        events.forEach(ev => {
            const item = document.createElement("div");
            item.classList.add("event-item");

            item.innerHTML = `
                <strong>${ev.tipo_evento}</strong><br>
                Vaca ID: ${ev.id_animal}<br>
                Fecha: ${ev.fecha}
            `;

            upcomingList.appendChild(item);
        });
    }

    // --- Cargar vacas desde el backend ---

    function loadCows() {
        fetch("index.php?r=veterinaria/get-cows")
            .then(res => res.json())
            .then(cows => renderCows(cows));
    }

    function renderCows(cows) {
        cowsGrid.innerHTML = "";

        cows.forEach(cow => {
            const card = document.createElement("div");
            card.classList.add("cow-card");

            card.innerHTML = `
                <h4>${cow.nombre}</h4>
                <p>ID: ${cow.id}</p>
                <p>${cow.descripcion ?? ""}</p>
            `;
            card.addEventListener("click", () => {
                mostrarFicha(cow.id);
            });


            cowsGrid.appendChild(card);
        });
    }

    // --- Mostrar eventos por día ---

    function mostrarEventosDeDia(date) {
        fetch("index.php?r=veterinaria/get-events")
            .then(res => res.json())
            .then(events => {
                const filtered = events.filter(e => e.fecha === date);

                if (filtered.length === 0) {
                    alert("No hay eventos para este día.");
                } else {
                    let msg = `Eventos del ${date}:\n\n`;
                    filtered.forEach(e => {
                        msg += `• ${e.tipo_evento} (Vaca ID: ${e.id_animal})\n`;
                    });
                    alert(msg);
                }
            });
    }

    // Buscar vaca
    searchCow.addEventListener("input", function () {
        const term = this.value.toLowerCase();

        const cards = cowsGrid.querySelectorAll(".cow-card");

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(term) ? "block" : "none";
        });
    });

    // --- Navegación del calendario ---

    document.getElementById("prevMonth").addEventListener("click", function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById("nextMonth").addEventListener("click", function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // --- INICIALIZACIÓN ----
    renderCalendar();
    loadEvents();
    loadCows();

    function mostrarFicha(id) {
        fetch(`index.php?r=veterinaria/cow-details&id=${id}`)
            .then(res => res.json())
            .then(data => {

                const a = data.animal;

                // Abrir modal correcto
                document.getElementById("fichaBackdrop").style.display = "flex";

                document.getElementById("fichaCowId").textContent = a.id;
                document.getElementById("fichaCowName").textContent = a.nombre;
                document.getElementById("fichaCowBreed").textContent = a.raza ?? "-";
                document.getElementById("fichaCowDesc").textContent = a.descripcion ?? "-";

                const vaccinesList = document.getElementById("fichaVaccineList");
                vaccinesList.innerHTML = "";
                data.vacunas.forEach(v => {
                    vaccinesList.innerHTML += `<li>${v.vacuna} - ${v.fecha_aplicacion} - ${v.observaciones}</li>`;
                });

                const eventList = document.getElementById("fichaEventList");
                eventList.innerHTML = "";
                data.eventos.forEach(ev => {
                    eventList.innerHTML += `<li>${ev.tipo_evento} (${ev.fecha}) - ${ev.descripcion} </li>`;
                });

            })
            .catch(err => console.error(err));
    }

    document.getElementById("fichaCloseBtn").addEventListener("click", () => {
        document.getElementById("fichaBackdrop").style.display = "none";
    });

});
