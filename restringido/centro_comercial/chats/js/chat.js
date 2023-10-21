let currentNotification;
const msgArea = document.querySelector('.mssg-area');
const textArea = document.getElementById('expanding_textarea');
const fileInput = document.getElementById('add_file');
const sendBtn = document.getElementById('submit_message');

document.addEventListener('DOMContentLoaded', async function () {
    const responseId = await fetch('obtencion_id_user.php', {
        method: 'POST',
    });
    const idData = await responseId.json();
    const idUser = idData.idUser;

    console.log(idUser);
    let gerenteId = 0;
    let chatId = 0;
    const token = document.cookie
        .split("; ")
        .find(p => p.startsWith("SessionToken="))
        ?.split("=")[1];

    const connection = new signalR.HubConnectionBuilder()
        .withUrl('https://ustoreapi.azurewebsites.net/chatHub', {
            accessTokenFactory: () => token
        })
        .build();


    if (contactos) {
        connection.start()
            .then(() => {
                console.log('Conexion con SignalR exitosa');
            })
            .catch(err => {
                console.error('Error al conectarse con SignalR: ', err);
            });

        contactos.forEach(contacto => {
            contacto.addEventListener('click', async function () {
                if (contacto.dataset.chatId) {
                    chatId = contacto.dataset.chatId
                    console.log(chatId);
                    let formData = new FormData();
                    formData.append("idChat", contacto.dataset.chatId);
                    const responseChat = await fetch('actualizar_chat.php', {
                        method: 'POST',
                        body: formData
                    })

                    if (!responseChat.ok) {
                        showNotificationError("Hubo un error al mandar la solicitud al servidor");
                        return;
                    }

                    let responseChatData = await responseChat.json();

                    if (responseChatData.status !== "success") {
                        showNotificationError(responseChatData.message);
                        return;
                    }
                    else {
                        let mensajes = responseChatData.message;

                        mensajes.forEach(mensaje => {
                            if (mensaje.isRecieved === true || mensaje.isRecieved === "true") {
                                if (mensaje.isImage === true || mensaje.isImage === "true") {
                                    createRecievedMsgWithImage(mensaje.contenido, mensaje.fechaMensaje);
                                }
                                else {
                                    createRecievedMsg(mensaje.contenido, mensaje.fechaMensaje);
                                }
                            }
                            else {
                                if (mensaje.isImage === true || mensaje.isImage === "true") {
                                    createOutMsgWithImage(mensaje.contenido, mensaje.fechaMensaje);
                                }
                                else {
                                    createOutMsg(mensaje.contenido, mensaje.fechaMensaje);
                                }
                            }
                        })
                    }

                }
                else {
                    gerenteId = contacto.dataset.gerenteId;
                    console.log(gerenteId);
                }
            })
        })

        sendBtn.addEventListener('click', async function (e) {
            e.preventDefault();
            let message = textArea.value;
            if (gerenteId !== 0 && chatId === 0) {
                console.log(gerenteId);
                let formData = new FormData();
                formData.append("idMiembro2", gerenteId);
                formData.append("typeMiembro2", "Gerente");
                formData.append("contenidoMensaje", message);
                formData.append("imagen", fileInput.files[0]);
                const responseCreacionChat = await fetch('crear_chat.php', {
                    method: 'POST',
                    body: formData
                });

                if (!responseCreacionChat.ok) {
                    showNotificationError('Hubo un error al mandar la solicitud al servidor');
                    return;
                }

                const dataCreacionChat = await responseCreacionChat.json();

                if (dataCreacionChat.status !== "success") {
                    showNotificationError(dataCreacionChat.message);
                    return;
                }
                else {
                    if (connection.state === signalR.HubConnectionState.Connected) {
                        connection.stop()
                            .then(() => {
                                console.log("Conexion cerrada");
                                connection.start()
                                    .then(() => {
                                        connection.invoke("JoinGroupChat", dataCreacionChat.idChat.toString())
                                        .then(() => {
                                            console.log("Unido al chat: ", dataCreacionChat.idChat);
                                            chatId = dataCreacionChat.idChat;
                                        })
                                        .catch(err => {
                                            console.error("Hubo un problema al unirse al chat: ", err);
                                        });
                                    })
                                    .catch(err => {
                                        console.error("Hubo un problema al establecer la nueva conexion:", err);
                                    })
                            })
                            .catch(err => {
                                console.error("Hubo un problema al cerrar la conexion: ", err);
                            })
                    }
                }
            }
            else {
                console.log(chatId);
                let formData = new FormData();
                formData.append('idChat', chatId);
                formData.append("contenidoMensaje", message);
                const responseCreacionMensaje = await fetch('crear_mensaje.php', {
                    method: 'POST',
                    body: formData
                });

                if (!responseCreacionMensaje.ok) {
                    showNotificationError("Hubo un error al mandar la solicitud al servidor");
                    return;
                }

                const dataCreacionMensaje = responseCreacionMensaje.json();
                console.log(dataCreacionMensaje);
                if (dataCreacionMensaje.status !== "success") {
                    showNotificationError(dataCreacionMensaje.message);
                    return;
                }
            }

        });

        fileInput.addEventListener('change', async function () {
            if (await imagenesValidacion()) {
                if (gerenteId !== 0 && chatId === 0) {
                    console.log(gerenteId);
                    let formData = new FormData();
                    formData.append("idMiembro2", gerenteId);
                    formData.append("typeMiembro2", "Gerente");
                    formData.append("imagen", fileInput.files[0]);
                    const responseCreacionChat = await fetch('crear_chat.php', {
                        method: 'POST',
                        body: formData
                    });

                    if (!responseCreacionChat.ok) {
                        showNotificationError('Hubo un error al mandar la solicitud al servidor');
                        return;
                    }

                    const dataCreacionChat = responseCreacionChat.json();

                    if (dataCreacionChat.status !== "success") {
                        showNotificationError(dataCreacionChat.message);
                        return;
                    }
                    else {
                        if (connection.state === signalR.HubConnectionState.Connected) {
                            connection.stop()
                                .then(() => {
                                    console.log("Conexion cerrada");
                                    connection.start()
                                        .then(() => {
                                            connection.invoke("JoinGroupChat", dataCreacionChat.idChat.toString())
                                            .then(() => {
                                                console.log("Unido al chat: ", dataCreacionChat.idChat);
                                                chatId = dataCreacionChat.idChat;
                                            })
                                            .catch(err => {
                                                console.error("Hubo un problema al unirse al chat: ", err);
                                            });
                                        })
                                        .catch(err => {
                                            console.error("Hubo un problema al establecer la nueva conexion:", err);
                                        })
                                })
                                .catch(err => {
                                    console.error("Hubo un problema al cerrar la conexion: ", err);
                                })
                        }
                    }
                }
                else {
                    console.log(chatId);
                    let formData = new FormData();
                    formData.append('idChat', chatId);
                    formData.append("imagen", fileInput.files[0]);
                    const responseCreacionMensaje = await fetch('crear_mensaje.php', {
                        method: 'POST',
                        body: formData
                    });
        
                    if (!responseCreacionMensaje.ok) {
                        showNotificationError("Hubo un error al mandar la solicitud al servidor");
                        return;
                    }
        
                    const dataCreacionMensaje = responseCreacionMensaje.json();
        
                    if (dataCreacionMensaje.status !== "success") {
                        showNotificationError(dataCreacionMensaje.message);
                        return;
                    }
                }
            }

            fileInput.value = "";
        })

        connection.on('NameGroup', function (nombre) {
            console.log(nombre);
        });

        connection.on('Notify', function (message) {
            console.log(message);
        })

        connection.on('ChatCreated', function (chat, mensaje) {
            console.log('entro al chat created');
            console.log(chat);
            console.log(mensaje);

            if (mensaje.isImage === true || mensaje.isImage === "true") {
                if (idUser == mensaje.idRemitente) {
                    createOutMsgWithImage(mensaje.contenido, mensaje.fechaMensaje);
                }
                else {
                    createRecievedMsgWithImage(mensaje.contenido, mensaje.fechaMensaje)
                }

            }
            else {
                if (idUser == mensaje.idRemitente) {
                    createOutMsg(mensaje.contenido, fechaMensaje);
                }
                else {
                    createRecievedMsg(mensaje.contenido, fechaMensaje);
                }
            }
        });

        connection.on('RecieveMessage', function (mensaje) {
            console.log(mensaje);
            if (mensaje.isImage === true || mensaje.isImage === "true") {
                if (idUser == mensaje.idRemitente) {
                    createOutMsgWithImage(mensaje.contenido, mensaje.fechaMensaje);
                }
                else {
                    createRecievedMsgWithImage(mensaje.contenido, mensaje.fechaMensaje)
                }

            }
            else {
                if (idUser == mensaje.idRemitente) {
                    createOutMsg(mensaje.contenido, fechaMensaje);
                }
                else {
                    createRecievedMsg(mensaje.contenido, fechaMensaje);
                }
            }
        })
    }
});

function createRecievedMsg(message, recievedDate) {
    let divRecieved = document.createElement('div');
    divRecieved.classList.add('received-msg');

    let recievedMsgInbox = document.createElement('div');
    recievedMsgInbox.classList.add('received-msg-inbox');

    let recievedBox = document.createElement('p');
    recievedBox.classList.add('recived-box-msg');
    recievedBox.textContent = message;

    let timeSpan = document.createElement('span');
    timeSpan.classList.add('time');
    timeSpan.textContent = recievedDate;

    recievedMsgInbox.appendChild(recievedBox);
    recievedMsgInbox.appendChild(timeSpan);
    divRecieved.appendChild(recievedMsgInbox);

    msgArea.appendChild(divRecieved);
}

function createRecievedMsgWithImage(image, recievedDate) {
    let divRecieved = document.createElement('div');
    divRecieved.classList.add('received-msg');

    let recievedMsgInbox = document.createElement('div');
    recievedMsgInbox.classList.add('received-msg-inbox');

    let recievedBox = document.createElement('div');
    recievedBox.classList.add('recived-box-msg');

    let imgMessage = document.createElement('img');
    imgMessage.src = image;

    let timeSpan = document.createElement('span');
    timeSpan.classList.add('time');
    timeSpan.textContent = recievedDate;

    recievedBox.appendChild(imgMessage);
    recievedMsgInbox.appendChild(recievedBox);
    recievedMsgInbox.appendChild(timeSpan);
    divRecieved.appendChild(recievedMsgInbox);

    msgArea.appendChild(divRecieved);
}

function createOutMsg(message, recievedDate) {
    let outGoingMsg = document.createElement('div');
    outGoingMsg.classList.add('outgoing-msg');

    let outGoingChatsMsg = document.createElement('div');
    outGoingChatsMsg.classList.add('outgoing-chats-msg');

    let outGoingBoxMsg = document.createElement('p');
    outGoingBoxMsg.classList.add('outgoing-box-msg');
    outGoingBoxMsg.textContent = message;

    let timeSpan = document.createElement('span');
    timeSpan.classList.add('time');
    timeSpan.textContent = recievedDate;

    outGoingChatsMsg.appendChild(outGoingBoxMsg);
    outGoingChatsMsg.appendChild(timeSpan);
    outGoingMsg.appendChild(outGoingChatsMsg);

    msgArea.appendChild(outGoingMsg);
}

function createOutMsgWithImage(image, recievedDate) {
    let outGoingMsg = document.createElement('div');
    outGoingMsg.classList.add('outgoing-msg');

    let outGoingChatsMsg = document.createElement('div');
    outGoingChatsMsg.classList.add('outgoing-chats-msg');

    let outGoingBoxMsg = document.createElement('div');
    outGoingBoxMsg.classList.add('outgoing-box-msg');

    let imgOutGoingMsg = document.createElement('img');
    imgOutGoingMsg.src = image;

    let timeSpan = document.createElement('span');
    timeSpan.classList.add('time');
    timeSpan.textContent = recievedDate;

    outGoingBoxMsg.appendChild(imgOutGoingMsg);
    outGoingChatsMsg.appendChild(outGoingBoxMsg);
    outGoingChatsMsg.appendChild(timeSpan);
    outGoingMsg.appendChild(outGoingChatsMsg);

    msgArea.appendChild(outGoingMsg);
}


function showNotification(message) {
    if (currentNotification) {
        currentNotification.remove();
    }

    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    document.body.appendChild(notification);

    currentNotification = notification;
}

function hideNotification() {
    if (currentNotification) {
        currentNotification.remove();
    }

    currentNotification = null;
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

async function imagenesValidacion() {
    const maxSize = 1 * 1024 * 1024;
    if (fileInput.files.length && !validacionTypeImagen(fileInput)) {
        showNotificationError(`La imagen no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
        return false;
    }
    else if (fileInput.files.length && !validacionSizeImagen(fileInput, maxSize)) {
        showNotificationError(`La imagen es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
        return false;
    }
    return true;
}

function validacionSizeImagen(imagen, maxSize) {
    if (imagen.files[0].size > maxSize) {
        return false;
    }

    return true;
}

function validacionTypeImagen(imagen) {
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (allowedTypes.indexOf(imagen.files[0].type) === -1) {
        return false;
    }

    return true;
}