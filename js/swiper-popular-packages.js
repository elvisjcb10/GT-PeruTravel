var swiperPopular = new Swiper(".mySwiperPopular", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: false,
    navigation: {
        nextEl: ".custom-next-popular",
        prevEl: ".custom-prev-popular",
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