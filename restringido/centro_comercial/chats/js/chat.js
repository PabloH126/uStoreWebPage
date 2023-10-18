const connection = new signalR.HubConnectionBuilder()
    .WithUrl('https://ustoreapi.azurewebsites.net/chatHub')
    .build();

connection.start()
    .then(() => {
        console.log('Conexion con SignalR exitosa');
        connection.invoke("JoinGroupChat", idChat)
            .then(() => {
                console.log('Conexion con JoinGroupChat exitosa');
            })
            .catch(err => {
                console.error('Hubo un error al conectarse con JoinGroupChat: ', err);
            });
    })
    .catch(err => {
        console.error('Error al conectarse con SignalR: ', err);
    });
