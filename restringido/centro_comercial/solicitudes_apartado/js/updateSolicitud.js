let currentNotification;

const btnAprobar = document.querySelectorAll(".aprobar");
const btnRechazar = document.querySelectorAll(".rechazar");

const urlParams = new URLSearchParams(window.location.search);
const idTienda = urlParams.get('id');

const connection = new signalR.HubConnectionBuilder()
    .withUrl(`https://ustoreapi.azurewebsites.net/apartadosHub?idTienda=${idTienda}`)
    .build();

connection.on("RecieveSolicitudes", function (solicitudes) {
    const solicitudesContainer = document.getElementById("lista");
    solicitudes.forEach(solicitud => {
        console.log(solicitud);
        const solicitudHTML = generateSolicitudHTML(solicitud);
        console.log(solicitudHTML);
        solicitudesContainer.innerHTML += solicitudHTML;
        btnAprobar = document.querySelectorAll(".aprobar");
        btnRechazar = document.querySelectorAll(".rechazar");
    });
});

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
    })
    .catch(err => {
        console.error('Error al conectarse con SignalR', err);
    });
console.log('entro al js');


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

function generateSolicitudHTML(solicitud) {
    return `
        <div class="item">
            <img src="${solicitud.imageProducto}" alt="">
            <p><label>${solicitud.personalizado ? 'Personalizado' : ''}</label>
                ${solicitud.nombreProducto}
            </p>
            <p>$${solicitud.precioProducto}</p>
            <p>${solicitud.periodoApartado}</p>
            <p>${solicitud.ratioUsuario}</p>
            <p>${solicitud.unidadesProducto}</p>
            <p><i id="aprobar" data-solicitud-id="${solicitud.idSolicitud}" style="color: green;" class='bx bxs-check-circle aprobar'></i></p>
            <p><i id="rechazar" data-solicitud-id="${solicitud.idSolicitud}" style="color: #d30303;" class='bx bxs-x-circle rechazar'></i></p>
        </div>
    `;
}