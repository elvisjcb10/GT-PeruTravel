//  swiper trip comments

new Swiper(".mySwiper", {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 2000
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: { // <<<<<<<<<<<<<<<<< Esto activa las flechas
        nextEl: ".custom-next",
        prevEl: ".custom-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1
        },
        640: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        },
    },
});