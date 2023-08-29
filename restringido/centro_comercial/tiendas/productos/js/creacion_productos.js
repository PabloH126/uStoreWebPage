document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.optionsC input[type="checkbox"]');
    var maxSelect = 8;

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var counter = document.querySelectorAll('.optionsC input[type="checkbox"]:checked').length;

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

function nombreValidacion() {
    var nombre = document.querySelector(`input[id="nombreProducto"]`);

    if(!nombre || !nombre.value.trim())
    {
        return false;
    }

    return true;
}

function validacionSizeImagen(imagen, maxSize)
{
    if(imagen.files[0].size > maxSize)
    {
        return false;
    }

    return true;
}

document.querySelector("form").addEventListener("submit", function (e) {
    const maxSize = 5 * 1024 * 1024;

    let img1 = document.getElementById("fileInput1");
    let img2 = document.getElementById("fileInput2");
    let img3 = document.getElementById("fileInput3");
    let img4 = document.getElementById("fileInput4");
    let img5 = document.getElementById("fileInput5");

    if()

