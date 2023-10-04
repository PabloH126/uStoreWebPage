let imagenInput = document.getElementById("change_img");
let imagenPerfil = document.getElementById("profile_img");

try{
    await actualizarImagenPerfil(imagenInput, 'actualizar_imagen.php');
} catch(error) {
    console.error("Error: ", error);
    showNotificationError("Hubo un error al realizar la solicitu de actualizacion de imagen: " + error);
}

function imagenesValidacion() {
    const maxSize = 1 * 1024 * 1024;
    if(imagenInput.files.length && !validacionTypeImagen(imagenInput))
        {
            showNotificationError(`La imagen no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
            return false;
        }
        else if (imagenInput.files.length && !validacionSizeImagen(imagenInput, maxSize))
        {
            showNotificationError(`La imagen es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
            return false;
        }

    return true;
}

async function actualizarImagenPerfil(input, url){
    const formData = new FormData();
    formData.append("newImageProfile", input.files[0]);

    const responseImageProfile = await fetch(url, {
        method: 'POST',
        body: formData
    });

    if (!responseImageProfile.ok)
    {
        console.error("Error en la respuesta de actualizacion de imagen: " + responseImageProfile.statusText);
        return;
    }

    const dataImagen = await responseImageProfile.json();
    
    if(dataImagen.statusImagen !== 'success') {
        console.log("No se pudo actualizar la imagen del perfil", dataImagen.message);
    } else {
        imagenPerfil.src = dataImagen.imagenPerfil;
    }
}

function validacionSizeImagen(imagen, maxSize) {
    if(imagen.files[0].size > maxSize)
    {
        return false;
    }

    return true;
}

function validacionTypeImagen(imagen)
{
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (allowedTypes.indexOf(imagen.files[0].type) === -1) {
        return false;
    }

    return true;
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
    console.log(notification);
    currentNotification = notification;
    setTimeout(() => {
        notification.classList.add("notificationErrorHide");
        setTimeout(() => {
            hideNotification();
        }, 550);
    }, 2500);
    
}