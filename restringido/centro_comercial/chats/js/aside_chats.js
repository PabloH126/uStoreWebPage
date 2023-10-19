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
    
   /* var content = document.getElementById('contentTextarea');
    var textarea = document.getElementById('expanding_textarea');*/
/*/
    textarea.addEventListener('input', function() {
      // Resetea el campo de altura en caso de que se reduzca
      this.style.height = 'auto';
      content.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';

      if(this.scrollHeight < 30){
        content.style.height = '60%';
      }else{
        content.style.height = (this.scrollHeight) + 'px';
      }
    });
    */
    const textarea = document.getElementById('expanding_textarea');
    const content = textarea.value;
    const lines = content.split('\n');
    let count = 0;

    lines.forEach(line => {
      if (line.trim() !== '') {
        count++;
      }
    });

    console.log('El número de líneas con contenido es: ' + count);
  });
  