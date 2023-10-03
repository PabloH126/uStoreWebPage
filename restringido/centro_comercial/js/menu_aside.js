let listElements = document.querySelectorAll('.list_button--click');

listElements.forEach(listElement => {
    // Verifica si el elemento tiene la clase "categorias"
    if (listElement.classList.contains('categorias')) {
        // Para elementos con la clase "categorias", establece una altura específica
        listElement.addEventListener('click', () => {
            listElement.classList.toggle('arrow');
            let height = 0;
            let menu = listElement.nextElementSibling;
            console.log(menu);
            menu.style.height = 0;
            console.log(menu.style.height);

            if (menu.style.height != 0) {
                console.log("entro al if");
            } else {
                console.log("entro al else");
                // De lo contrario, establece la altura a 37vh
                menu.classList.add('select');
            }
/*
            if (menu.style.height === '37vh') {
                // Si la altura actual es 37vh, establece la altura a 0
                menu.style.height = '0';
            } else {
                // De lo contrario, establece la altura a 37vh
                menu.style.height = '37vh';
            }*/
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

/*
listElements.forEach(listElement => {

    //al dar click
    listElement.addEventListener('click', ()=>{
        
        //agrega la clase arrow
        listElement.classList.toggle('arrow');

        //y muestra el submenu
        let height = 0;
        let menu = listElement.nextElementSibling;
        
        if(menu.clientHeight == 0){
            height = menu.scrollHeight;
        }

        menu.style.height = height+"px";
        
        if (listElement.classList.contains('categorias')) {
            menu.style.height = 37+"vh";
        }
    })
});*/

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
