let currentNotification;

const solicitudesContainer = document.getElementById("lista");

const urlParams = new URLSearchParams(window.location.search);
const idTienda = urlParams.get('id');
const spanSolicitudes = document.getElementById('span-seleccion-tienda');
const item = document.getElementById('encabezado');
const notificacionesTotal = document.getElementById('number_notification');
const notificacionesTienda = document.querySelectorAll('.numero_solicitudes_tienda');
const contentNumberNotificacion = document.querySelector('.content_number_notification');
const timers = document.querySelectorAll(".timer");

const token = document.cookie
    .split("; ")
    .find(p => p.startsWith("SessionToken="))
    ?.split("=")[1];

document.addEventListener("DOMContentLoaded", function () {
    checkSolicitudes();
    notificacionesTienda.forEach(notificacion => {
        if (notificacion.textContent != "0")
        {
            notificacion.style.display = "";
        }
        else
        {
            notificacion.style.display = "none";
        }
    });
    if (notificacionesTotal.textContent != "0")
    {
        contentNumberNotificacion.style.display = "";
    }
    else
    {
        contentNumberNotificacion.style.display = "none";
    }

    timers.forEach(timer => {
        const time = timer.getAttribute("data-time").split(":");
        let totalSec = parseInt(time[3]) + parseInt(time[2]) * 60 + parseInt(time[1]) * 60 * 60 + parseInt(time[0]) * 24 * 60 * 60;

        setInterval(() => {
            if (totalSec <= 0) return;

            totalSec--;

            const dias = Math.floor(totalSec / (24 * 60 * 60));
            const horas = Math.floor(totalSec / (60 * 60));
            const minutos = Math.floor(totalSec / 60);
            const segundos = totalSec % 60;

            timer.textContent = `${days}:${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    });
});

solicitudesContainer.addEventListener("click", function(e) {
    let btnAprobar = e.target.closest('.solicitudesItem').querySelector('.aprobar');
    let btnRechazar = e.target.closest('.solicitudesItem').querySelector('.rechazar');
    
    if (e.target.classList.contains("aprobar")) {
        btnAprobar.style.display = "none";
        btnRechazar.style.display = "none";
        UpdateSolicitud('completada', e.target.dataset.solicitudId, e.target.closest('.solicitudesItem'));
    } else if (e.target.classList.contains("rechazar")) {
        btnAprobar.style.display = "none";
        btnRechazar.style.display = "none";
        UpdateSolicitud('cancelada', e.target.dataset.solicitudId, e.target.closest('.solicitudesItem'));
    }
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
            elementClicked.classList.remove('bounceLeft');
            elementClicked.classList.add('bounceRight');
            elementClicked.addEventListener('animationend', () => {
                elementClicked.remove();
                checkSolicitudes();
                notificacionesTotal.textContent = parseInt(notificacionesTotal.textContent) - 1;
                if(parseInt(notificacionesTotal.textContent) <= 0)
                {
                    contentNumberNotificacion.style.display = "none";
                }
                for (let i = 0; i < notificacionesTienda.length; i++)
                {
                    let idTiendaDiv = notificacionesTienda[i].closest('.menu-option').dataset.tiendaId;
                    if (parseInt(idTienda) === parseInt(idTiendaDiv))
                    {
                        notificacionesTienda[i].textContent = parseInt(notificacionesTienda[i].textContent) - 1;
                        if(parseInt(notificacionesTienda[i].textContent) > 0)
                        {
                            notificacionesTienda[i].style.display = "";
                        }
                        else
                        {
                            notificacionesTienda[i].style.display = "none";
                        }
                        break;
                    }
                }
            })
        }
        else
        {
            showNotificationError("Se produjo un error al cambiar la solicitud: ", data.message);
            
        }
    })
    .then(() => {
        
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

function checkSolicitudes() {
    let solicitudesItem = solicitudesContainer.querySelector('.solicitudesItem');
    console.log(solicitudesItem);
    console.log(spanSolicitudes);
    if (!solicitudesItem) {
        item.style.display = "none";
        spanSolicitudes.style.display = "";
    }
    else
    {
        item.style.display = "";
        spanSolicitudes.style.display = "none";
    }
}