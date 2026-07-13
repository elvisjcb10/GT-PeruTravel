document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.getElementById("menu-btn-mobile");
    const closeBtn = document.getElementById("menu-close-btn");
    const panel = document.getElementById("mobile-menu-panel");
    const overlay = document.getElementById("mobile-menu-overlay");

    function openMenu() {
        panel.classList.remove("translate-x-full");
        overlay.classList.remove("hidden");
        document.body.style.overflow = "hidden";
    }

    function closeMenu() {
        panel.classList.add("translate-x-full");
        overlay.classList.add("hidden");
        document.body.style.overflow = "";
    }

    menuBtn?.addEventListener("click", openMenu);
    closeBtn?.addEventListener("click", closeMenu);
    overlay?.addEventListener("click", closeMenu);

    // Acordeones dentro del panel mobile
    document.querySelectorAll(".mobile-accordion-toggle").forEach(btn => {
        btn.addEventListener("click", () => {
            const accordion = btn.closest(".mobile-accordion");
            const panelItem = accordion.querySelector(".mobile-accordion-panel");
            const icon = btn.querySelector(".mobile-accordion-icon");

            // Cierra los demás acordeones abiertos (comportamiento tipo "solo uno abierto")
            document.querySelectorAll(".mobile-accordion-panel").forEach(p => {
                if (p !== panelItem) p.classList.add("hidden");
            });
            document.querySelectorAll(".mobile-accordion-icon").forEach(i => {
                if (i !== icon) i.classList.remove("rotate-180");
            });

            panelItem.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        });
    });

    // Cerrar el menú con la tecla Escape
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeMenu();
    });
});