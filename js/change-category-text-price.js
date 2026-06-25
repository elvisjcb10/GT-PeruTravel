document.addEventListener('DOMContentLoaded', () => {
    const categoryButtons = document.querySelectorAll('.category-item');
    const selectDisabled = document.getElementById('selectServicioDisabled');
    const inputCategoria = document.getElementById('inputCategoria');

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const cat = btn.getAttribute('data-category');

            // actualizar select (aunque está disabled, visualmente cambiará)
            if (selectDisabled) selectDisabled.value = cat;

            // actualizar hidden para enviar
            if (inputCategoria) inputCategoria.value = cat;
        });
    });

    // Inicial
    const inicial = 'tour';
    const inicialBtn = document.querySelector(`.category-item[data-category="${inicial}"]`);
    if (inicialBtn) inicialBtn.click();
});