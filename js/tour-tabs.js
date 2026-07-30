document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll(".tab-tour-btn");
    const contenidos = document.querySelectorAll(".tab-tour-content");

    function activarTab(btn, moverFoco = false, desplazar = false) {
            botones.forEach(b => {
                b.classList.remove("bg-orange-custom", "text-white");
                b.classList.add("bg-white", "text-gray-700", "border", "border-gray-300");
                b.setAttribute("aria-selected", "false");
                b.setAttribute("tabindex", "-1");
            });
            btn.classList.remove("bg-white", "text-gray-700", "border", "border-gray-300");
            btn.classList.add("bg-orange-custom", "text-white");
            btn.setAttribute("aria-selected", "true");
            btn.setAttribute("tabindex", "0");

            const tabId = btn.dataset.tab;
            contenidos.forEach(c => {
                const oculto = c.dataset.tabContent !== tabId;
                c.classList.toggle("hidden", oculto);
                c.setAttribute("aria-hidden", String(oculto));
            });

            if (desplazar) {
                btn.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" });
            }
            if (moverFoco) btn.focus();
    }

    botones.forEach((btn, index) => {
        btn.addEventListener("click", () => activarTab(btn, false, true));

        btn.addEventListener("keydown", event => {
            if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) return;
            event.preventDefault();

            let nextIndex = index;
            if (event.key === "ArrowRight") nextIndex = (index + 1) % botones.length;
            if (event.key === "ArrowLeft") nextIndex = (index - 1 + botones.length) % botones.length;
            if (event.key === "Home") nextIndex = 0;
            if (event.key === "End") nextIndex = botones.length - 1;

            activarTab(botones[nextIndex], true, true);
        });
    });

    const activa = document.querySelector(".tab-tour-btn.active") || botones[0];
    if (activa) activarTab(activa);
});
