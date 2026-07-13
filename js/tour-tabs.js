document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll(".tab-tour-btn");
    const contenidos = document.querySelectorAll(".tab-tour-content");

    botones.forEach(btn => {
        btn.addEventListener("click", () => {
            botones.forEach(b => {
                b.classList.remove("bg-orange-custom", "text-white");
                b.classList.add("bg-white", "text-gray-700", "border", "border-gray-300");
            });
            btn.classList.remove("bg-white", "text-gray-700", "border", "border-gray-300");
            btn.classList.add("bg-orange-custom", "text-white");

            const tabId = btn.dataset.tab;
            contenidos.forEach(c => {
                c.classList.toggle("hidden", c.dataset.tabContent !== tabId);
            });
        });
    });
});