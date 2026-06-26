document.addEventListener('DOMContentLoaded', () => {

    const tourItems   = document.querySelectorAll('.tour-item');
    const megaMenu    = document.getElementById('mega-menu-mp');
    const previewBox  = document.getElementById('preview-box');

    if (!megaMenu || !previewBox) return;

    const previewTitle      = document.getElementById('preview-title');
    const previewDesc       = document.getElementById('preview-desc');
    const previewPrice      = document.getElementById('preview-price');
    const previewPriceWrap  = document.getElementById('preview-price-wrap');
    const previewTime       = document.getElementById('preview-time');
    const previewDifficulty = document.getElementById('preview-difficulty');
    const previewTransport  = document.getElementById('preview-transport');
    const previewImg        = document.getElementById('preview-img');

    // Valores por defecto desde data attributes
    const def = {
        title:      previewBox.dataset.defaultTitle,
        desc:       previewBox.dataset.defaultDesc,
        price:      previewBox.dataset.defaultPrice,
        time:       previewBox.dataset.defaultTime,
        difficulty: previewBox.dataset.defaultDifficulty,
        transport:  previewBox.dataset.defaultTransport,
    };

    // Quitar highlight activo de todos
    function clearActive() {
        tourItems.forEach(i => i.classList.remove('bg-[#FFF7EF]', 'active-tour'));
    }

    // Actualizar preview con datos del item
    function updatePreview(item) {
        clearActive();
        item.classList.add('bg-[#FFF7EF]', 'active-tour');

        previewTitle.textContent      = item.dataset.title;
        previewDesc.textContent       = item.dataset.desc;
        previewTime.textContent       = item.dataset.time;
        previewDifficulty.textContent = item.dataset.difficulty;
        previewTransport.textContent  = item.dataset.transport;

        // Precio
        const precio = item.dataset.price;
        if (precio && precio !== '---' && precio !== '-') {
            previewPrice.textContent = precio;
            previewPriceWrap.classList.remove('hidden');
        } else {
            previewPriceWrap.classList.add('hidden');
        }

        // Imagen
        if (previewImg && item.dataset.img) {
            previewImg.src = item.dataset.img;
            previewImg.style.display = 'block';
        }
    }

    // Resetear al estado por defecto
    function resetPreview() {
        clearActive();
        previewTitle.textContent      = def.title;
        previewDesc.textContent       = def.desc;
        previewTime.textContent       = def.time;
        previewDifficulty.textContent = def.difficulty;
        previewTransport.textContent  = def.transport;
        previewPriceWrap.classList.add('hidden');

        if (previewImg) {
            previewImg.src = '';
            previewImg.style.display = 'none';
        }
    }

    // Eventos
    tourItems.forEach(item => {
        item.addEventListener('mouseenter', () => updatePreview(item));
    });

    megaMenu.addEventListener('mouseleave', () => resetPreview());

    // Calcular posición dinámica del mega menú (por si el header cambia de alto)
    function setMenuTop() {
        const nav = document.getElementById('nav-menu');
        if (nav) {
            const bottom = nav.getBoundingClientRect().bottom + window.scrollY;
            document.documentElement.style.setProperty('--header-nav-bottom', bottom + 'px');
        }
    }

    setMenuTop();
    window.addEventListener('resize', setMenuTop);
    window.addEventListener('scroll', setMenuTop);

});