let searchBox = document.getElementById('s');
const optionsAside = document.querySelectorAll('.options_aside');
const bodyAside = document.querySelector('.body-aside');
const msgArea = document.querySelector('.mssg-area');
const textArea = document.getElementById('expanding_textarea');
var contactos = document.querySelectorAll('.contacto_content');

const token = document.cookie
.split("; ")
.find(p => p.startsWith("SessionToken="))
?.split("=")[1];
let idUser = 0;
let userType = '';
let gerenteId = 0;
let chatId = 0;

function verificarSeleccion() {
    var textAreaContainer = document.querySelector('.text-area'); // contenedor del textarea
    const seleccionado = document.querySelector('.contacto.select'); // Busca un elemento con ambas clases.
    const adminBttnSeleccionado = document.querySelector('#adminBttn.selected');

    if ((!seleccionado && !adminButton) || (!seleccionado && (adminButton && !adminBttnSeleccionado))) {
        textAreaContainer.style.display = 'none';
        verificarSpan(true);
    } else {
        textAreaContainer.style.display = 'block';
        verificarSpan(false);
    }
}

function verificarSpan(seleccionado)
{
    let spanSeleccionTienda = document.getElementById('span-seleccion-tienda'); // letrero "Seleccione un chat"
    if (spanSeleccionTienda)
    {
        spanSeleccionTienda.style.display = (seleccionado) ? 'block' : 'none';
    }
    else
    {
        let divSpan = document.createElement('div');
        spanSeleccionTienda = document.createElement('span');
        spanSeleccionTienda.id = 'span-seleccion-tienda';
        spanSeleccionTienda.textContent = 'Seleccione un chat';
        divSpan.appendChild(spanSeleccionTienda);
        msgArea.appendChild(divSpan);
        spanSeleccionTienda.style.display = (seleccionado) ? 'block' : 'none';
    }
}

const connection = new signalR.HubConnectionBuilder()
.withUrl('https://ustoreapi.azurewebsites.net/chatHub', {
    accessTokenFactory: () => token
})
.build();

document.addEventListener('DOMContentLoaded', function () {
    scrollToBottom();

    connection.start()
        .then(() => {
            console.log('Conexion con SignalR exitosa');
        })
        .catch(err => {
            console.error('Error al conectarse con SignalR: ', err);
        });
    var content = document.getElementById('contentTextarea');
    var textarea = document.getElementById('expanding_textarea');
    var textAreaContainer = document.querySelector('.text-area'); // contenedor del textarea
    var lineHeight = 24; // altura aproximada de una línea de texto, depende del tamaño de tu fuente y el diseño, es necesario ajustarlo adecuadamente
    var maxLines = 5; // número máximo de líneas antes de mostrar el scroll

    textarea.addEventListener('input', function () {
        // Resetea el campo de altura en caso de que se reduzca
        textarea.style.height = 'auto';
        textAreaContainer.style.padding = '0px';
        textarea.style.height = '0px';
        content.style.height = '60%';

        var numberOfLines = textarea.scrollHeight / lineHeight;

        if (numberOfLines <= 1) {
            textarea.style.height = '100%'; // si solo hay una línea, el textarea toma el 100% de la altura
        } else if (numberOfLines <= maxLines) {
            textarea.style.height = (textarea.scrollHeight) + 'px'; // si hay de 2 a 6 líneas, ajusta la altura para mostrar todas las líneas
            content.style.height = (textarea.scrollHeight) + 'px'; // ajusta la altura del contenedor para igualar la del textarea
            textAreaContainer.style.height = 'auto'; // permite que el contenedor crezca con el textarea
            textAreaContainer.style.padding = '10px';
        } else {
            textarea.style.height = (lineHeight * maxLines) + 'px'; // limita la altura al número de líneas máximas
            content.style.height = (lineHeight * maxLines) + 'px'; // igual con el contenedor
            textAreaContainer.style.height = 'auto'; // permite que el contenedor crezca con el textarea
            textAreaContainer.style.padding = '10px';
        }
    });
});

function scrollToBottom() {
    const chatArea = document.querySelector(".mssg-area");
    chatArea.scrollTop = chatArea.scrollHeight;

    /*
     *Esta función selecciona el área del chat y establece su propiedad scrollTop al valor de scrollHeight. 
     *El scrollTop es la cantidad de desplazamiento hacia abajo, 
     *y scrollHeight es la altura total del contenido dentro del elemento, incluyendo el contenido no visible. 
     *Al igualar estos valores, desplazas el contenido del chat hacia abajo.
     */
}

searchBox.addEventListener('keyup', function () {
    let busqueda = searchBox.value.toLowerCase();
    let typeChat = document.querySelector('.options_aside.selected').textContent;
    let contactos = document.querySelectorAll('.contacto_content');
    let contactosNombres = document.querySelectorAll('.contact_name');

    if(busqueda.trim() !== "")
    {
        waitForConnection()
        .then(() => {
            cambiarChatCreated(false)
                .then(() => {
                    let contactosFiltered = [];
                    contactos.forEach(contacto => {
                        let nombre = contacto.querySelector('.contact_name').textContent;
                        if(nombre.toLowerCase().includes(busqueda)){
                            contactosFiltered.push(contacto);
                        }
                    });
                    
                    contactosFiltered.sort(function (a, b) {
                        let nombreA = a.querySelector('.contact_name').textContent.toLowerCase();
                        let nombreB = b.querySelector('.contact_name').textContent.toLowerCase();
                        return nombreA.localeCompare(nombreB);
                    });
            
                    contactos.forEach(contacto => {
                        contacto.style.display = 'none';
                    });
            
                    contactosFiltered.forEach(contactoFiltrado => {
                        contactoFiltrado.style.display = 'block';
                    });
                })
                .catch(err => {
                    console.error(err);
                });
        })
        .catch(err => {
            console.error(err);
        })
    }
    else
    {
        waitForConnection()
            .then(() => {
                contactos.forEach(contacto => {
                    contacto.style.display = 'block';
                });
                cambiarChatCreated(true);
            })
            .catch(err => {
                console.error(err);
            })
    }
})

optionsAside.forEach(option => {
    option.addEventListener('click', async function () {
        bodyAside.innerHTML = '';
        msgArea.innerHTML = '';
        await fetchChats(option.textContent);
        waitForConnection()
            .then(() => {
                actualizarChatsContacto();
                verificarSeleccion();
            })
            .catch(err => {
                console.error('Error:', err);
            });
    })
})

function CreateContacto(chat) {
    let divContactoContent = document.createElement('div');
    divContactoContent.classList.add('contacto_content');
    divContactoContent.dataset.chatId = chat.idChat;

    let divInitialState = document.createElement('div');
    divInitialState.classList.add('initial_state');

    let divContacto = document.createElement('div');
    divContacto.classList.add('contacto');

    let divContactProfileImg = document.createElement('div');
    divContactProfileImg.classList.add('contact_profile_img');

    let imgContactImg = document.createElement('img');
    imgContactImg.src = chat.imagenUsuario;
    imgContactImg.setAttribute('alt', "Imagen de perfil del contacto");

    let divContactInfo = document.createElement('div');
    divContactInfo.classList.add('contact_info');

    let divContactName = document.createElement('div');
    divContactName.classList.add('contact_name');
    divContactName.textContent = chat.nombreUsuario;

    let divMessagePreview = document.createElement('div');
    divMessagePreview.classList.add('message_preview');
    divMessagePreview.textContent = chat.ultimoMensaje;

    divContactProfileImg.appendChild(imgContactImg);
    divContacto.appendChild(divContactProfileImg);
    divContactInfo.appendChild(divContactName);
    divContactInfo.appendChild(divMessagePreview);
    divContacto.appendChild(divContactInfo);
    divInitialState.appendChild(divContacto);
    
    let divHoverState = document.createElement('div');
    divHoverState.classList.add('hover_state');

    let divContactoHover = document.createElement('div');
    divContactoHover.classList.add('contacto');

    let divContactProfileImgHover = document.createElement('div');
    divContactProfileImgHover.classList.add('contact_profile_img');
    
    let imgContactProfileImgHover = document.createElement('img');
    imgContactProfileImgHover.src = chat.imagenTienda;
    imgContactProfileImgHover.setAttribute('alt', "Imagen de perfil de tienda");
    
    let divContactInfoHover = document.createElement('div');
    divContactInfoHover.classList.add('contact_info');

    let divContactNameHover = document.createElement('div');
    divContactNameHover.classList.add('contact_name');
    divContactNameHover.textContent = chat.tiendaNameChat;
    
    divContactProfileImgHover.appendChild(imgContactProfileImgHover);
    divContactInfoHover.appendChild(divContactNameHover);
    divContactoHover.appendChild(divContactProfileImgHover);
    divContactoHover.appendChild(divContactInfoHover);
    divHoverState.appendChild(divContactoHover);

    divContactoContent.appendChild(divInitialState);
    divContactoContent.appendChild(divHoverState);

    bodyAside.appendChild(divContactoContent);

    contactos = document.querySelectorAll('.contacto_content');
    contactos.forEach(contacto => {
        contacto.addEventListener('click', () => {
            let contactosUsers = document.querySelectorAll('.contacto');
            contactosUsers.forEach(item => {
                item.classList.remove('select');
            });
            let contactoContentUser = contacto.querySelector('.contacto');
            contactoContentUser.classList.add('select');
            verificarSeleccion();
        });
    })
}

function CreateContactoGerente(gerente) {
    let divContactoContent = document.createElement('div');
    divContactoContent.classList.add('contacto_content');
    divContactoContent.dataset.gerenteId = gerente.idGerente;

    let divInitialState = document.createElement('div');
    divInitialState.classList.add('initial_state');

    let divContacto = document.createElement('div');
    divContacto.classList.add('contacto');

    let divContactProfileImg = document.createElement('div');
    divContactProfileImg.classList.add('contact_profile_img');

    let imgContactImg = document.createElement('img');
    imgContactImg.src = gerente.iconoPerfil;
    imgContactImg.setAttribute('alt', "Imagen de perfil del contacto");

    let divContactInfo = document.createElement('div');
    divContactInfo.classList.add('contact_info');

    let divContactName = document.createElement('div');
    divContactName.classList.add('contact_name');
    divContactName.textContent = gerente.nombre;

    let divMessagePreview = document.createElement('div');
    divMessagePreview.classList.add('message_preview');
    divMessagePreview.textContent = "Comenzar chat.";

    divContactProfileImg.appendChild(imgContactImg);
    divContacto.appendChild(divContactProfileImg);
    divContactInfo.appendChild(divContactName);
    divContactInfo.appendChild(divMessagePreview);
    divContacto.appendChild(divContactInfo);
    divInitialState.appendChild(divContacto);
    
    let divHoverState = document.createElement('div');
    divHoverState.classList.add('hover_state');

    let divContactoHover = document.createElement('div');
    divContactoHover.classList.add('contacto');

    let divContactProfileImgHover = document.createElement('div');
    divContactProfileImgHover.classList.add('contact_profile_img');
    
    let imgContactProfileImgHover = document.createElement('img');
    imgContactProfileImgHover.src = gerente.tiendaImage;
    imgContactProfileImgHover.setAttribute('alt', "Imagen de perfil de tienda");
    
    let divContactInfoHover = document.createElement('div');
    divContactInfoHover.classList.add('contact_info');

    let divContactNameHover = document.createElement('div');
    divContactNameHover.classList.add('contact_name');
    divContactNameHover.textContent = gerente.tiendaName;
    
    divContactProfileImgHover.appendChild(imgContactProfileImgHover);
    divContactInfoHover.appendChild(divContactNameHover);
    divContactoHover.appendChild(divContactProfileImgHover);
    divContactoHover.appendChild(divContactInfoHover);
    divHoverState.appendChild(divContactoHover);

    divContactoContent.appendChild(divInitialState);
    divContactoContent.appendChild(divHoverState);

    bodyAside.appendChild(divContactoContent);

    contactos = document.querySelectorAll('.contacto_content');
    contactos.forEach(contacto => {
        contacto.addEventListener('click', () => {
            let contactosUsers = document.querySelectorAll('.contacto');
            contactosUsers.forEach(item => {
                item.classList.remove('select');
            });
            let contactoContentUser = contacto.querySelector('.contacto');
            contactoContentUser.classList.add('select');
            verificarSeleccion();
        });
    })
}


async function fetchChats(typeChat) {
    const chatsResponse = await fetch('aside_' + typeChat.toLowerCase() + '.php', {
        method: 'POST'
    });
    if (!chatsResponse.ok) {
        console.error('Hubo un error al actualizar los chats');
    }
    const chatsData = await chatsResponse.json();

    if (chatsData.status !== 'success') {
        console.error(chatsData.message);
    }
    else {
        let chats;
        switch (typeChat) {
            case 'Usuarios':
                chats = chatsData.chatsUsuario;
                chats.forEach(chat => {
                    CreateContacto(chat, contactos);
                });
                break;
            case 'Gerentes':
                gerentesConChat = chatsData.gerentesConChat;
                gerentesSinChat = chatsData.gerentesSinChat;
                gerentesConChat.forEach(gerente => {
                    CreateContacto(gerente.chat);
                });
                gerentesSinChat.forEach(gerente => {
                    CreateContactoGerente(gerente);
                });
                break;
            case 'Administrador':
                chats = chatsData.chatAdministrador;
                let adminBtn = document.getElementById('adminBttn');
                adminBtn.removeAttribute('data-admin-id');
                adminBtn.dataset.chatId = chats.idChat;
                break;
        }
    }
}

function actualizarChatsContacto() {
    contactos.forEach(contacto => {
        contacto.addEventListener('click', async function () {
            if(chatId !== 0 && chatId !== null)
            {
                await connection.invoke("LeaveGroupChat", chatId);
            }
            chatId = 0;
            gerenteId = 0;
            let contactosUsersChats = document.querySelectorAll('.contacto');
            contactosUsersChats.forEach(item => {
                item.classList.remove('select');
            });
            let contactoContentUser = contacto.querySelector('.contacto');
            contactoContentUser.classList.add('select');
            verificarSeleccion();

            if (contacto.dataset.chatId) {
                chatId = contacto.dataset.chatId
                console.log(chatId);
                let formData = new FormData();
                formData.append("idChat", chatId);
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
                    connection.invoke("JoinGroupChat", chatId)
                    .catch(err => {
                        console.error("Hubo un problema al unirse al chat: ", err);
                    });
                }

            }
            else {
                gerenteId = contacto.dataset.gerenteId;
                msgArea.innerHTML = '';
                console.log(gerenteId);
            }
        })
    })
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

async function waitForConnection() {
    return new Promise((resolve, reject) => {
        if(connection.state === signalR.HubConnectionState.Connected) {
            resolve();
            return;
        }
        if(connection.state === signalR.HubConnectionState.Disconnected) {
            connection.start()
                .then(resolve)
                .catch(reject);
            return;
        } 
        if(connection.state === signalR.HubConnectionState.Connecting) {
            const checkStateInterval = setInterval(() => {
                if (connection.state === signalR.HubConnectionState.Connected) {
                    clearInterval(checkStateInterval);
                    resolve();
                }
                else if (connection.state === signalR.HubConnectionState.Disconnected) {
                    clearInterval(checkStateInterval);
                    reject(new Error("Fallo al conectar con signalR"));
                }
            }, 100);

            return;
        }
    })
}

