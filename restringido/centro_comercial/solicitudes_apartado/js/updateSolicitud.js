let currentNotification;
document.addEventListener("DOMContentLoaded", function() {
    const btnAprobar = document.getElementById("aprobar");
    const btnRechazar = document.getElementById("rechazar");

    btnAprobar.addEventListener("click", function (e) {
        UpdateSolicitud('activa', this.dataset.solicitudId);
    });

    btnRechazar.addEventListener("click", function(e) {
        UpdateSolicitud('rechazada', this.dataset.solicitudId);
    })
});

async function UpdateSolicitud(status, idSolicitud)
{
    const formData = new FormData();
    formData.append('statusSolicitud', status);
    formData.append('idSolicitud', idSolicitud);
    await fetch("updateSolicitud.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.status === 'success')
        {
            window.location.reload();
        }
        else
        {
            showNotificationError("Se produjo un error al cambiar la solicitud: ", data.message);
        }
    })
    .catch(error => {
        console.error("Hubo un error con la petición fetch:", error);
        showNotificationError("Error al mandar la peticion de cambio de la solicitud.");
    });
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

function hideNotification() {
    if (currentNotification) {
        currentNotification.remove();
    }

    currentNotification = null;
}