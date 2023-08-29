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

function precioValidacion() {
    var precio = document.getElementById('precioProducto');
    if(!precio || precio == )
    {
        return false;
    }
}

function descripcionValidacion() {
    var descripcion = document.getElementById('descripcionProducto');

    if(!descripcion || !descripcion.value.trim())
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

    let checkboxSelected = document.querySelectorAll('input[type="checkbox"]');
    let checked = Array.from(checkboxSelected).some(checkbox => checkbox.checked);

    let img1 = document.getElementById("fileInput1");
    let img2 = document.getElementById("fileInput2");
    let img3 = document.getElementById("fileInput3");
    let img4 = document.getElementById("fileInput4");
    let img5 = document.getElementById("fileInput5");
    
    if (!nombreValidacion())
    {
        alert("Se debe ingresar un nombre de producto");
    }

    if (!checked) {
        alert("Se debe seleccionar al menos una categoria");
        e.preventDefault();
        return;
    }

    if (!img1.files.length && !img2.files.length && !img3.files.length && !img4.files.length && !img5.files.length)
    {
        alert("Se debe subir al menos 1 imagen del producto");
        e.preventDefault();
        return;
    }

    if (img1.files.length && !validacionSizeImagen(img1, maxSize))
    {
        alert("La imagen 1 es demasiado pesada, por favor sube una imagen que pese menos de 5 megabytes");
        e.preventDefault();
        return;
    }
    if (img2.files.length && !validacionSizeImagen(img2, maxSize))
    {
        alert("La imagen 2 es demasiado pesada, por favor sube una imagen que pese menos de 5 megabytes");
        e.preventDefault();
        return;
    }
    if (img3.files.length && !validacionSizeImagen(img3, maxSize))
    {
        alert("La imagen 3 es demasiado pesada, por favor sube una imagen que pese menos de 5 megabytes");
        e.preventDefault();
        return;
    }
    if (img4.files.length && !validacionSizeImagen(img4, maxSize))
    {
        alert("La imagen 4 es demasiado pesada, por favor sube una imagen que pese menos de 5 megabytes");
        e.preventDefault();
        return;
    }
    if (img4.files.length && !validacionSizeImagen(img4, maxSize))
    {
        alert("La imagen 4 es demasiado pesada, por favor sube una imagen que pese menos de 5 megabytes");
        e.preventDefault();
        return;
    }

    var submitButton = document.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    });