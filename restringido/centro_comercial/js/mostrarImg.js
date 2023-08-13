const imagenInput = document.getElementById('logoTienda');
const imagenMostrada = document.getElementById('imagenSelec');

imagenInput.addEventListener('change', (event) => {
    const imagenSeleccionada = event.target.files[0];
    
    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada.src = imagenURL;
    }
});
