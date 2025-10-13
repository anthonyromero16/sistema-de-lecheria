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