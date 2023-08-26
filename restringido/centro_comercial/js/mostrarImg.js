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

console.log(deleteIcons);
console.log(imagenSelecArray);
console.log(fileInputs);


deleteIcons.forEach((deleteIcon, index) => {
    deleteIcon.addEventListener("click", function() {
        fileInputs[index].value = "";
        imagenSelecArray[index].src = "";
    });

    fileInputs[index].addEventListener("change", function(event) {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
            const objectURL = URL.createObjectURL(selectedFile);
            imagenSelecArray[index].src = objectURL;
        }
    });
});

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

