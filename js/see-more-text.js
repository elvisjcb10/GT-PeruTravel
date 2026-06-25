// ver mas texto

const verMasBtn = document.getElementById('verMasBtn');
const diasExtra = document.getElementById('dias-extra');

verMasBtn.addEventListener('click', () => {
    diasExtra.classList.toggle('hidden');
    verMasBtn.textContent = diasExtra.classList.contains('hidden') ?
        'Ver más días' :
        'Ver menos días';
});