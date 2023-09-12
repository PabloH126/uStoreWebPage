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
    
miBoton.addEventListener("click", function() {
    if (miBoton.classList.contains("normal")) {
        miBoton.classList.remove("normal");
        miBoton.classList.add("selected");
    } else {
        miBoton.classList.remove("selected");
        miBoton.classList.add("normal");
    }
    });

