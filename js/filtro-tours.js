document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll(".filtro-tour-btn");
    const cards = document.querySelectorAll(".tour-card");

    botones.forEach(btn => {
        btn.addEventListener("click", () => {

            // actualizar estilos activos
            botones.forEach(b => {
                b.classList.remove("bg-orange-custom", "text-white", "border-orange-custom");
                b.classList.add("bg-white", "text-gray-700", "border-gray-300");
            });
            btn.classList.remove("bg-white", "text-gray-700", "border-gray-300");
            btn.classList.add("bg-orange-custom", "text-white", "border-orange-custom");

            const filtro = btn.dataset.filtro;

            cards.forEach(card => {
                if (filtro === "todos" || card.dataset.categoria === filtro) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });
});