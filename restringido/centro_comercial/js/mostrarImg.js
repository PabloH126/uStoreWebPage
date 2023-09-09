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
        const imgGuardadaId = icon.getAttribute('data-imgG-id');
        const imgIdElement = document.getElementById(imgGuardadaId);
        const inputElement = document.getElementById(inputId);
        const imgElement = document.getElementById(imgId);
        icon.disabled = true;
        // Aquí borramos la imagen mostrada y también reseteamos el valor del input de archivo
        if(inputElement && imgElement)
        {
            if(imgIdElement && imgIdElement.value !== "0")
            {
                const formData = new FormData();
                formData.append("idImagen", imgIdElement.value);
                fetch('../tiendas/eliminar_imagen_tienda.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success')
                    {
                        showNotification('Imagen eliminada con exito');
                        imgIdElement = null;
                        imgIdElement.value = null;
                        setTimeout(() => {
                            hideNotification();
                        }, 1500);
                    }
                    else
                    {
                        showNotificationError(`Hubo un error al eliminar la imagen: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error("Hubo un error con la petición fetch:", error);
                    showNotificationError("Error al intentar eliminar la imagen.");
                });
            }

            imgElement.src = '';
            inputElement.value = '';
        }
        
    });
});

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