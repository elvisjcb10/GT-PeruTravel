document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".itinerario-toggle").forEach(btn => {
        btn.addEventListener("click", () => {
            const panel = btn.nextElementSibling;
            const icon = btn.querySelector(".itinerario-icon");
            panel.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        });
    });
});