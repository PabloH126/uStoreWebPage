const imagenInput = document.getElementById('logoTienda');

const imagenInput1 = document.getElementById('fileInput1');
const imagenInput2 = document.getElementById('fileInput2');
const imagenInput3 = document.getElementById('fileInput3');

const imagenMostrada = document.getElementById('imagenSelec');

const imagenMostrada1 = document.getElementById('imagenSelec1');
const imagenMostrada2 = document.getElementById('imagenSelec2');
const imagenMostrada3 = document.getElementById('imagenSelec3');

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

const deleteIcons = document.querySelectorAll('.delete-icon');

deleteIcons.forEach((icon, index) => {
    icon.addEventListener('click', () => {
        // Aquí borramos la imagen mostrada y también reseteamos el valor del input de archivo
        switch (index) {
            case 0:
                imagenMostrada.src = '';
                imagenInput.value = '';
                break;
            case 1:
                imagenMostrada1.src = '';
                imagenInput1.value = '';
                break;
            case 2:
                imagenMostrada2.src = '';
                imagenInput2.value = '';
                break;
            case 3:
                imagenMostrada3.src = '';
                imagenInput3.value = '';
                break;
            default:
                break;
        }
    });
});
