document.addEventListener("DOMContentLoaded", () => {

    const carruseles = document.querySelectorAll(".auto-swiper");

    carruseles.forEach((el, index) => {

        // Leer configuración desde los data-attributes
        const desktop  = parseInt(el.dataset.desktop)  || 3;
        const tablet   = parseInt(el.dataset.tablet)   || 2;
        const mobile   = parseInt(el.dataset.mobile)   || 1;
        const gap        = parseInt(el.dataset.gap)        || 20;
        const gapMobile  = parseInt(el.dataset.gapMobile)  || gap;
        const gapTablet  = parseInt(el.dataset.gapTablet)  || gap;
        const gapDesktop = parseInt(el.dataset.gapDesktop) || gap;
        const loop     = el.dataset.loop === "true";
        const autoplay = el.dataset.autoplay === "true";
        const showNav  = el.dataset.nav !== "false";   // true por defecto
        const showDots = el.dataset.dots !== "false";  // true por defecto

        // ID único para que las flechas/paginación no choquen entre carruseles distintos
        const uid = `auto-swiper-${index}`;
        el.classList.add(uid);

        // Generar flechas de navegación (si corresponde)
        if (showNav) {
            const prevBtn = document.createElement("div");
            prevBtn.className = `${uid}-prev auto-swiper-nav auto-swiper-prev `;
            prevBtn.innerHTML = `<i class="fa-solid fa-chevron-left"></i>`;

            const nextBtn = document.createElement("div");
            nextBtn.className = `${uid}-next auto-swiper-nav auto-swiper-next `;
            nextBtn.innerHTML = `<i class="fa-solid fa-chevron-right"></i>`;

            el.style.position = "relative";
                    
            el.parentElement.appendChild(prevBtn); // antes: el.appendChild(prevBtn)
            el.parentElement.appendChild(nextBtn); // antes: el.appendChild(nextBtn)
        }

        // Generar paginación (si corresponde)
        let paginationEl = null;
        if (showDots) {
            paginationEl = document.createElement("div");
            paginationEl.className = `${uid}-pagination auto-swiper-pagination`;
            el.appendChild(paginationEl);
        }

        // Inicializar Swiper
        new Swiper(`.${uid}`, {
            slidesPerView: mobile,
            spaceBetween: gapMobile,
            loop: loop,
            autoplay: autoplay ? { delay: 4000, disableOnInteraction: false } : false,
            navigation: showNav ? {
                nextEl: `.${uid}-next`,
                prevEl: `.${uid}-prev`,
            } : false,
            pagination: showDots ? {
                el: `.${uid}-pagination`,
                clickable: true,
            } : false,
            breakpoints: {
                640: {
                    slidesPerView: tablet,
                    spaceBetween: gapTablet,
                },
                1024: {
                    slidesPerView: desktop,
                    spaceBetween: gapDesktop,
                },
            },
        });

    });

});