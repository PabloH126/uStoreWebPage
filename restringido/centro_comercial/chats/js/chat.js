let divsContacto = document.querySelectorAll('.contacto');
const connection = new signalR.HubConnectionBuilder()
    .WithUrl('https://ustoreapi.azurewebsites.net/chatHub')
    .build();

connection.start()
    .then(() => {
        console.log('Conexion con SignalR exitosa');

    })
    .catch(err => {
        console.error('Error al conectarse con SignalR: ', err);
    });

if(divsContacto)
{
    divsContacto.forEach(chat => {
        let idChat = chat.querySelector('.idchat');
        connection.invoke("JoinGroupChat", idChat)
        .then(() => {
            console.log('Conexion con JoinGroupChat exitosa con el id:', idChat);
        })
        .catch(err => {
            console.error('Hubo un error al conectarse con JoinGroupChat: ', err);
        });
    })
}