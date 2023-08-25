const btnLeft = document.querySelector(".btn-left"),
      btnRight = document.querySelector(".btn-right"),
      slider = document.querySelector("#slider"),
      sliderImg = document.querySelectorAll(".slider-img")
      izquierda = document.querySelector(".izquierda")
      derecha = document.querySelector(".derecha");

if(sliderImg.length === 3){
    slider.style.setProperty("width", "300%");

    sliderImg.forEach(img => {
        img.style.setProperty("width", "calc(100% / 3)");
    });
}else if(sliderImg.length === 2){
    slider.style.setProperty("width", "200%");
    sliderImg.forEach(img => {
        img.style.setProperty("width", "calc(100% / 2)");
    });
}else if(sliderImg.length === 1){
    izquierda.style.setProperty("height, 100%");
    /*derecha.style.setProperty("height, 100%");*/
    btnLeft.style.setProperty("display", "none");
    btnRight.style.setProperty("display", "none");
    slider.style.setProperty("width", "100%");
    sliderImg.forEach(img => {
        img.style.setProperty("width", "100%");
    });
}

btnLeft.addEventListener("click", e => moveToLeft())
btnRight.addEventListener("click", e => moveToRight())

setInterval(() => {
    moveToRight()
}, 3000);


let operacion = 0,
    counter = 0,
    widthImg = 100 / sliderImg.length;

function moveToRight() {
    if (counter >= sliderImg.length-1) {
        counter = 0;
        operacion = 0;
        slider.style.transform = `translate(-${operacion}%)`;
        slider.style.transition = "none";
        return;
    } 
    counter++;
    operacion = operacion + widthImg;
    slider.style.transform = `translate(-${operacion}%)`;
    slider.style.transition = "all ease .6s"
}  

function moveToLeft() {
    counter--;
    if (counter < 0 ) {
        counter = sliderImg.length-1;
        operacion = widthImg * (sliderImg.length-1)
        slider.style.transform = `translate(-${operacion}%)`;
        slider.style.transition = "none";
        return;
    } 
    operacion = operacion - widthImg;
    slider.style.transform = `translate(-${operacion}%)`;
    slider.style.transition = "all ease .6s"
}   
