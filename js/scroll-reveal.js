document.addEventListener("DOMContentLoaded", () => {
    const elementos = document.querySelectorAll(
        ".reveal, .reveal-left, .reveal-right, .reveal-fade, .reveal-zoom"
    );

    if (!("IntersectionObserver" in window)) {
        // Fallback: si el navegador no soporta IntersectionObserver, muestra todo directo
        elementos.forEach(el => el.classList.add("reveal-visible"));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("reveal-visible");
                observer.unobserve(entry.target); // solo se anima una vez
            }
        });
    }, {
        threshold: 0.15,        // se activa cuando el 15% del elemento es visible
        rootMargin: "0px 0px -50px 0px" // se activa un poco antes de llegar al final
    });

    elementos.forEach(el => observer.observe(el));
});