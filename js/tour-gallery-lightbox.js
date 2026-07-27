document.addEventListener("DOMContentLoaded", () => {

    const items = document.querySelectorAll(".gallery-item img");
    const lightbox = document.getElementById("gallery-lightbox");
    const lightboxImg = document.getElementById("gallery-image");
    const counter = document.getElementById("gallery-counter");
    const closeBtn = document.getElementById("gallery-close");
    const prevBtn = document.getElementById("gallery-prev");
    const nextBtn = document.getElementById("gallery-next");

    if (!items.length || !lightbox) return;

    const images = Array.from(items).map(img => img.src);
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateImage();
        lightbox.classList.remove("hidden");
        lightbox.classList.add("flex");
        document.body.style.overflow = "hidden";
    }

    function closeLightbox() {
        lightbox.classList.add("hidden");
        lightbox.classList.remove("flex");
        document.body.style.overflow = "";
    }

    function updateImage() {
        lightboxImg.src = images[currentIndex];
        counter.textContent = `${currentIndex + 1} / ${images.length}`;
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % images.length;
        updateImage();
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateImage();
    }

    document.querySelectorAll(".gallery-item").forEach((btn, index) => {
        btn.addEventListener("click", () => openLightbox(index));
    });

    closeBtn.addEventListener("click", closeLightbox);
    nextBtn.addEventListener("click", showNext);
    prevBtn.addEventListener("click", showPrev);

    // Cerrar al hacer clic fuera de la imagen
    lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    // Navegación con teclado
    document.addEventListener("keydown", (e) => {
        if (lightbox.classList.contains("hidden")) return;
        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowRight") showNext();
        if (e.key === "ArrowLeft") showPrev();
    });

});