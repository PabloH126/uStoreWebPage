
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
        link.setAttribute('href', 'https://www.projectmugen.com/index.html');
        link.style.pointerEvents = 'auto'; // Habilita el clic en el enlace
        linkEnabled = true;
    }

    function deshabilitarLink() {
        link.removeAttribute('href');
        link.style.pointerEvents = 'none'; // Deshabilita el clic en el enlace
        linkEnabled = false;
    }
});

/**
<a id="myLink" href="#"><img width="60%" class="logo" src="<?php echo $gerente['iconoPerfil'] ?>"></a>
<button onclick="toggleLink()">Habilitar/Deshabilitar Link</button>

document.addEventListener('DOMContentLoaded', function () {
    const botonEdicion = document.querySelector('.edicionGerente');
    const items = document.querySelectorAll('.item');
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
        link.setAttribute('href', '#');
        link.style.pointerEvents = 'auto'; // Habilita el clic en el enlace
        link.style.opacity = '1'; // Restaura la opacidad
        linkEnabled = true;
    }

    function deshabilitarLink() {
        link.removeAttribute('href');
        link.style.pointerEvents = 'none'; // Deshabilita el clic en el enlace
        link.style.opacity = '0.5'; // Cambia la opacidad para indicar que está deshabilitado
        linkEnabled = false;
    }
});


 */