const slider = document.querySelector(".slider");
let currentIndex = 0;

function showSlide(index) {
  const slideWidth = slider.clientWidth;
  slideWidth = slideWidth+49;
  slider.style.transform = `translateX(-${slideWidth * index}px)`;
}

setInterval(() => {
  currentIndex = (currentIndex + 1) % 3;
  showSlide(currentIndex);
}, 10000);

showSlide(currentIndex);
