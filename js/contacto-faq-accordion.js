document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".faq-contacto-toggle").forEach(btn => {
        btn.addEventListener("click", () => {
            const panel = btn.nextElementSibling;
            const icon = btn.querySelector(".faq-contacto-icon");
            if (!panel) return;
            panel.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        });
    });
});