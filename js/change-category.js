// lógica de cambio dinámico
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".category-item").forEach(el => {
        el.addEventListener("click", () => {
            const cat = el.dataset.category;
            document.getElementById("titulo-text").textContent = data[cat].titulo;
            document.getElementById("dias-paquete").textContent = data[cat].dias;
            document.getElementById("descripcion").textContent = data[cat].descripcion;
            document.getElementById("precio").textContent = data[cat].precio;
            document.getElementById("nota-precio").textContent = data[cat].nota;

            // efecto visual
            document.querySelectorAll(".category-item h3").forEach(h3 => h3.classList.remove("text-black"));
            el.querySelector("h3").classList.add("text-black");
        });
    });
});