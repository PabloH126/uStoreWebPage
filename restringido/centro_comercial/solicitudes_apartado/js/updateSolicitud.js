let currentNotification;

const solicitudesContainer = document.getElementById("lista");

const urlParams = new URLSearchParams(window.location.search);
const idTienda = urlParams.get('id');
const spanSolicitudes = document.getElementById('span-seleccion-tienda');
const item = document.getElementById('encabezado');
const nota = document.querySelector('.nota');
const notificacionesTotal = document.getElementById('number_notification');
const notificacionesTienda = document.querySelectorAll('.numero_solicitudes_tienda');
const contentNumberNotificacion = document.querySelector('.content_number_notification');

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
});

const connection = new signalR.HubConnectionBuilder()
    .withUrl(`https://ustoreapi.azurewebsites.net/apartadosHub?idTienda=${idTienda}`, {
        accessTokenFactory: () => token
    })
    .build();

connection.start()
    .then(() => {
        console.log('Conexion con SignalR exitosa');
        connection.invoke("JoinGroupTienda")
            .then(() => {
                console.log('Conexion con JoinGroupTienda exitosa');
            })
            .catch(err => {
                console.error('Hubo un error al entrar a JoinGroupTienda', err);
            });
        connection.invoke("SendUpdateNotificaciones")
            .then(() => {
                console.log('Conexion con updateNotificacionesSolicitudes');
            })
            .catch(err => {
                console.error('Hubo un error al entrar a updateNotificacionesSolicitudes', err);
            })
    })
    .catch(err => {
        console.error('Error al conectarse con SignalR', err);
    });

connection.on("RecieveSolicitudes", function (solicitudes) {
    solicitudes.forEach(solicitud => {
        console.log(solicitud);
        let solicitudElement = createSolicitudElement(solicitud);
        console.log(solicitudElement);
        item.style.display = "";
        nota.style.display = "";
        spanSolicitudes.style.display = "none";
        solicitudesContainer.appendChild(solicitudElement);
        console.log(solicitudesContainer);
    });
});

connection.on("RecieveUpdateNotificaciones", function (notificaciones) {
    console.log(notificaciones);
    console.log(notificacionesTotal);
    console.log(notificacionesTienda);
    let numNotificaciones = 0;

    for (var [idTiendaDictionary, numSoli] of Object.entries(notificaciones)) {
        console.log("IdTienda: " + idTiendaDictionary + ", numero de solicitudes: " + numSoli);
        numNotificaciones += numSoli;
        
        for (let i = 0; i < notificacionesTienda.length; i++)
        {
            let menuOption = notificacionesTienda[i].closest('.menu-option');
            let idTiendaDiv = menuOption.dataset.tiendaId;
            if (parseInt(idTiendaDictionary) === parseInt(idTiendaDiv))
            {
                notificacionesTienda[i].textContent = numSoli;
                notificacionesTienda[i].style.display = "";
                break;
            }
        }
    }
    if (numNotificaciones > 0)
    {
        contentNumberNotificacion.style.display = "";
        notificacionesTotal.textContent = numNotificaciones;
    }
});

connection.on("NameGroup", function (nombre) {
    console.log("Nombre del grupo: ", nombre);
})

solicitudesContainer.addEventListener("click", function(e) {
    let cancelBtn = e.target.closest('.bttn_solicitudes');
    cancelBtn.disabled = true;
    e.target.disabled = true;

    if (e.target.classList.contains("aprobar")) {
        UpdateSolicitud('activa', e.target.dataset.solicitudId, e.target.closest('.solicitudesItem'));
    } else if (e.target.classList.contains("rechazar")) {
        UpdateSolicitud('rechazada', e.target.dataset.solicitudId, e.target.closest('.solicitudesItem'));
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

function createSolicitudElement(solicitud) {
    const div = document.createElement("div");
    div.className = "item bounceLeft solicitudesItem";

    const img = document.createElement("img");
    img.src = solicitud.imageProducto;
    div.appendChild(img);

    let p = document.createElement("p");
    const label = document.createElement("label");
    label.textContent = solicitud.personalizado ? 'Personalizado' : '';
    p.appendChild(label);
    p.appendChild(document.createTextNode(` ${solicitud.nombreProducto}`));
    div.appendChild(p);

    p = document.createElement("p");
    p.textContent = `$${solicitud.precioProducto}`;
    div.appendChild(p);

    p = document.createElement("p");
    p.textContent = solicitud.periodoApartado;
    div.appendChild(p);

    p = document.createElement("p");
    p.textContent = solicitud.ratioUsuario;
    div.appendChild(p);

    p = document.createElement("p");
    p.textContent = solicitud.unidadesProducto;
    div.appendChild(p);

    p = document.createElement("p");
    const iconAprobar = document.createElement("i");
    iconAprobar.id = "aprobar";
    iconAprobar.dataset.solicitudId = solicitud.idSolicitud;
    iconAprobar.className = "bx bxs-check-circle aprobar";
    iconAprobar.style.color = "green";
    p.appendChild(iconAprobar);
    div.appendChild(p);

    p = document.createElement("p");
    const iconRechazar = document.createElement("i");
    iconRechazar.id = "rechazar";
    iconRechazar.dataset.solicitudId = solicitud.idSolicitud;
    iconRechazar.className = "bx bxs-x-circle rechazar";
    iconRechazar.style.color = "#d30303";
    p.appendChild(iconRechazar);
    div.appendChild(p);

    return div;
}

function checkSolicitudes() {
    let solicitudesItem = solicitudesContainer.querySelector('.solicitudesItem');
    if (!solicitudesItem) {
        item.style.display = "none";
        nota.style.display = "none";
        spanSolicitudes.style.display = "";
    }
    else
    {
        item.style.display = "";
        nota.style.display = "";
        spanSolicitudes.style.display = "none";
    }
}