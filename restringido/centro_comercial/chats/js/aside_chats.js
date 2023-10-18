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
    const textarea = document.getElementById('messageInput');
    const lineHeight = 24; // Adjust this value according to your text area's line height
    const minRows = 1;
    const maxRows = 5;

    let rows = textarea.value.split('\n').length;
    if (rows < minRows) {
        rows = minRows;
    } else if (rows > maxRows) {
        rows = maxRows;
    }
    textarea.rows = rows;
}
