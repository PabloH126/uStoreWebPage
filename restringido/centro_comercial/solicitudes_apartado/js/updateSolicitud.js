let currentNotification;
document.addEventListener("DOMContentLoaded", function() {
    const btnAprobar = document.querySelectorAll(".aprobar");
    const btnRechazar = document.querySelectorAll(".rechazar");

    btnAprobar.forEach(btn => {
        btn.addEventListener("click", function () {
            UpdateSolicitud('activa', btn.dataset.solicitudId, this.closest('.item'));
        });
    })

    btnRechazar.forEach(btn => {
        btn.addEventListener("click", function () {
            UpdateSolicitud('rechazada', btn.dataset.solicitudId, this.closest('.item'));
        })
    })
});

async function UpdateSolicitud(status, idSolicitud, elementClicked)
{
    const formData = new FormData();
    formData.append('statusSolicitud', status);
    formData.append('idSolicitud', idSolicitud);
    await fetch("updateSolicitud.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.status === 'success')
        {
            //window.location.reload();
            elementClicked.classList.add('bounceRight');
            elementClicked.addEventListener('animationend', () => {
                elementClicked.remove();
            })
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