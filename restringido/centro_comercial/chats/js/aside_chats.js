let searchBox = document.getElementById('s');
const optionsAside = document.querySelectorAll('.options_aside');
const bodyAside = document.querySelector('.body-aside');

document.addEventListener('DOMContentLoaded', async function () {
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

    await fetchChats('Usuarios');

    const contactoContents = document.querySelectorAll('.contacto_content');
    contactoContents.forEach(contacto => {
        contacto.addEventListener('click', () => {
            console.log(contacto);
            let contactos = document.querySelectorAll('.contacto');
            contactos.forEach(item => {
                item.classList.remove('select');
            });
            let contactoContentUser = contacto.querySelector('.contacto');
            contactoContentUser.classList.add('select');
            verificarSeleccion();
        });
    });
    verificarSeleccion();
    
});

function verificarSeleccion() {
    var textAreaContainer = document.querySelector('.text-area'); // contenedor del textarea
    const seleccionado = document.querySelector('.contacto.select'); // Busca un elemento con ambas clases.

    if (!seleccionado) {
        textAreaContainer.style.display = 'none';
        document.getElementById('span-seleccion-tienda').style.display = 'block'
    } else {
        textAreaContainer.style.display = 'block';
        document.getElementById('span-seleccion-tienda').style.display = 'none'
    }
}

document.addEventListener('DOMContentLoaded', function () {

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

searchBox.addEventListener('keyup', async function () {
    let busqueda = searchBox.value.toLowerCase();
    let typeChat = document.querySelector('.options_aside.selected').textContent();
    await fetchChats(typeChat);
    let contactos = documment.querySelectorAll('.contact_name');
    let contadosFiltered = contactos.filter(function (contacto) {
        return contacto.textContent.toLowerCase().includes(busqueda);
    }).sort(function (a, b) {
        return a.textContent.localeCompare(b.textContent);
    });

    /*mostrar contacto*/

})

optionsAside.forEach(option => {
    option.addEventListener('click', async function () {
        bodyAside.innerHTML = '';
        console.log(option);
        console.log(option.textContent);
        await fetchChats(option.textContent);
    })
})



function CreateContacto(chat) {
    console.log(chat);
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

    divContactoContent.addEventListener('click', () => {
        console.log(contacto);
        let contactos = document.querySelectorAll('.contacto');
        contactos.forEach(item => {
            item.classList.remove('select');
        });
        let contactoContentUser = contacto.querySelector('.contacto');
        contactoContentUser.classList.add('select');
        verificarSeleccion();
    });

    bodyAside.appendChild(divContactoContent);

    /*
        <div class="contacto_content">
        ///////////////////////////////////////////////
              <div class="initial_state">
                <div class="contacto">
                  <div class="contact_profile_img">
                    <img src="https://ustoredata.blob.core.windows.net/gerentes/15.png" alt="Imagen de perfil del contacto">
                  </div>
                  <div class="contact_info">
                    <div class="contact_name">User name</div>
                    <div class="message_preview">Comenzar chat.</div>
                  </div>
                </div>
              </div>
        /////////////////////////////////////////////
              <div class="hover_state">
                <div class="contacto">
                  <div class="contact_profile_img">
                    <img src="https://ustoredata.blob.core.windows.net/gerentes/18.png" alt="Imagen de perfil del contacto">
                  </div>
                  <div class="contact_info">
                    <div class="contact_name">User name</div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    */
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
                    CreateContacto(chat);
                });
                break;
            case 'Gerentes':
                chats = chatsData.gerentesConChat;
                gerentes = chatsData.gerentesSinChat;
                chats.forEach(chat => {
                    CreateContacto(chat.chat);
                })
                break;
            case 'Administrador':
                chats = chatsData.chatAdministrador;
                let adminBtn = document.getElementById('adminBttn');
                adminBtn.removeAttribute('data-admin-id');
                adminBtn.dataset.chatId = chats.idChat;
        }
    }

}
