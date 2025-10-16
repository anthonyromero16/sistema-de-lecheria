function openTab(evt, tabId) {
    /*tab manager*/
    const tabs = document.querySelectorAll('.tab-content');
    const buttons = document.querySelectorAll('.tab-btn');

    tabs.forEach(tab => tab.classList.remove('active'));
    buttons.forEach(btn => btn.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    evt.currentTarget.classList.add('active');
}

/*carrusel de razas*/
document.addEventListener("DOMContentLoaded", () => {
    const slide = document.querySelector('.carrusel-slide');
    const items = document.querySelectorAll('.carrusel-item');
    const prevBtn = document.querySelector('.carrusel-btn.prev');
    const nextBtn = document.querySelector('.carrusel-btn.next');
    let current = 0;

    function updateSlidePosition() {
        const offset = -current * 100;
        slide.style.transform = `translateX(${offset}%)`;
    }

    prevBtn.addEventListener('click', () => {
        current = (current - 1 + items.length) % items.length;
        updateSlidePosition();
    });

    nextBtn.addEventListener('click', () => {
        current = (current + 1) % items.length;
        updateSlidePosition();
    });

    setInterval(() => {
        current = (current + 1) % items.length;
        updateSlidePosition();
    }, 5000);

    updateSlidePosition();
});

// === Animación ordeño ===
document.addEventListener("DOMContentLoaded", function () {
    const vaca = document.getElementById("vaca");
    const gota = document.getElementById("gota");
    const contenedor = document.querySelector(".ordeño-container");

    const alturaCubo = 50;
    const incrementoLeche = 5; 
    let nivelActual = 0;

    const CAIDA_FINAL_PX = "-150px"; 
    const DURACION_CAIDA_MS = 400; 

    const CUBO_ID = "cubo-actual";
    const LECHE_ID = "leche-actual";
    const DURACION_REEMPLAZO_MS = 1000; 

    function crearNuevoCubo(esInicial) {
        const nuevoCubo = document.createElement("div");
        nuevoCubo.className = "cubo";
        nuevoCubo.id = CUBO_ID;
        nuevoCubo.innerHTML = `<div class="leche" id="${LECHE_ID}"></div>`;
        contenedor.appendChild(nuevoCubo);

        if (!esInicial) {
            nuevoCubo.style.transition = 'none';
            nuevoCubo.style.transform = 'translate(150vw, 0)';

            void nuevoCubo.offsetWidth;

            nuevoCubo.style.transition = `transform ${DURACION_REEMPLAZO_MS}ms ease-out`;
        }

        nuevoCubo.style.transform = 'translateX(-50%)';

        return nuevoCubo;
    }

    let cubo = crearNuevoCubo(true);
    let leche = cubo.querySelector(`#${LECHE_ID}`);

    vaca.addEventListener("click", () => {

        gota.style.transition = "none";
        gota.style.bottom = "-15px"; 
        gota.style.opacity = 1;

        setTimeout(() => {
            gota.style.transition = `bottom ${DURACION_CAIDA_MS}ms ease-in`;
            gota.style.bottom = CAIDA_FINAL_PX;

            setTimeout(() => {
                gota.style.transition = "opacity 0ms";
                gota.style.opacity = 0;

                if (nivelActual < alturaCubo) {
                    nivelActual += incrementoLeche;
                    nivelActual = Math.min(nivelActual, alturaCubo);
                    leche.style.height = `${nivelActual}px`;
                }

                if (nivelActual >= alturaCubo) {

                    cubo.style.transition = `transform ${DURACION_REEMPLAZO_MS}ms ease-in-out`;

                    cubo.style.transform = 'translate(150vw, 0)';
                    setTimeout(() => {
                        cubo.remove();
                        cubo = crearNuevoCubo(false);
                        leche = cubo.querySelector(`#${LECHE_ID}`);
                        nivelActual = 0;

                    }, DURACION_REEMPLAZO_MS);
                }

            }, DURACION_CAIDA_MS - 50); 
        }, 10);
    });

});

// Ficha de modal
document.addEventListener("DOMContentLoaded", () => {
    const cows = [
        { id: 'V-001', name: 'Luna', breed: 'Holstein', age: '4.2 años', prod7: [22, 21, 23, 20, 24, 23, 22], lastCheck: '2025-09-20', temp: 38.6, lameness: 1, bcs: 3.0, vaccines: 'BVD, Brucella (2025-01-10)', repro: 'Secundaria', notes: 'Producción estable, observa leve cojerita', events: ['2025-09-18: Parto normal', '2025-09-20: Control sanitario'] },
        { id: 'V-002', name: 'Estrella', breed: 'Jersey', age: '3.7 años', prod7: [12, 11, 13, 12, 12, 12, 11], lastCheck: '2025-09-25', temp: 39.1, lameness: 2, bcs: 2.5, vaccines: 'Leptospirosis (2025-03-12)', repro: 'En lactancia', notes: 'Temperatura ligeramente alta — vigilar', events: ['2025-09-24: Fiebre leve', '2025-09-25: Aplicada antipirético'] },
        { id: 'V-003', name: 'María', breed: 'Normando', age: '6.0 años', prod7: [18, 19, 19, 18, 17, 16, 18], lastCheck: '2025-08-30', temp: 37.9, lameness: 0, bcs: 3.5, vaccines: 'Completo (2024-12-05)', repro: 'Secada', notes: 'Buena condición corporal', events: ['2025-08-30: Control trimestral'] }
    ];

    const grid = document.getElementById('cowGrid');
    const backdrop = document.getElementById('backdrop');
    const closeBtn = document.getElementById('closeBtn');
    const printBtn = document.getElementById('printBtn');

    // Renderizar tarjetas
    function renderCards() {
        grid.innerHTML = '';
        cows.forEach((c, i) => {
            const el = document.createElement('div');
            el.className = 'card';
            el.tabIndex = 0;
            el.innerHTML = `
      <div class="title">${c.name} <span style="font-weight:500;color:var(--muted);font-size:13px">(${c.id})</span></div>
      <div class="meta">Raza: ${c.breed}</div>
      <div class="badge">${Math.round(avg(c.prod7))} L/día (prom)</div>`;
            el.addEventListener('click', () => openModal(i));
            el.addEventListener('keydown', (e) => { if (e.key === 'Enter') openModal(i); });
            grid.appendChild(el);
        });
    }

    function avg(arr) { return arr.reduce((s, x) => s + x, 0) / arr.length }

    // Mostrar modal
    function openModal(idx) {
        const c = cows[idx];


        document.getElementById('modalTitle').textContent = c.name + ' — Ficha';
        document.getElementById('modalSub').textContent = `${c.id} • Raza ${c.breed}`;
        document.getElementById('photo').textContent = c.name.slice(0, 8);
        document.getElementById('tagId').textContent = `ID: ${c.id}`;
        document.getElementById('breed').textContent = `Raza: ${c.breed}`;
        document.getElementById('repro').textContent = c.repro;
        document.getElementById('curProd').textContent = `${c.prod7[c.prod7.length - 1]} L`;
        document.getElementById('lastCheck').textContent = c.lastCheck;
        document.getElementById('age').textContent = c.age;
        drawProdChart(c.prod7);
        document.getElementById('avgProd').textContent = avg(c.prod7).toFixed(1);

        // Salud
        const tempPill = document.getElementById('tempPill');
        tempPill.textContent = `Temp: ${c.temp}°C`;
        tempPill.className = 'health-pill ' + (c.temp > 39 ? 'bad' : c.temp > 38.5 ? 'warn' : 'ok');

        const lamenessPill = document.getElementById('lamenessPill');
        lamenessPill.textContent = `Cojera: ${c.lameness}`;
        lamenessPill.className = 'health-pill ' + (c.lameness >= 2 ? 'warn' : 'ok');

        const bcsPill = document.getElementById('bcsPill');
        bcsPill.textContent = `BCS: ${c.bcs}`;
        bcsPill.className = 'health-pill ' + (c.bcs < 2.5 ? 'warn' : 'ok');

        document.getElementById('vaccines').textContent = c.vaccines;
        document.getElementById('lastExam').textContent = c.lastCheck;
        document.getElementById('notes').textContent = c.notes;
        document.getElementById('eventsList').innerHTML = c.events.map(e => `<div>• ${e}</div>`).join('');

        backdrop.style.display = 'flex';
        closeBtn.focus();
    }

    function closeModal() { backdrop.style.display = 'none'; }
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', (e) => { if (e.target === backdrop) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

    // Imprimir modal
    printBtn.addEventListener('click', () => {
        const modal = document.querySelector('.modal');
        const w = window.open('', '_blank');
        w.document.write('<title>Ficha</title>');
        w.document.write(modal.innerHTML);
        w.document.close();
        w.print();
        w.close();
    });

    // Dibujar gráfico
    function drawProdChart(data) {
        const canvas = document.getElementById('prodChart');
        const ctx = canvas.getContext('2d');
        const DPR = window.devicePixelRatio || 1;
        const W = canvas.width = canvas.clientWidth * DPR;
        const H = canvas.height = canvas.clientHeight * DPR;
        ctx.clearRect(0, 0, W, H);
        const padding = 12 * DPR;
        const max = Math.max(...data) * 1.12;
        const min = Math.min(...data) * 0.88;
        const stepX = (W - padding * 2) / (data.length - 1);

        ctx.strokeStyle = 'rgba(2,6,23,0.06)';
        ctx.lineWidth = 1 * DPR;
        for (let i = 0; i < 4; i++) {
            const y = padding + (H - padding * 2) * (i / 3);
            ctx.beginPath(); ctx.moveTo(padding, y); ctx.lineTo(W - padding, y); ctx.stroke();
        }

        ctx.beginPath();
        data.forEach((v, i) => {
            const x = padding + stepX * i;
            const y = H - padding - ((v - min) / (max - min)) * (H - padding * 2);
            if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
        });
        ctx.strokeStyle = 'rgba(43,108,176,0.95)';
        ctx.lineWidth = 2 * DPR;
        ctx.stroke();

        data.forEach((v, i) => {
            const x = padding + stepX * i;
            const y = H - padding - ((v - min) / (max - min)) * (H - padding * 2);
            ctx.beginPath(); ctx.arc(x, y, 3 * DPR, 0, Math.PI * 2);
            ctx.fillStyle = 'white'; ctx.fill();
            ctx.strokeStyle = 'rgba(43,108,176,0.95)';
            ctx.stroke();
        });
    }

    // Inicializar
    renderCards();
});



// Datos de ejemplo para el calendario de salud
const healthData = {
    cows: [
        {
            id: 'V-001',
            name: 'Luna',
            breed: 'Holstein',
            age: '4.2 años',
            repro: 'En lactancia',
            treatments: [
                { date: '2025-10-05', type: 'Desparasitación', desc: 'Ivermectina - Control parásitos internos' },
                { date: '2025-10-20', type: 'Vacunación', desc: 'Refuerzo Clostridios' },
                { date: '2025-11-15', type: 'Control', desc: 'Revisión pezuñas y pediluvio' }
            ],
            vaccines: [
                { date: '2025-01-10', type: 'BVD', desc: 'Diarrea Viral Bovina' },
                { date: '2025-01-10', type: 'Brucella', desc: 'Brucelosis' },
                { date: '2024-07-15', type: 'Leptospirosis', desc: 'Refuerzo anual' }
            ],
            controls: [
                { date: '2025-09-20', type: 'Control general', desc: 'Temperatura: 38.6°C, BCS: 3.0' },
                { date: '2025-08-15', type: 'Revisión reproductiva', desc: 'Útero normal, lista para monta' },
                { date: '2025-07-10', type: 'Control mastitis', desc: 'RCS: 150,000 células/ml' }
            ],
            notes: 'Producción estable. Observar leve cojera en pata trasera izquierda.'
        },
        {
            id: 'V-002',
            name: 'Estrella',
            breed: 'Jersey',
            age: '3.7 años',
            repro: 'Preparto',
            treatments: [
                { date: '2025-10-10', type: 'Vacunación preparto', desc: 'Rotavirus, Coronavirus, E. coli' },
                { date: '2025-10-25', type: 'Control', desc: 'Evaluación condición corporal preparto' },
                { date: '2025-11-05', type: 'Secado', desc: 'Aplicación antibióticos de secado' }
            ],
            vaccines: [
                { date: '2025-03-12', type: 'Leptospirosis', desc: 'Refuerzo anual' },
                { date: '2024-11-20', type: 'IBR', desc: 'Rinotraqueítis Infecciosa Bovina' }
            ],
            controls: [
                { date: '2025-09-25', type: 'Control general', desc: 'Temperatura: 39.1°C, BCS: 2.5' },
                { date: '2025-08-30', type: 'Ecografía', desc: 'Gestación confirmada - 5 meses' },
                { date: '2025-07-15', type: 'Control nutricional', desc: 'Ajuste dieta preparto' }
            ],
            notes: 'Gestación avanzada. Vigilar temperatura ligeramente elevada.'
        },
        {
            id: 'V-003',
            name: 'María',
            breed: 'Normando',
            age: '6.0 años',
            repro: 'Secada',
            treatments: [
                { date: '2025-10-08', type: 'Desparasitación', desc: 'Control parásitos gastrointestinales' },
                { date: '2025-10-30', type: 'Vacunación', desc: 'Refuerzo IBR y BVD' },
                { date: '2025-11-20', type: 'Control', desc: 'Revisión general y recorte pezuñas' }
            ],
            vaccines: [
                { date: '2024-12-05', type: 'Completo', desc: 'Programa anual completo' },
                { date: '2024-06-10', type: 'Clostridios', desc: 'Refuerzo semestral' }
            ],
            controls: [
                { date: '2025-08-30', type: 'Control general', desc: 'Temperatura: 37.9°C, BCS: 3.5' },
                { date: '2025-07-20', type: 'Control mastitis', desc: 'RCS: 85,000 células/ml' },
                { date: '2025-06-15', type: 'Evaluación reproductiva', desc: 'Periodo de secado iniciado' }
            ],
            notes: 'Buena condición corporal. En periodo de descanso.'
        },
        {
            id: 'V-004',
            name: 'Bella',
            breed: 'Sindhi',
            age: '5.1 años',
            repro: 'En lactancia',
            treatments: [
                { date: '2025-10-12', type: 'Control', desc: 'Revisión ubre y test de mastitis' },
                { date: '2025-10-28', type: 'Vacunación', desc: 'Leptospirosis' },
                { date: '2025-11-08', type: 'Desparasitación', desc: 'Control parásitos externos' }
            ],
            vaccines: [
                { date: '2025-02-15', type: 'Completo', desc: 'Programa tropical adaptado' },
                { date: '2024-11-05', type: 'Fiebre aftosa', desc: 'Vacunación obligatoria' }
            ],
            controls: [
                { date: '2025-09-18', type: 'Control general', desc: 'Temperatura: 38.4°C, BCS: 3.2' },
                { date: '2025-08-22', type: 'Control producción', desc: 'Promedio: 15L/día' },
                { date: '2025-07-10', type: 'Revisión reproductiva', desc: 'Celo detectado, programar monta' }
            ],
            notes: 'Alta resistencia al clima tropical. Producción estable.'
        }
    ]
};

// Variables globales
let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

// Inicializar calendario de salud cuando se cargue la página
document.addEventListener('DOMContentLoaded', function () {
    initializeHealthCalendar();
    renderCowsList();
    setupEventListeners();
});

// Inicializar el calendario
function initializeHealthCalendar() {
    renderCalendar(currentMonth, currentYear);
    renderUpcomingEvents();
}

// Renderizar el calendario
function renderCalendar(month, year) {
    const calendarGrid = document.getElementById('calendarGrid');
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    // Actualizar título del mes
    document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

    // Obtener primer día del mes y cantidad de días
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Limpiar calendario
    calendarGrid.innerHTML = '';

    // Agregar días de la semana
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    dayNames.forEach(day => {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = day;
        dayElement.style.fontWeight = 'bold';
        dayElement.style.color = 'var(--muted)';
        calendarGrid.appendChild(dayElement);
    });

    // Agregar días vacíos al inicio
    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day empty';
        calendarGrid.appendChild(emptyDay);
    }

    // Agregar días del mes
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = day;

        // Marcar día actual
        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            dayElement.classList.add('today');
        }

        // Verificar si hay eventos en este día
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        if (hasEventsOnDate(dateStr)) {
            dayElement.classList.add('has-event');
        }

        calendarGrid.appendChild(dayElement);
    }
}

// Verificar si hay eventos en una fecha específica
function hasEventsOnDate(dateStr) {
    for (const cow of healthData.cows) {
        for (const treatment of cow.treatments) {
            if (treatment.date === dateStr) {
                return true;
            }
        }
    }
    return false;
}

// Renderizar eventos próximos
function renderUpcomingEvents() {
    const upcomingList = document.getElementById('upcomingList');
    const today = new Date();
    const nextWeek = new Date(today);
    nextWeek.setDate(today.getDate() + 7);

    // Recolectar todos los eventos próximos
    let upcomingEvents = [];

    healthData.cows.forEach(cow => {
        cow.treatments.forEach(treatment => {
            const treatmentDate = new Date(treatment.date);
            if (treatmentDate >= today && treatmentDate <= nextWeek) {
                upcomingEvents.push({
                    date: treatment.date,
                    desc: `${cow.name} (${cow.id}): ${treatment.type}`,
                    cowId: cow.id
                });
            }
        });
    });

    // Ordenar eventos por fecha
    upcomingEvents.sort((a, b) => new Date(a.date) - new Date(b.date));

    // Limitar a 5 eventos
    upcomingEvents = upcomingEvents.slice(0, 5);

    // Renderizar eventos
    if (upcomingEvents.length === 0) {
        upcomingList.innerHTML = '<div class="event-item">No hay eventos próximos</div>';
    } else {
        upcomingList.innerHTML = '';
        upcomingEvents.forEach(event => {
            const eventElement = document.createElement('div');
            eventElement.className = 'event-item';
            eventElement.innerHTML = `
                <div class="event-date">${formatDate(event.date)}</div>
                <div class="event-desc">${event.desc}</div>
            `;
            eventElement.addEventListener('click', () => {
                const cow = healthData.cows.find(c => c.id === event.cowId);
                if (cow) {
                    openHealthModal(cow);
                }
            });
            upcomingList.appendChild(eventElement);
        });
    }
}

// Renderizar lista de vacas
function renderCowsList() {
    const cowsGrid = document.getElementById('cowsGrid');
    cowsGrid.innerHTML = '';

    healthData.cows.forEach(cow => {
        // Encontrar próximo tratamiento
        const today = new Date();
        const nextTreatment = cow.treatments
            .map(t => ({ ...t, dateObj: new Date(t.date) }))
            .filter(t => t.dateObj >= today)
            .sort((a, b) => a.dateObj - b.dateObj)[0];

        const cowElement = document.createElement('div');
        cowElement.className = 'cow-card';
        cowElement.innerHTML = `
            <div class="cow-name">${cow.name}</div>
            <div class="cow-id">${cow.id}</div>
            <div class="cow-breed">${cow.breed}</div>
            <div class="cow-age">${cow.age}</div>
            <div class="cow-repro">${cow.repro}</div>
            ${nextTreatment ?
                `<div class="cow-next-event">Próximo: ${formatDate(nextTreatment.date)} - ${nextTreatment.type}</div>` :
                '<div class="cow-next-event">Sin tratamientos programados</div>'
            }
        `;

        cowElement.addEventListener('click', () => openHealthModal(cow));
        cowsGrid.appendChild(cowElement);
    });
}

// Abrir modal de salud
function openHealthModal(cow) {
    const modal = document.getElementById('healthModalBackdrop');
    const title = document.getElementById('healthModalTitle');
    const sub = document.getElementById('healthModalSub');
    const photo = document.getElementById('cowPhoto');
    const cowId = document.getElementById('cowId');
    const cowBreed = document.getElementById('cowBreed');
    const cowAge = document.getElementById('cowAge');
    const cowRepro = document.getElementById('cowRepro');

    // Actualizar información básica
    title.textContent = `Tratamientos y Controles - ${cow.name}`;
    sub.textContent = `${cow.id} • Raza ${cow.breed}`;
    photo.textContent = cow.name.slice(0, 8);
    cowId.textContent = `ID: ${cow.id}`;
    cowBreed.textContent = cow.breed;
    cowAge.textContent = cow.age;
    cowRepro.textContent = cow.repro;

    // Renderizar tratamientos programados
    renderTreatments(cow.treatments, 'scheduledTreatments');

    // Renderizar historial de vacunación
    renderVaccines(cow.vaccines, 'vaccinationHistory');

    // Renderizar controles de salud
    renderControls(cow.controls, 'healthControls');

    // Renderizar notas
    document.getElementById('healthNotes').innerHTML =
        `<div class="treatment-item">${cow.notes}</div>`;

    // Mostrar modal
    modal.style.display = 'flex';
}

// Renderizar tratamientos
function renderTreatments(treatments, containerId) {
    const container = document.getElementById(containerId);

    if (treatments.length === 0) {
        container.innerHTML = '<div class="treatment-item">No hay tratamientos programados</div>';
        return;
    }

    // Ordenar por fecha (más recientes primero)
    const sortedTreatments = [...treatments].sort((a, b) =>
        new Date(b.date) - new Date(a.date)
    );

    container.innerHTML = '';
    sortedTreatments.forEach(treatment => {
        const treatmentElement = document.createElement('div');
        treatmentElement.className = 'treatment-item';
        treatmentElement.innerHTML = `
            <div class="treatment-date">${formatDate(treatment.date)}</div>
            <div class="treatment-type"><strong>${treatment.type}</strong></div>
            <div class="treatment-desc">${treatment.desc}</div>
        `;
        container.appendChild(treatmentElement);
    });
}

// Renderizar vacunas
function renderVaccines(vaccines, containerId) {
    const container = document.getElementById(containerId);

    if (vaccines.length === 0) {
        container.innerHTML = '<div class="vaccine-item">No hay registro de vacunación</div>';
        return;
    }

    // Ordenar por fecha (más recientes primero)
    const sortedVaccines = [...vaccines].sort((a, b) =>
        new Date(b.date) - new Date(a.date)
    );

    container.innerHTML = '';
    sortedVaccines.forEach(vaccine => {
        const vaccineElement = document.createElement('div');
        vaccineElement.className = 'vaccine-item';
        vaccineElement.innerHTML = `
            <div class="vaccine-date">${formatDate(vaccine.date)}</div>
            <div class="vaccine-type"><strong>${vaccine.type}</strong></div>
            <div class="vaccine-desc">${vaccine.desc}</div>
        `;
        container.appendChild(vaccineElement);
    });
}

// Renderizar controles
function renderControls(controls, containerId) {
    const container = document.getElementById(containerId);

    if (controls.length === 0) {
        container.innerHTML = '<div class="control-item">No hay controles registrados</div>';
        return;
    }

    // Ordenar por fecha (más recientes primero)
    const sortedControls = [...controls].sort((a, b) =>
        new Date(b.date) - new Date(a.date)
    );

    container.innerHTML = '';
    sortedControls.forEach(control => {
        const controlElement = document.createElement('div');
        controlElement.className = 'control-item';
        controlElement.innerHTML = `
            <div class="control-date">${formatDate(control.date)}</div>
            <div class="control-type"><strong>${control.type}</strong></div>
            <div class="control-desc">${control.desc}</div>
        `;
        container.appendChild(controlElement);
    });
}

// Configurar event listeners
function setupEventListeners() {
    // Navegación del calendario
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
    });

    // Cerrar modal de salud
    document.getElementById('closeHealthModal').addEventListener('click', () => {
        document.getElementById('healthModalBackdrop').style.display = 'none';
    });

    document.getElementById('healthModalBackdrop').addEventListener('click', (e) => {
        if (e.target === document.getElementById('healthModalBackdrop')) {
            document.getElementById('healthModalBackdrop').style.display = 'none';
        }
    });

    // Búsqueda de vacas
    document.getElementById('searchCow').addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const cowCards = document.querySelectorAll('.cow-card');

        cowCards.forEach(card => {
            const name = card.querySelector('.cow-name').textContent.toLowerCase();
            const id = card.querySelector('.cow-id').textContent.toLowerCase();

            if (name.includes(searchTerm) || id.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// Función auxiliar para formatear fechas
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}