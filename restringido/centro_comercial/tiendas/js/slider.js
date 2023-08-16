/*const slider = document.querySelector(".slider");
let currentIndex = 0;

function showSlide(index) {
  const slideWidth = slider.clientWidth;
  slider.style.transform = `translateX(-${slideWidth+49 * index}px)`;
}

setInterval(() => {
  currentIndex = (currentIndex + 1) % 3;
  showSlide(currentIndex);
}, 9000);

showSlide(currentIndex);*/

const btnLeft = document.querySelector(".btn-left"),
      btnRight = document.querySelector(".btn-right"),
      slider = document.querySelector("#slider"),
      sliderImg = document.querySelectorAll(".slider-img");

console.log(sliderImg)
