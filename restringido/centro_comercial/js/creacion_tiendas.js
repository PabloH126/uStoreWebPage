document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('#checkbox-list input[type="checkbox"]');
    var maxSelect = 8;

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var counter = document.querySelectorAll('#checkbox-list input[type="checkbox"]:checked').length;

            if (counter >= maxSelect) {
                checkboxes.forEach(function (c) {
                    if (!c.checked) {
                        c.disabled = true;
                    }
                });
            }
            else {
                checkboxes.forEach(function (c) {
                    c.disabled = false;
                });
            }
        });
    });
});

document.querySelector("form").addEventListener("submit", function (e) {
    let img1 = document.getElementById("fileInput1").value;
    let img2 = document.getElementById("fileInput2").value;
    let img3 = document.getElementById("fileInput3").value;

    let logoTienda = document.getElementById("logoTienda").value;


    if (!logoTienda) {
        alert("Se debe subir un logo de tienda");
        e.preventDefault();
        return;
    }
    else if (!img1 && !img2 && !img3) {
        alert("Se debe subir al menos una imagen paraa el banner de la tienda");
        e.preventDefault();
        return;
    }

    let checkboxSelected = document.querySelectorAll('input[type="checkbox"]');
    let checked = Array.from(checkboxSelected).some(checkbox => checkbox.checked);

    if (!checked) {
        alert("Se debe seleccionar aal menos una categoria");
        e.preventDefault();
        return;
    }
});