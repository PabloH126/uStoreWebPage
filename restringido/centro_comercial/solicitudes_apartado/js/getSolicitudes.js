const connection = new signalR.HubConnectionBuilder()
    .withUrl("https://ustoreapi.azurewebsites.net/apartadosHub")
    .build();

connection.on("RecieveSolicitudes", function (solicitudes) {
    console.log('ya entro al on');
    solicitudes.forEach(solicitud =>{
        console.log(solicitud);
        console.log('ola');
    });
});

connection.start()
    .then(() => {
        console.log('Conexion con SignalR exitosa');
    })
    .catch(err => {
        console.error('Error al conectarse con SignalR', err);
    });
console.log('entro al js');