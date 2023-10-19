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


// Espera a que el DOM se cargue completamente
document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.getElementById('expanding_textarea');
    textarea.addEventListener('input', function() {
      // Resetea el campo de altura en caso de que se reduzca
      this.style.height = 'auto';
  
      // Ajusta la altura del textarea al scroll height, que es la altura completa del contenido
      this.style.height = (this.scrollHeight) + 'px';
    });
  });
  