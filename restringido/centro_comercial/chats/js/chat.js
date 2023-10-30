let currentNotification;
const fileInput = document.getElementById('add_file');
const sendBtn = document.getElementById('submit_message');
const adminButton = document.getElementById('adminBttn');

document.addEventListener('DOMContentLoaded', async function () {
    verificarSeleccion();
    var buttons = document.querySelectorAll('.options_aside');
    function onButtonClick(event) {
        buttons.forEach(function (button) {
            button.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
    }

    buttons.forEach(function (button) {
        button.addEventListener('click', onButtonClick);
    });

    fetchChats('Usuarios')
        .then(() => {
            if (contactos) {
                waitForConnection()
                    .then(() => {
                        actualizarChatsContacto();
                    })
                    .catch(err => {
                        console.error('Error: ', err);
                    });
                sendBtn.addEventListener('click', async function (e) {
                    e.preventDefault();
                    if(textArea.value === '' || textArea.value.trim() === '') return;
                    let message = textArea.value;
                    textArea.value = '';
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
                            waitForConnection()
                                .then(() => {
                                    connection.invoke("JoinGroupChat", dataCreacionChat.idChat.toString())
                                        .then(() => {
                                            chatId = dataCreacionChat.idChat;
                                        })
                                        .catch(err => {
                                            console.error("Hubo un problema al unirse al chat: ", err);
                                        });
                                })
                                .catch(err => {
                                    console.error("Hubo un problema en la conexion:", err);
                                })
                        }
                    }
                    else 
                    {
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
                                waitForConnection()
                                .then(() => {
                                    connection.invoke("JoinGroupChat", dataCreacionChat.idChat.toString())
                                        .then(() => {
                                            chatId = dataCreacionChat.idChat;
                                        })
                                        .catch(err => {
                                            console.error("Hubo un problema al unirse al chat: ", err);
                                        });
                                })
                                .catch(err => {
                                    console.error("Error en la conexion:", err);
                                })
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
        
                connection.on('Leave', function (mensaje) {
                    console.log("OnLeave: ", mensaje);
                });
        
                connection.on('Notify', function (message) {
                    console.log(message);
                })

                waitForConnection()
                    .then(() => {
                        cambiarChatCreated(true);
                    })
                    .catch(err => {
                        console.error("Error al activar ChatCreated:", err);
                    })

                connection.on('RecieveMessage', function (mensaje, chat) {
                    crearMensaje(mensaje, idUser, gerenteId, chatId);
                    actualizarContacto(mensaje.contenido, gerenteId, chat.idChat);
                    
                })
            }
            if(adminButton)
            {
                adminButton.addEventListener('click', async function(){
                    waitForConnection()
                        .then(async () => {
                            if(chatId !== 0 && chatId !== null)
                            {
                                await connection.invoke("LeaveGroupChat", chatId);
                            }
                            chatId = 0;
                            gerenteId = 0;
                            verificarSeleccion();

                            await fetchChats(adminButton.textContent)
                            if(adminButton.dataset.chatId)
                            {
                                chatId = adminButton.dataset.chatId
                                console.log(chatId);
                                let formData = new FormData();
                                formData.append("idChat", chatId);
                                const responseChat = await fetch('actualizar_chat.php', {
                                    method: 'POST',
                                    body: formData
                                })
            
                                if (!responseChat.ok) {
                                    
                                    showNotificationError("Hubo un error al mandar la solicitud al servidor");
                                    throw new Error(`HTTP error! Status: ${responseChat.status}`);
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
                                    connection.invoke("JoinGroupChat", chatId)
                                    .catch(err => {
                                        console.error("Hubo un problema al unirse al chat: ", err);
                                    });
                                }

                            }
                            else
                            {
                                console.log(adminButton.dataset.adminId);
                            }
                        })
                        .catch(err => {
                            console.error("Error:", err);
                        });
                });
            }
        })
        .catch(err => {
            console.error("Error:", err);
        });

    waitForUserData()
        .catch(err => {
            console.error(err);
        });
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
    let fechaMensaje = fecha.endsWith('Z') ? new Date(fecha) : new Date(fecha + 'Z');
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
    console.log(gerenteId);
    let contactoGerente = document.querySelector(`[data-gerente-id="${gerenteId}"]`);
    if (contactoGerente) {
        contactoGerente.removeAttribute('data-gerente-id');
        contactoGerente.setAttribute('data-chat-id', chatId);
    }
    else {
        contactoGerente = document.querySelector(`[data-chat-id="${chatId}"]`);
    }

    if(contactoGerente)
    {
        let mensajeContacto = contactoGerente.querySelector('.message_preview');
        mensajeContacto.textContent = message;
        moverChatPrincipio(contactoGerente);
    }
}

function crearMensaje(mensaje, idUser, gerenteId, chatId) {
    waitForUserData()
        .then(() => {
            let fechaFormateada = formatearFecha(mensaje.fechaMensaje);
            
            if (mensaje.isImage === true || mensaje.isImage === "true") {
                if (mensaje.typeRemitente === "Tienda" || (mensaje.idRemitente.toString() === idUser && mensaje.typeRemitente === userType)) {
                    createOutMsgWithImage(mensaje.contenido, fechaFormateada);
                }
                else {
                    createRecievedMsgWithImage(mensaje.contenido, fechaFormateada)
                }
            }
            else {
                if (mensaje.typeRemitente === "Tienda" || (mensaje.idRemitente.toString() === idUser && mensaje.typeRemitente === userType)) {
                    createOutMsg(mensaje.contenido, fechaFormateada);
                }
                else {
                    createRecievedMsg(mensaje.contenido, fechaFormateada);
                }
            }
            scrollToBottom();
        })
        .catch(err => {
            console.error('Error al recuperar los datos del usuario: ', err);
        })
}


async function waitForUserData() {
    return new Promise((resolve, reject) => {
        if(idUser !== 0 && idUser !== null && userType !== '' && userType !== null)
        {
            resolve();
            return;
        }
        else
        {
            fetch('obtencion_id_user.php', {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                idUser = data.idUser;
                userType = data.typeUser;
            })
            .then(() => {
                resolve();
                return;
            })
            .catch(err => {
                reject(err);
            });
        }
    })
}

async function cambiarChatCreated(activar) {
    if (activar)
    {
        connection.on('ChatCreated', function (chat, mensaje) {
            console.log("Mensaje: ", mensaje);
            console.log("Chat", chat);
            let contactoSelect = document.querySelector('.contacto.select');
            if(contactoSelect)
            {
                let contactoSelectContainer = contactoSelect.closest('.contacto_content');
                console.log(contactoSelectContainer);
                console.log(contactoSelectContainer.dataset);
                if(contactoSelectContainer && (
                    (contactoSelectContainer.dataset.gerenteId == chat.idMiembro1 && chat.typeMiembro1 === "Gerente") || 
                    (contactoSelectContainer.dataset.gerenteId == chat.idMiembro2 && chat.typeMiembro2 === "Gerente")))
                {
                    console.log('entro al primer if');
                    crearMensaje(mensaje, idUser, gerenteId, chat.idChat);
                }
            }
            
            if(chat.typeMiembro1 === "Usuario" || chat.typeMiembro2 === "Usuario")
            {
                console.log('entro al segundo if');
                CreateContacto(chat);
                actualizarChatsContacto();
            }
            else if (chat.typeMiembro1 === "Gerente" || chat.typeMiembro2 === "Gerente")
            {
                console.log('entro al tercer if');
                actualizarContacto(mensaje.contenido, gerenteId, chat.idChat);
            }
            
        });
        console.log("Se activo chatCreated");
    }
    else
    {
        connection.off('ChatCreated');
        console.log("Se desactivo chatCreated");
    }
}