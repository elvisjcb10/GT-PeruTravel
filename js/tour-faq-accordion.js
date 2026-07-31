document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".faq-toggle").forEach(btn => {
        btn.addEventListener("click", () => {
            const panel = btn.nextElementSibling;
            const icon = btn.querySelector(".faq-icon");
            const isOpen = !panel.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
            btn.setAttribute("aria-expanded", String(isOpen));
        });
    });
});