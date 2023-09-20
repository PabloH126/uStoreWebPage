const urlParams = new URLSearchParams(window.location.search);
const idTienda = urlParams.get('id');

const connection = new signalR.HubConnectionBuilder()
    .withUrl("https://ustoreapi.azurewebsites.net/apartadosHub")
    .build();

connection.on("RecieveSolicitudes", function (solicitudes) {
    const solicitudesContainer = document.getElementById("lista");
    solicitudes.forEach(solicitud => {
        console.log(solicitud);
        const solicitudHTML = generateSolicitudHTML(solicitud);
        console.log(solicitudHTML);
        solicitudesContainer.innerHTML += solicitudHTML;
    });
});

connection.start()
    .then(() => {
        console.log('Conexion con SignalR exitosa');
        connection.invoke("JoinGroupTienda", idTienda);
    })
    .catch(err => {
        console.error('Error al conectarse con SignalR', err);
    });
console.log('entro al js');

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
