// Menu hamburguesa funcional
document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.getElementById("menu-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const closeMenuBtn = document.getElementById("closeMenuBtn");
    const menuPanel = document.getElementById("menu-panel");

    // Abrir menú
    menuBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        mobileMenu.classList.remove("hidden");
        mobileMenu.classList.add("flex");
    });

    // Cerrar con la X
    closeMenuBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        mobileMenu.classList.add("hidden");
        mobileMenu.classList.remove("flex");
    });

    // Cerrar al tocar fuera del panel
    mobileMenu.addEventListener("click", (e) => {
        if (!menuPanel.contains(e.target)) {
            mobileMenu.classList.add("hidden");
            mobileMenu.classList.remove("flex");
        }
    });

    // Submenús móviles (acordeón)
    document.querySelectorAll(".toggle-submenu").forEach(button => {
        button.addEventListener("click", () => {
            const submenu = button.nextElementSibling;
            const icon = button.querySelector("span");

            submenu.classList.toggle("hidden");

            // Cambiar + por −
            icon.textContent = submenu.classList.contains("hidden") ? "+" : "−";
        });
    });



});