document.addEventListener('DOMContentLoaded', () => {
    // Busca todos los elementos de carrusel (carrusel1 y carrusel2)
    const carruseles = document.querySelectorAll('.carrusel1, .carrusel2');

    if (carruseles.length === 0) return;

    const initializeCarousel = (carrusel) => {
        const cards = carrusel.querySelectorAll('.card');

        // Encuentra los botones en el mismo wrapper
        const wrapper = carrusel.closest('.carrusel-wrapper');
        const prevBtn = wrapper.querySelector('.carrusel-btn.prev');
        const nextBtn = wrapper.querySelector('.carrusel-btn.next');

        if (cards.length === 0 || !prevBtn || !nextBtn) return;

        let scrollIndex = 0;
        const cardsLength = cards.length;
        const visibleCards = 3;
        const gap = 20;

        // Calcular ancho total (Card Width + Gap)
        // Nota: Asegúrate de que el primer elemento del carrusel esté visible para obtener el offsetWidth correcto
        const cardWidth = cards[0].offsetWidth + gap;
        const maxIndex = cardsLength - visibleCards;

        const updateScroll = () => {
            carrusel.scrollTo({
                left: scrollIndex * cardWidth,
                behavior: 'smooth'
            });
        };

        // Event Listener para el botón Siguiente (Next) - Lógica de Loop
        nextBtn.addEventListener('click', () => {
            scrollIndex++;
            if (scrollIndex > maxIndex) {
                scrollIndex = 0; // Vuelve al inicio
            }
            updateScroll();
        });

        // Event Listener para el botón Anterior (Previous) - Lógica de Loop
        prevBtn.addEventListener('click', () => {
            scrollIndex--;
            if (scrollIndex < 0) {
                scrollIndex = maxIndex; // Salta al final
            }
            updateScroll();
        });
    };

    // Inicializa todos los carruseles encontrados
    carruseles.forEach(initializeCarousel);
});
