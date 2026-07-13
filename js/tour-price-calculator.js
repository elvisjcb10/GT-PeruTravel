document.addEventListener("DOMContentLoaded", () => {
    const precioEl = document.getElementById("precio");
    const notaEl = document.getElementById("nota-precio");
    const descuentoTag = document.getElementById("descuentoTag");
    const contadorEl = document.getElementById("contadorPasajeros");
    const btnMas = document.getElementById("btnMas");
    const btnMenos = document.getElementById("btnMenos");
    const categoryItems = document.querySelectorAll(".category-item");

    let categoria = "tour";
    let pasajeros = 1;

    function parsePrecio(v) {
        if (!v) return 0;
        return parseFloat(String(v).replace(/[^0-9.]/g, "")) || 0;
    }

    function actualizarPrecio() {
        const cat = categoriasData[categoria];
        if (!cat) return;

        const base = parsePrecio(cat.precio);
        const desc = parseFloat(cat.descuento ?? 0);
        const precioFinal = base * (1 - desc / 100) * pasajeros;

        precioEl.textContent = "$" + precioFinal.toFixed(2);
        notaEl.textContent = cat.nota ?? "";

        if (desc > 0) {
            descuentoTag.textContent = `-${desc}%`;
            descuentoTag.classList.remove("hidden");
        } else {
            descuentoTag.classList.add("hidden");
        }
    }

    categoryItems.forEach(item => {
        item.addEventListener("click", () => {
            categoria = item.dataset.category;

            categoryItems.forEach(i => {
                i.classList.remove("bg-orange-custom", "text-white", "border-orange-custom");
                i.classList.add("bg-white", "text-gray-700");
            });
            item.classList.remove("bg-white", "text-gray-700");
            item.classList.add("bg-orange-custom", "text-white", "border-orange-custom");

            actualizarPrecio();
        });
    });

    btnMas.addEventListener("click", () => {
        pasajeros++;
        contadorEl.textContent = pasajeros;
        actualizarPrecio();
    });

    btnMenos.addEventListener("click", () => {
        if (pasajeros > 1) {
            pasajeros--;
            contadorEl.textContent = pasajeros;
            actualizarPrecio();
        }
    });

    actualizarPrecio();
});