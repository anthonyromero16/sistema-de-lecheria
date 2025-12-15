document.addEventListener('DOMContentLoaded', () => {
    // 1. Encuentra todos los elementos de carrusel: Incluye carrusel1, carrusel2 y carrusel3
    const carruseles = document.querySelectorAll('.carrusel1, .carrusel2, .carrusel3');

    // Si no hay carruseles en la pagina, detiene la ejecucion del script.
    if (carruseles.length === 0) return;

    /**
     * Inicializa la funcionalidad de navegacion y loop para un carrusel especifico.
     * @param {HTMLElement} carrusel - El contenedor de tarjetas (e.g., .carrusel1, .carrusel3).
     */
    const initializeCarousel = (carrusel) => {
        const cards = carrusel.querySelectorAll('.card');

        // El contenedor de botones es el padre directo del carrusel: .carrusel-wrapper
        const wrapper = carrusel.closest('.carrusel-wrapper');
        const prevBtn = wrapper.querySelector('.carrusel-btn.prev');
        const nextBtn = wrapper.querySelector('.carrusel-btn.next');

        // Validacion básica
        if (cards.length === 0 || !prevBtn || !nextBtn) return;

        let scrollIndex = 0; // Indice de la tarjeta actual que sera la primera visible
        const cardsLength = cards.length;
        const visibleCards = 3; // Negro de tarjetas visibles en el disenio CSS
        const gap = 20; // Separacion (gap) entre tarjetas definida en el CSS

        // Calculamos el ancho de desplazamiento por cada "slide"
        // (Ancho de la tarjeta + gap)
        const cardWidth = cards[0].offsetWidth + gap;

        // Indice minimo al que se puede llegar antes de hacer el loop
        const maxIndex = cardsLength - visibleCards;

        // Funcion que realiza el desplazamiento fisico en el carrusel
        const updateScroll = () => {
            carrusel.scrollTo({
                left: scrollIndex * cardWidth,
                behavior: 'smooth'
            });
        };

        // Event Listener para el botón Siguiente (Next)
        nextBtn.addEventListener('click', () => {
            scrollIndex++;
            // loop: si pasa el ultimo indice visible, vuelve al inicio (0)
            if (scrollIndex > maxIndex) {
                scrollIndex = 0;
            }
            updateScroll();
        });

        // Event Listener para el boton Anterior (Previous)
        prevBtn.addEventListener('click', () => {
            scrollIndex--;
            // loop: si pasa el primer indice (0), va al ultimo indice posible (maxIndex)
            if (scrollIndex < 0) {
                scrollIndex = maxIndex;
            }
            updateScroll();
        });
    };

    // 3. Iteramos sobre todos los carruseles encontrados (1, 2, y 3) e inicializamos cada uno
    carruseles.forEach(initializeCarousel);
});


document.addEventListener('DOMContentLoaded', () => {

    // Selecciona todos los botones de usuario
    const userButtons = document.querySelectorAll('.usuario-menu .btn-menu');

    userButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation(); // Evita que el clic cierre inmediatamente el menú

            const menu = button.nextElementSibling; // el div .menu-opciones
            if (!menu) return;

            // Cierra todos los demás menús
            document.querySelectorAll('.menu-opciones').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });

            // Alterna el menú actual
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        });
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', () => {
        document.querySelectorAll('.menu-opciones').forEach(menu => {
            menu.style.display = 'none';
        });
    });
});
