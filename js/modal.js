document.addEventListener("DOMContentLoaded", () => {
    loadCowCards();
});

function loadCowCards() {
    fetch("index.php?r=animales/api-list")
        .then(r => r.json())
        .then(res => {

            if (res.status !== "success") {
                console.error("Error API:", res);
                return;
            }

            const cows = res.data;
            const grid = document.getElementById("cowGrid");
            grid.innerHTML = "";

            cows.forEach(cow => {
                const card = document.createElement("div");
                card.className = "cow-card";

                // Si no hay imagen válida, usar foto por defecto
                const foto = (cow.imagen_base64 && cow.imagen_base64.trim() !== "")
                    ? cow.imagen_base64
                    : "/lecheria/web/images/logos/cow_icon.jpg";

                card.innerHTML = `
                    <div class="cow-photo">
                        <img src="${foto}" alt="${cow.nombre ?? 'Sin nombre'}" style="width:100%; border-radius:10px; ${!cow.imagen_base64 ? 'opacity:0.7;' : ''}">
                    </div>
                    <div class="cow-info">
                        <h4>${cow.nombre ?? "-"}</h4>
                        <p>${cow.descripcion ?? ""}</p>
                        <small>Raza: ${cow.nombre_raza ?? "-"}</small>
                    </div>
                `;

                card.addEventListener("click", () => openCowModal(cow.id));
                grid.appendChild(card);
            });
        })
        .catch(err => console.error("Error al cargar vacas:", err));
}


function openCowModal(id) {
    const backdrop = document.getElementById("backdrop");
    backdrop.classList.add("show");

    fetch(`?r=animales/api-view&id=${id}`)
        .then(r => r.json())
        .then(res => {
            if (!res || res.status !== "success") {
                alert("No se pudo cargar la información");
                backdrop.classList.remove("show");
                return;
            }

            const cow = res.data;

            // ===========================
            // LLENAR CAMPOS DEL MODAL
            // ===========================

            document.getElementById("modalTitle").innerText =
                cow.nombre ?? "Sin nombre";

            document.getElementById("tagId").innerText =
                "ID: " + (cow.id ?? "-");

            // Raza
            document.getElementById("breed").innerText =
                cow.raza ?? "-";

            // Edad
            document.getElementById("age").innerText =
                cow.fecha_nacimiento ? calcCowAge(cow.fecha_nacimiento) : "-";

            // Peso
            document.getElementById("weight").innerText =
                cow.peso_kg ? cow.peso_kg + "k" : "-";

            // Última producción
            document.getElementById("dailyProd").innerText =
                cow.produccion_ultima
                    ? cow.produccion_ultima + " litros"
                    : "-";

            // Estado de salud
            document.getElementById("health").innerText =
                cow.salud_evento
                    ? `${cow.salud_evento} (${cow.salud_fecha})`
                    : "Sin registros";

            // Fecha + edad
            document.getElementById("birthDate").innerText =
                cow.fecha_nacimiento
                    ? `${cow.fecha_nacimiento} (${calcCowAge(cow.fecha_nacimiento)})`
                    : "-";

            // Temperatura
            document.getElementById("temp").innerText =
                cow.temperatura_celsius
                    ? cow.temperatura_celsius + " °C"
                    : "-";

            // Foto
            document.getElementById("cowPhoto").src =
                cow.foto && cow.foto !== "null" ? cow.foto : "/lecheria/web/images/logos/cow_icon.jpg";

            // Descripción / notas
            document.getElementById("notes").innerText =
                cow.descripcion ?? "Sin observaciones";

        })
        .catch(err => {
            console.error("FETCH ERROR:", err);
            alert("Error cargando datos del servidor");
            backdrop.classList.remove("show");
        });
}


// Calcular edad
function calcCowAge(fechaNac) {
    if (!fechaNac) return "-";
    const n = new Date(fechaNac);
    const h = new Date();
    let edad = h.getFullYear() - n.getFullYear();
    const m = h.getMonth() - n.getMonth();
    if (m < 0 || (m === 0 && h.getDate() < n.getDate())) edad--;
    return edad + " años";
}

// Botón cerrar
document.addEventListener("DOMContentLoaded", () => {
    const closeBtn = document.getElementById("closeBtn");
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            const backdrop = document.getElementById("backdrop");

            // LIMPIA cualquier estilo inline que la estuviera bloqueando

            // Oculta la modal usando tu lógica correcta:
            backdrop.classList.remove("show");
        });
    }
});

