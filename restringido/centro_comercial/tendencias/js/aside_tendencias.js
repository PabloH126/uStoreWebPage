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
    })
});

let bttns = document.querySelectorAll('.bttnp');

bttns.forEach(bttn => {
    
    bttn.addEventListener('click', ()=> {

        bttn.classList.toggle('selected');
    })
});

/*
 if (bttns.classList.contains("normal")) {
        bttns.classList.remove("normal");
        bttns.classList.add("selected");
    } else {
        bttns.classList.remove("selected");
        bttns.classList.add("normal");
    }
*/