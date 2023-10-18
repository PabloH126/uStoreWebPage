let divsContacto = document.querySelectorAll('.contacto');

const token = document.cookie
    .split("; ")
    .find(p => p.startsWith("SessionToken="))
    ?.split("=")[1];

const connection = new signalR.HubConnectionBuilder()
    .withUrl('https://ustoreapi.azurewebsites.net/chatHub', {
        accessTokenFactory: () => token
    })
    .build();

    
if(divsContacto)
{
    divsContacto.forEach(chat => {
        let idChat = chat.querySelector('.idchat');
        connection.start()
        .then(() => {
            console.log('Conexion con SignalR exitosa');
            connection.invoke("JoinGroupChat", idChat)
            .then(() => {
                console.log('Conexion con JoinGroupChat exitosa con el id:', idChat);
            })
            .catch(err => {
                console.error('Hubo un error al conectarse con JoinGroupChat: ', err);
            });
        })
        .catch(err => {
            console.error('Error al conectarse con SignalR: ', err);
        });

    })
}