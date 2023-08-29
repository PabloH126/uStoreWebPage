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
    var precio = document.querySelector('input[name="precioProducto"]');
    if(!precio)
    {
        return false;
    }

    return true;
}

function descripcionValidacion() {
    var descripcion = document.getElementById('descripcionProducto');

    if(!descripcion || !descripcion.value.trim())
    {
        return false;
    }

    return true;
}

function validacionSizeImagen(imagen, maxSize) {
    if(imagen.files[0].size > maxSize)
    {
        return false;
    }

    return true;
}

function imagenesValidacion() {
    const maxSize = 5 * 1024 * 1024;
    
    for (let i = 1; i <= 5; i++)
    {
        let img = document.getElementById("fileInput" + i);
        if (img.files.legth && !validacionSizeImagen(img, maxSize))
        {
            alert(`La imagen ${i} es demasiado pesada, por favor sube una imagen que pese menos de 5 megabytes`);
            return false;
        }
    }

    return true;
}

function cantidadApartarValidacion() {
    var apartado = document.getElementById('cantidadApartar');

    if(!apartado)
    {
        return false;
    }

    return true;
}

document.querySelector("form").addEventListener("submit", function (e) {
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

    if (!precioValidacion())
    {
        alert("Se debe ingresar un precio del producto");
        e.preventDefault();
        return;
    }

    if (!descripcionValidacion())
    {
        alert("Se debe ingresar una descripcion del producto");
        e.preventDefault();
        return;
    }

    if (!img1.files.length && !img2.files.length && !img3.files.length && !img4.files.length && !img5.files.length)
    {
        alert("Se debe subir al menos una imagen del producto");
        e.preventDefault();
        return;
    }

    if(!imagenesValidacion())
    {
        e.preventDefault();
        return;
    }

    if (!cantidadApartarValidacion())
    {
        alert('Se debe ingresar una cantidad de unidades del producto para apartado, en caso de que el producto no este disponible para apartar, ingrese "0"');
        e.preventDefault();
        return;
    }

    var submitButton = document.querySelector('button[type="submit"]');
    submitButton.disabled = true;
});