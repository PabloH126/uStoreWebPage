document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const gerentes = document.querySelectorAll('.gerentes');

    botonEdicion.addEventListener('click', function () {
        gerentes.forEach(function (gerente) {
            let idGerente = gerente.querySelector('.idGerente').value;
            let link = gerente.querySelector('.myLink');

            if (gerente.classList.contains('edit')) {
                gerente.classList.remove('edit');
                deshabilitarLink(link);
            } else {
                gerente.classList.add('edit');
                habilitarLink(link, idGerente);
            }
        });
    });

    function habilitarLink(link, idGerente) {
        link.setAttribute('href', 'https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/edicion_gerente.php?id=' + idGerente);
        link.style.pointerEvents = 'auto'; // Habilita el clic en el enlace
    }

    function deshabilitarLink(link) {
        link.removeAttribute('href');
        link.style.pointerEvents = 'none'; // Deshabilita el clic en el enlace
    }
});