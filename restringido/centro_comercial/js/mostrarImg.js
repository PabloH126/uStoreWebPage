const imagenInput = document.getElementById('logoTienda');

const imagenInput1 = document.getElementById('fileInput1');
const imagenInput2 = document.getElementById('fileInput2');
const imagenInput3 = document.getElementById('fileInput3');
const imagenInput4 = document.getElementById('fileInput4');
const imagenInput5 = document.getElementById('fileInput5');

const imagenMostrada = document.getElementById('imagenSelec');

const imagenMostrada1 = document.getElementById('imagenSelec1');
const imagenMostrada2 = document.getElementById('imagenSelec2');
const imagenMostrada3 = document.getElementById('imagenSelec3');
const imagenMostrada4 = document.getElementById('imagenSelec4');
const imagenMostrada5 = document.getElementById('imagenSelec5');


//LOGO DE TIENDA E IMAGENES EXTRA DE PRODUCTO
if (imagenInput && imagenMostrada) {
    imagenInput.addEventListener('change', (event) => {
        const imagenSeleccionada = event.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada.src = imagenURL;
        }
    });
}
if (imagenInput4 && imagenMostrada4) {
    imagenInput4.addEventListener('change', (event) => {
        const imagenSeleccionada = event.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada4.src = imagenURL;
        }
    });
}
if (imagenInput5 && imagenMostrada5) {
    imagenInput5.addEventListener('change', (event) => {
        const imagenSeleccionada = event.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada5.src = imagenURL;
        }
    });
}


//3 IMAGENES BANNER TIENDA/PRODUCTO
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

deleteIcons.forEach((icon) => {
    icon.addEventListener('click', () => {
        const inputId = icon.getAttribute('data-input-id');
        const imgId = icon.getAttribute('data-img-id');

        const inputElement = document.getElementById(inputId);
        const imgElement = document.getElementById(imgId);

        // Aquí borramos la imagen mostrada y también reseteamos el valor del input de archivo
        if(inputElement && imgElement)
        {
            imgElement.src = '';
            inputElement.value = '';
        }
        
    });
});
