let currentNotification;

const solicitudesContainer = document.getElementById("lista");

const urlParams = new URLSearchParams(window.location.search);
const idTienda = urlParams.get('id');
const spanSolicitudes = document.getElementById('span-seleccion-tienda');
const item = document.getElementById('encabezado');
const nota = document.querySelector('.nota');

const token = document.cookie
    .split("; ")
    .find(p => p.startsWith("SessionToken="))
    ?.split("=")[1];

document.addEventListener("DOMContentLoaded", function () {
    checkSolicitudes();
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
    const notificacionesTotal = document.getElementById('number_notification');
    
    let numNotificaciones;
    for (var [idTienda, numSoli] of Object.entries(notificaciones)) {
        console.log("IdTienda: " + idTienda + ", numero de solicitudes: " + numSoli);
        numNotificaciones += numSoli;
    }

    notificacionesTotal.textContent = numNotificaciones;


});

connection.on("NameGroup", function (nombre) {
    console.log("Nombre del grupo: ", nombre);
})

solicitudesContainer.addEventListener("click", function(e) {
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