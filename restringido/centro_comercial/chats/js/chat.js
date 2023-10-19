const msgArea = document.querySelector('.mssg-area');
const textArea = document.getElementById('expanding_textarea');
const fileInput = document.getElementById('add_file');
const sendBtn = document.getElementById('submit_message');
const token = document.cookie
    .split("; ")
    .find(p => p.startsWith("SessionToken="))
    ?.split("=")[1];

const connection = new signalR.HubConnectionBuilder()
    .withUrl('https://ustoreapi.azurewebsites.net/chatHub', {
        accessTokenFactory: () => token
    })
    .build();


if(contactos)
{
        connection.start()
        .then(() => {
            console.log('Conexion con SignalR exitosa');
            connection.invoke("JoinUserChats")
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
}

contactos.forEach(contacto => {
    contacto.addEventListener('click', async function () {
        if (contacto.dataset.chatId)
        {
            console.log(contacto.dataset.chatId);
            await fetch('actualizar_chat.php', {

            })
        }
        else {
            console.log(contacto.dataset.gerenteId);
        }
    })
})

connection.on('NameGroup', function (nombre) {
    console.log(nombre);
})


sendBtn.addEventListener('click', async function(e) {
    e.preventDefault();
    let message = textArea.value;
    if (message === "") return;
    function formatTwoDigits(n) {
        return n < 10 ? '0' + n : n;
    }
    
    // Crear un nuevo objeto de fecha (contendrá la fecha y hora actual)
    var now = new Date();
    
    // Obtener horas, minutos, mes y día
    var hours = formatTwoDigits(now.getHours());
    var minutes = formatTwoDigits(now.getMinutes());
    var month = now.toLocaleString('default', { month: 'long' }); // Nombre completo del mes en el idioma local
    var day = now.getDate();
    
    // Formatear la fecha y hora en el formato deseado "HH:MM | mes dia"
    var formattedDateTime = hours + ':' + minutes + ' | ' + month + ' ' + day;
    textArea.value = "";
    if(isRecieved)
    {
        createOutMsg(message, formattedDateTime);
        isRecieved = false;
    }
    else
    {
        createOutMsg(message, formattedDateTime);
        isRecieved = true;
    }
    
})

fileInput.addEventListener('change', async function () {
    if (await imagenesValidacion())
    {
        const imagenURL = URL.createObjectURL(fileInput.files[0]);
        function formatTwoDigits(n) {
            return n < 10 ? '0' + n : n;
        }
        // Crear un nuevo objeto de fecha (contendrá la fecha y hora actual)
        var now = new Date();

        // Obtener horas, minutos, mes y día
        var hours = formatTwoDigits(now.getHours());
        var minutes = formatTwoDigits(now.getMinutes());
        var month = now.toLocaleString('default', { month: 'long' }); // Nombre completo del mes en el idioma local
        var day = now.getDate();

        // Formatear la fecha y hora en el formato deseado "HH:MM | mes dia"
        var formattedDateTime = hours + ':' + minutes + ' | ' + month + ' ' + day;
        createOutMsgWithImage(imagenURL, formattedDateTime);
    }

    fileInput.value = "";
})


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
    if(fileInput.files.length && !validacionTypeImagen(fileInput))
    {
        showNotificationError(`La imagen no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
        return false;
    }
    else if (fileInput.files.length && !validacionSizeImagen(fileInput, maxSize))
    {
        showNotificationError(`La imagen es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
        return false;
    }
    return true;
}

function validacionSizeImagen(imagen, maxSize) {
    if(imagen.files[0].size > maxSize)
    {
        return false;
    }

    return true;
}

function validacionTypeImagen(imagen)
{
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (allowedTypes.indexOf(imagen.files[0].type) === -1) {
        return false;
    }

    return true;
}