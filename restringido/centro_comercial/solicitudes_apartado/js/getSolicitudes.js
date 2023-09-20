const connection = new signalR.HubConnectionBuilder()
    .withUrl("/apartadosHub")
    .build();

connection.on("RecieveSolicitudes", function (solicitudes) {
    solicitudes.forEach(solicitud =>{
        console.log(solicitud);
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