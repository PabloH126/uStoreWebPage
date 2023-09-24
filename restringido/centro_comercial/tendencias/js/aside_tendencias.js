let listElements = document.querySelectorAll('.list_button--click');

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
