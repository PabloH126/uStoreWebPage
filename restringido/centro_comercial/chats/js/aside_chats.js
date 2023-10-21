document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.options_aside');
    function onButtonClick(event) {
        buttons.forEach(function (button) {
            button.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
    }

    buttons.forEach(function (button) {
        button.addEventListener('click', onButtonClick);
    });
});


const contactos = document.querySelectorAll('.contacto');

function verificarSeleccion() {
    const seleccionado = document.querySelector('.contacto.select'); // Busca un elemento con ambas clases.
    
    console.log(seleccionado);
    if (!seleccionado) {
        document.getElementById('span-seleccion-tienda').style.display = 'block'
    } else {
        document.getElementById('span-seleccion-tienda').style.display = 'none'
    }
}

contactos.forEach(contacto => {
    contacto.addEventListener('click', () => {

        contactos.forEach(item => {
            item.classList.remove('select');
        });
        
        contacto.classList.add('select');
        verificarSeleccion();
    });
});
verificarSeleccion();


document.addEventListener('DOMContentLoaded', function() {
    
    var content = document.getElementById('contentTextarea');
    var textarea = document.getElementById('expanding_textarea');
    var textAreaContainer = document.querySelector('.text-area'); // contenedor del textarea
    var lineHeight = 24; // altura aproximada de una línea de texto, depende del tamaño de tu fuente y el diseño, es necesario ajustarlo adecuadamente
    var maxLines = 5; // número máximo de líneas antes de mostrar el scroll

    textarea.addEventListener('input', function() {
        // Resetea el campo de altura en caso de que se reduzca
        textarea.style.height = 'auto';
        textAreaContainer.style.padding = '0px';
        textarea.style.height = '0px';
        content.style.height = '60%';

        var numberOfLines = textarea.scrollHeight / lineHeight;

        if (numberOfLines <= 1) {
            textarea.style.height = '100%'; // si solo hay una línea, el textarea toma el 100% de la altura
        } else if (numberOfLines <= maxLines) {
            textarea.style.height = (textarea.scrollHeight) + 'px'; // si hay de 2 a 6 líneas, ajusta la altura para mostrar todas las líneas
            content.style.height = (textarea.scrollHeight) + 'px'; // ajusta la altura del contenedor para igualar la del textarea
            textAreaContainer.style.height = 'auto'; // permite que el contenedor crezca con el textarea
            textAreaContainer.style.padding = '10px';
        } else {
            textarea.style.height = (lineHeight * maxLines) + 'px'; // limita la altura al número de líneas máximas
            content.style.height = (lineHeight * maxLines) + 'px'; // igual con el contenedor
            textAreaContainer.style.height = 'auto'; // permite que el contenedor crezca con el textarea
            textAreaContainer.style.padding = '10px';
        }
    });
});
