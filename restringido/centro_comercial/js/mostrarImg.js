const imagenInput = document.getElementById('logoTienda');

const imagenInput1 = document.getElementById('fileInput1');
const imagenInput2 = document.getElementById('fileInput2');
const imagenInput3 = document.getElementById('fileInput3');

const imagenMostrada = document.getElementById('imagenSelec');

imagenInput.addEventListener('change', (event) => {
    const imagenSeleccionada = event.target.files[0];
    
    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada.src = imagenURL;
    }
});
