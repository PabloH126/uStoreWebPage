
document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const items = document.querySelectorAll('.gerentes');

    const link = document.getElementById('myLink');
    let linkEnabled = true;

    botonEdicion.addEventListener('click', function () {
        items.forEach(function (elemento) {
            let idGerente = elemento.querySelector('.idGerente').value;
            console.log(idGerente);
            if (elemento.classList.contains('edit')) {
                elemento.classList.remove('edit');
                deshabilitarLink();
            } else {
                elemento.classList.add('edit');
                habilitarLink();
            }
        });
    });

    function habilitarLink(idGerente) {
        link.setAttribute('href', 'https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/edicion_gerente.php?id=' + idGerente);
        link.style.pointerEvents = 'auto'; // Habilita el clic en el enlace
        linkEnabled = true;
    }

    function deshabilitarLink() {
        link.removeAttribute('href');
        link.style.pointerEvents = 'none'; // Deshabilita el clic en el enlace
        linkEnabled = false;
    }
});