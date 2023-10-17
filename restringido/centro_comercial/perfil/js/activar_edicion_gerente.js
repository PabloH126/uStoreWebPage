
document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const items = document.querySelectorAll('.gerentes');

    const link = document.getElementById('myLink');
    let linkEnabled = true;

    botonEdicion.addEventListener('click', function () {
        items.forEach(function (elemento) {
            if (elemento.classList.contains('edit')) {
                elemento.classList.remove('edit');
                deshabilitarLink();
            } else {
                elemento.classList.add('edit');
                habilitarLink();
            }
        });
    });

    function habilitarLink() {
        link.setAttribute('href', 'edicion_gerente.php');
        link.style.pointerEvents = 'auto'; // Habilita el clic en el enlace
        linkEnabled = true;
    }

    function deshabilitarLink() {
        link.removeAttribute('href');
        link.style.pointerEvents = 'none'; // Deshabilita el clic en el enlace
        linkEnabled = false;
    }
});