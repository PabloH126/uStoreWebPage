
document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const items = document.querySelectorAll('.gerentes');

    botonEdicion.addEventListener('click', function () {
        items.forEach(function (elemento) {
            if (elemento.classList.contains('edit')) {
                elemento.classList.remove('edit');
            } else {
                elemento.classList.add('edit');
            }
        });
    });
});