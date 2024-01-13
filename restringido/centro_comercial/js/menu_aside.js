let listElements = document.querySelectorAll('.list_button--click');
let btnTiendas = document.getElementById('btnTiendas');
let isPerfil = document.getElementById('isPerfil');

if (isPerfil)
{
    btnTiendas.textContent = "Sucursales";
}
else
{
    btnTiendas.textContent = "Tiendas";
}

listElements.forEach(listElement => {
    // Verifica si el elemento tiene la clase "categorias"
    if (listElement.classList.contains('categorias')) {
        // Para elementos con la clase "categorias", establece una altura específica
        listElement.addEventListener('click', () => {
            listElement.classList.toggle('arrow');
            let height = 0;
            let menu = listElement.nextElementSibling;
            let computedStyleMenu = window.getComputedStyle(menu);

            if (computedStyleMenu.height && computedStyleMenu.height != "0px") {
                menu.classList.remove("select");
            } else {
                // De lo contrario, establece la altura mediante css
                menu.classList.add("select");
            }
        });
    } else {
        // Para otros elementos, utiliza la lógica predeterminada
        listElement.addEventListener('click', () => {
            listElement.classList.toggle('arrow');
            let height = 0;
            let menu = listElement.nextElementSibling;
            if (menu.clientHeight == 0) {
                height = menu.scrollHeight;
            }
            menu.style.height = height + "px";
        });
    }
});

let graficaBttns = document.querySelectorAll('.list_item:nth-child(1) .bttnp');
let tiempoBttns = document.querySelectorAll('.list_item:nth-child(3) .bttnp');

graficaBttns.forEach(bttn => {
    bttn.addEventListener('click', () => {
        graficaBttns.forEach(otherBttn => {
            if (otherBttn !== bttn) {
                otherBttn.classList.remove('selected');
            }
        });
        bttn.classList.toggle('selected');
    });
});

tiempoBttns.forEach(bttn => {
    bttn.addEventListener('click', () => {
        tiempoBttns.forEach(otherBttn => {
            if (otherBttn !== bttn) {
                otherBttn.classList.remove('selected');
            }
        });
        bttn.classList.toggle('selected');
    });
});
