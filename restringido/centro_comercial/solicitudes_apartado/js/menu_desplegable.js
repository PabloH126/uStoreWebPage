document.addEventListener('DOMContentLoaded', function () {
    let menuDesp = document.getElementById('sub-menu');
    let menuIcon = document.getElementById('menu-icon');
    
    menuIcon.addEventListener('click', function (e) {
        menuDesp.classList.toggle("active");
        menuIcon.style.setProperty("content", "\u{eebd}");
    });
})