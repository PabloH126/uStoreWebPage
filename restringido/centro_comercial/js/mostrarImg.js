const imagenInput = document.getElementById('logoTienda');

const imagenInput1 = document.getElementById('fileInput1');
const imagenInput2 = document.getElementById('fileInput2');
const imagenInput3 = document.getElementById('fileInput3');

const imagenMostrada = document.getElementById('imagenSelec');

const imagenMostrada1 = document.getElementById('imagenSelec1');
const imagenMostrada2 = document.getElementById('imagenSelec2');
const imagenMostrada3 = document.getElementById('imagenSelec3');

/*Borrar imagenes*/
const deleteIcons = document.querySelectorAll(".delete-icon");
const imagenSelecArray = document.querySelectorAll(".imagen-selec");
const fileInputs = document.querySelectorAll(".file-input");


imagenInput.addEventListener('change', (event) => {
    const imagenSeleccionada = event.target.files[0];
    
    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada.src = imagenURL;
    }
});

imagenInput1.addEventListener('change', (event) => {
    const imagenSeleccionada = event.target.files[0];
    
    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada1.src = imagenURL;
    }
});

imagenInput2.addEventListener('change', (event) => {
    const imagenSeleccionada = event.target.files[0];
    
    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada2.src = imagenURL;
    }
});


imagenInput3.addEventListener('change', (event) => {
    const imagenSeleccionada = event.target.files[0];
    
    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada3.src = imagenURL;
    }
});

