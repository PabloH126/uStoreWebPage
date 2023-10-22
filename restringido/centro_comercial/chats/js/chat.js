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
    const idAdmin = idData.idAdmin;

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
                        msgArea.innerHTML = '';
                        mensajes.forEach(mensaje => {
                            crearMensaje(mensaje, idUser, gerenteId, chatId);
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

                const dataCreacionMensaje = await responseCreacionMensaje.json();
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

                    const dataCreacionMensaje = await responseCreacionMensaje.json();

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
            console.log(gerenteId, chat.idChat);
            crearMensaje(mensaje, idUser, gerenteId, chat.idChat)
        });

        connection.on('RecieveMessage', function (mensaje) {
            console.log(mensaje);
            crearMensaje(mensaje, idUser, gerenteId, chatId);
        })
    }

    var adminButton = document.getElementById('adminBttn');

    // Crear una instancia de observer con la función callback que se ejecutará en cada mutación
    const observer = new MutationObserver(mutationCallback);

    // Opciones de configuración para el observer: observar cambios de atributos
    const config = { attributes: true, attributeFilter: ['class'] };

    // Empezar a observar el botón con la configuración dada
    if (adminButton) {
        observer.observe(adminButton, config);
    } else {
        console.error("El botón de administrador no se encontró en el DOM");
    }

});

function mutationCallback(mutationsList, observer) {
    for (let mutation of mutationsList) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
            var adminButton = document.getElementById('adminBttn');
            var textAreaContainer = document.querySelector('.text-area');
            var buscador = document.querySelector('.cajabuscar');

            if (adminButton && adminButton.classList.contains('selected')) {
                console.log("la tiene c:");
                buscador.style.display = 'none';
                textAreaContainer.style.display = 'block';
                document.getElementById('span-seleccion-tienda').style.display = 'none'
                
/*tener todos los chats que tiene el gerente y de esos
                cada chat tiene tipe miembro 1 y 2 
                ponemos los chats que tiene el gerente que tenga el tipe miembro 1 o 2 = administrador

                si hay, se pone el data set chat id en el boton de administrador, si no
                no se pone nada y solo se abre el chat

                cuando se abra el chat se pone el el boton
*//*
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
                        msgArea.innerHTML = '';
                        mensajes.forEach(mensaje => {
                            crearMensaje(mensaje, idUser, gerenteId, chatId);
                        })
                    }

                }
                else {
                    gerenteId = contacto.dataset.gerenteId;
                    console.log(gerenteId);
                }
*/
            } else {
                buscador.style.display = 'block';
                textAreaContainer.style.display = 'none';
                document.getElementById('span-seleccion-tienda').style.display = 'block'
                console.log("no la tiene :c");
            }
        }
    }
}

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

function formatearFecha(fecha) {
    let fechaMensaje = new Date(fecha);
    let opciones = {
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        timeZoneName: 'short'
    };
    let fechaFormat = new Intl.DateTimeFormat('es', opciones);
    let partesFecha = fechaFormat.formatToParts(fechaMensaje);
    let hora = partesFecha.find(part => part.type === 'hour').value;
    let minuto = partesFecha.find(part => part.type === 'minute').value;
    let dia = partesFecha.find(part => part.type === 'day').value;
    let mes = partesFecha.find(part => part.type === 'month').value;
    let fechaFormateada = `${hora}:${minuto} | ${mes} ${dia}`;
    return fechaFormateada;
}

function moverChatPrincipio(element) {
    const listaContactos = element.parentNode;

    listaContactos.removeChild(element);
    listaContactos.insertBefore(element, listaContactos.firstChild);
}

function actualizarContacto(message, gerenteId, chatId) {
    let contactoGerente = document.querySelector(`[data-gerente-id="${gerenteId}"]`);
    if (contactoGerente) {
        contactoGerente.removeAttribute('data-gerente-id');
        contactoGerente.setAttribute('data-chat-id', chatId);
    }
    else {
        contactoGerente = document.querySelector(`[data-chat-id="${chatId}"]`);
    }
    let mensajeContacto = contactoGerente.querySelector('.message_preview');
    mensajeContacto.textContent = message;
    console.log(mensajeContacto);
    console.log(contactoGerente);
    moverChatPrincipio(contactoGerente);
}

function crearMensaje(mensaje, idUser, gerenteId, chatId) {
    let fechaFormateada = formatearFecha(mensaje.fechaMensaje);
    console.log(fechaFormateada);
    if (mensaje.isImage === true || mensaje.isImage === "true") {
        if (idUser == mensaje.idRemitente) {
            createOutMsgWithImage(mensaje.contenido, fechaFormateada);
        }
        else {
            createRecievedMsgWithImage(mensaje.contenido, fechaFormateada)
        }

    }
    else {
        if (idUser == mensaje.idRemitente) {
            createOutMsg(mensaje.contenido, fechaFormateada);
        }
        else {
            createRecievedMsg(mensaje.contenido, fechaFormateada);
        }
    }
    console.log(gerenteId, chatId, mensaje.contenido);
    actualizarContacto(mensaje.contenido, gerenteId, chatId);
}