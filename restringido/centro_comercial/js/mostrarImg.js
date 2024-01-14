let currentNotification;
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
        imagenMostrada.src = "";
        const imagenSeleccionada = event.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada.src = imagenURL;
        }
    });
}
if (imagenInput4 && imagenMostrada4) {
    imagenInput4.addEventListener('change', (event) => {
        imagenMostrada4.src = "";
        const imagenSeleccionada = event.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada4.src = imagenURL;
        }
    });
}
if (imagenInput5 && imagenMostrada5) {
    imagenInput5.addEventListener('change', (event) => {
        imagenMostrada5.src = "";
        const imagenSeleccionada = event.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada5.src = imagenURL;
        }
    });
}


//3 IMAGENES BANNER TIENDA/PRODUCTO
imagenInput1.addEventListener('change', (event) => {
    imagenMostrada1.src = "";
    const imagenSeleccionada = event.target.files[0];

    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada1.src = imagenURL;
    }
});

imagenInput2.addEventListener('change', (event) => {
    imagenMostrada2.src = "";
    const imagenSeleccionada = event.target.files[0];

    if (imagenSeleccionada) {
        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        imagenMostrada2.src = imagenURL;
    }
});


imagenInput3.addEventListener('change', (event) => {
    imagenMostrada3.src = "";
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
        const inputElement = document.getElementById(inputId);

        const imgSelecId = icon.getAttribute('data-img-id');
        const imagenSelecElement = document.getElementById(imgSelecId);

        const imgGuardadaId = icon.getAttribute('data-imgG-id');
        const imagenIdElement = document.getElementById(imgGuardadaId);

        // Aquí borramos la imagen mostrada y también reseteamos el valor del input de archivo
        if(inputElement && imagenSelecElement)
        {
            if(imagenIdElement && imagenIdElement.value !== "0")
            {
                imagenIdElement.dataset.estadoImagen = "eliminada";
            }

            imagenSelecElement.src = '';
            inputElement.value = '';
        }
        
    });
});

async function deleteImages(url)
{
    const idImagenesDelete = document.querySelectorAll('.idImagenes');
    
    for (const idImagen of idImagenesDelete) {
        const inputId = idImagen.dataset.inputId;
        const inputElement = document.getElementById(inputId);

        if (idImagen.dataset.estadoImagen == "eliminada" && inputElement.files.length <= 0)
        {
            const formData = new FormData();
            formData.append("idImagen", idImagen.value);

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status !== 'success')
                {
                    showNotificationError(`Hubo un error al eliminar la imagen: ${data.message}`);
                }
            })
            .catch(error => {
                console.error("Hubo un error con la petición fetch:", error);
                showNotificationError("Error al intentar eliminar la imagen.");
            });
        }
    }
    
}

function showNotification(message) {
    if (currentNotification) {
        currentNotification.remove();
    }

    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    document.body.appendChild(notification);
    
    currentNotification = notification;
}

function hideNotification() {
    if (currentNotification) {
        currentNotification.remove();
    }

    currentNotification = null;
}

function showNotificationError(message) {
    if (currentNotification) {
        currentNotification.remove();
    }
    const notification = document.createElement("div");
    notification.classList.add("notificationError");
    notification.textContent = message;
    document.body.appendChild(notification);

    currentNotification = notification;
    setTimeout(() => {
        notification.classList.add("notificationErrorHide");
        setTimeout(() => {
            hideNotification();
        }, 550);
    }, 2500);
}