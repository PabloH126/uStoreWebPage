document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const items = document.querySelectorAll('.item');

    botonEdicion.addEventListener('click', function () {
        items.forEach(function (elemento) {
            elemento.classList.add('edit');
        });
    });
});