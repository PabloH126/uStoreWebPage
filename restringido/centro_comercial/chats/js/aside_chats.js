// Selecciona todos los elementos con la clase .contacto
const contactos = document.querySelectorAll('.contacto');

// Agrega un controlador de eventos a cada elemento .contacto
contactos.forEach(contacto => {
    contacto.addEventListener('click', () => {
        // Elimina la clase .select de todos los elementos .contacto
        contactos.forEach(item => {
            item.classList.remove('select');
        });
        // Agrega la clase .select al elemento seleccionado
        contacto.classList.add('select');
    });
});


document.addEventListener('DOMContentLoaded', function() {
    
    var content = document.getElementById('contentTextarea');
    var textarea = document.getElementById('expanding_textarea');
    var textAreaContainer = document.querySelector('.text-area'); // contenedor del textarea
    var lineHeight = 24; // altura aproximada de una línea de texto, depende del tamaño de tu fuente y el diseño, es necesario ajustarlo adecuadamente
    var maxLines = 5; // número máximo de líneas antes de mostrar el scroll

    textarea.addEventListener('input', function() {
        // Resetea el campo de altura en caso de que se reduzca
        textarea.style.height = 'auto';

        var numberOfLines = textarea.scrollHeight / lineHeight;

        if (numberOfLines <= 1) {
            textarea.style.height = '100%'; // si solo hay una línea, el textarea toma el 100% de la altura
        } else if (numberOfLines <= maxLines) {
            textarea.style.height = (textarea.scrollHeight) + 'px'; // si hay de 2 a 6 líneas, ajusta la altura para mostrar todas las líneas
            content.style.height = (textarea.scrollHeight) + 'px'; // ajusta la altura del contenedor para igualar la del textarea
            textAreaContainer.style.height = 'auto'; // permite que el contenedor crezca con el textarea
        } else {
            textarea.style.overflowY = 'scroll'; // muestra el scroll si hay más de 6 líneas
            textarea.style.height = (lineHeight * maxLines) + 'px'; // limita la altura al número de líneas máximas
            content.style.height = (lineHeight * maxLines) + 'px'; // igual con el contenedor
            textAreaContainer.style.height = 'auto'; // permite que el contenedor crezca con el textarea
        }
    });
});
