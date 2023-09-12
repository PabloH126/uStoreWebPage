let listElements = document.querySelectorAll('.list_button--click');

listElements.forEach(listElement => {

    //al dar click
    listElement.addEventListener('click', ()=>{
        
        //agrega la clase arrow
        listElement.classList.toggle('arrow');

        //y muestra el submenu
        let height = 0;
        let menu = listElement.nextElementSibling;
        console.log(menu);
    })
});