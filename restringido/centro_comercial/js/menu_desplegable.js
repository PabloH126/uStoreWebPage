let idTiendaMenuOption;
let menuOptions = document.querySelectorAll('.menu-option');
let menuIcon1 = document.getElementById('menu-icon');
let menuIcon2 = document.getElementById('menu-icon2');
let subMenu1 = document.getElementById('sub-menu');
let subMenu2 = document.getElementById('sub-menu2');
let backgroundAnimated = document.getElementById('background-animated');

document.addEventListener('DOMContentLoaded', function () {
    menuIcon1.addEventListener('click', function (e) {
        subMenu1.classList.toggle("active");
        menuIcon1.classList.toggle("active");
        backgroundAnimated.style.display = 'none';
    });

    menuIcon2.addEventListener('click', function (e) {
        subMenu2.classList.toggle("active");
        menuIcon2.classList.toggle("active");
    });
});
