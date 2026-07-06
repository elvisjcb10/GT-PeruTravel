new Swiper(".mySwiperPopular", {
    slidesPerView: 1,
    spaceBetween: 24,
    navigation: {
        nextEl: ".custom-next-popular",
        prevEl: ".custom-prev-popular",
    },
    breakpoints: {
        640: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
    },
});