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


function autoResize() {
    const textarea = document.getElementById('text_area');
    const numberOfLines = textarea.value.split('\n').length;

    if (numberOfLines <= 4) {
        textarea.rows = numberOfLines;
    } else {
        textarea.rows = 5; // Max 5 rows
        textarea.style.overflowY = 'scroll';
    }
}
