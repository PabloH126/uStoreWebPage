document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const items = document.querySelectorAll('.gerentes');

    botonEdicion.addEventListener('click', function () {
        items.forEach(function (elemento) {
            elemento.classList.add('edit');
        });
    });
});