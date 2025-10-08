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