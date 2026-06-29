document.addEventListener('DOMContentLoaded', () => {

    // ─────────────────────────────────────────────
    // Función que inicializa UN mega menú completo
    // Recibe el elemento <li> contenedor del menú
    // ─────────────────────────────────────────────
    function initMegaMenu(megaMenu) {

        if (!megaMenu) return;

        // Buscar TODO dentro del mega menú, no en el documento global
        const tourItems     = megaMenu.querySelectorAll('.tour-item');
        const previewDefault = megaMenu.querySelector('[data-preview="default"]');
        const previewHover   = megaMenu.querySelector('[data-preview="hover"]');

        if (!previewDefault || !previewHover) return;

        // Elementos del estado hover — scoped al mega menú
        const previewTitle      = megaMenu.querySelector('[data-preview="title"]');
        const previewDesc       = megaMenu.querySelector('[data-preview="desc"]');
        const previewPrice      = megaMenu.querySelector('[data-preview="price"]');
        const previewPriceWrap  = megaMenu.querySelector('[data-preview="price-wrap"]');
        const previewTime       = megaMenu.querySelector('[data-preview="time"]');
        const previewDifficulty = megaMenu.querySelector('[data-preview="difficulty"]');
        const previewTransport  = megaMenu.querySelector('[data-preview="transport"]');
        const previewImg        = megaMenu.querySelector('[data-preview="img"]');

        function clearActive() {
            tourItems.forEach(i => i.classList.remove('bg-[#FFF7EF]', 'active-tour'));
        }

        function showDefault() {
            clearActive();
            previewDefault.classList.remove('hidden');
            previewHover.classList.add('hidden');
        }

        function showTour(item) {
            clearActive();
            item.classList.add('bg-[#FFF7EF]', 'active-tour');

            previewTitle.textContent      = item.dataset.title;
            previewDesc.textContent       = item.dataset.desc;
            previewTime.textContent       = item.dataset.time;
            previewDifficulty.textContent = item.dataset.difficulty;
            previewTransport.textContent  = item.dataset.transport;

            const precio = item.dataset.price;
            if (precio && precio !== '---' && precio !== '-') {
                previewPrice.textContent = precio;
                previewPriceWrap.classList.remove('hidden');
            } else {
                previewPriceWrap.classList.add('hidden');
            }

            if (previewImg && item.dataset.img) {
                previewImg.src = item.dataset.img;
                previewImg.style.display = 'block';
            } else if (previewImg) {
                previewImg.style.display = 'none';
            }

            previewDefault.classList.add('hidden');
            previewHover.classList.remove('hidden');
        }

        // Eventos
        tourItems.forEach(item => {
            item.addEventListener('mouseenter', () => showTour(item));
        });

        megaMenu.addEventListener('mouseleave', () => showDefault());
    }

    // ─────────────────────────────────────────
    // Inicializar cada mega menú por separado
    // ─────────────────────────────────────────
    document.querySelectorAll('[data-megamenu]').forEach(menu => {
        initMegaMenu(menu);
    });

    // ─────────────────────────────────────────
    // Posición dinámica (si usas fixed en algún menú)
    // ─────────────────────────────────────────
    function setMenuTop() {
        const nav = document.getElementById('nav-menu');
        if (nav) {
            const bottom = nav.getBoundingClientRect().bottom;
            document.documentElement.style.setProperty('--header-nav-bottom', bottom + 'px');
        }
    }

    setMenuTop();
    window.addEventListener('resize', setMenuTop);
    window.addEventListener('scroll', setMenuTop);

});