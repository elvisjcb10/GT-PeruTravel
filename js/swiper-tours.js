// swiper tours
var swiperTours = new Swiper(".mySwiperTours", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    // navigation: {
    //     nextEl: ".swiper-button-next",
    //     prevEl: ".swiper-button-prev",
    // },
    navigation: { // <<<<<<<<<<<<<<<<< Esto activa las flechas
        nextEl: ".custom-next-tour",
        prevEl: ".custom-prev-tour",
    },
    breakpoints: {
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        }
    }
});