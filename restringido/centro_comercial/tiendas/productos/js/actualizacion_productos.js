let currentNotification;

document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.optionsC input[type="checkbox"]');
    var maxSelect = 8;
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.file-input');
    const idImagenes = document.querySelectorAll('.idImagenes');
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    const idProducto = params.get('id');

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

    mainForm.addEventListener('submit', async function(e) {
        e.preventDefault();
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
            e.preventDefault();
            return;
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

        if (!imagenesValidacion())
        {
            e.preventDefault();
            return;
        }

        if (!cantidadApartarValidacion())
        {
            alert("Se debe ingresar una cantidad válida de unidades del producto para apartado");
            e.preventDefault();
            return;
        }

        var submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.style.backgroundColor = "gray";

        try {
            showNotification("Actualizando producto...");
            const data = await sendFormWithoutImages(mainForm, fileInputs);
            hideNotification();
            if (data.statusProducto === 'success' && data.statusCatP === 'success') {
                showNotification("Verificando imagenes...");
                for (let i = 0; i < fileInputs.length; i++) {
                    if (fileInputs[i] && fileInputs[i].files.length > 0) {
                        let idImagen = idImagenes[i];
                        await sendImage(fileInputs[i], "actualizarImagenesProducto.php", idProducto, idImagen); // Pasar el idProducto
                    }
                }
                hideNotification();
                
                showNotification("Producto actualizado");
                setTimeout(() => {
                    hideNotification();
                    window.location.href = data.urlSalida;
                }, 2500);
            } else {
                if(!data.statusProducto)
                {
                    alert("Hubo un error al guardar el producto: " + data.messageCatP);
                }
                else
                {
                    alert("Hubo un error al guardar el producto. Estatus del producto " +data.statusProducto + ": " + data.messageProducto + ". Estatus de las categorias " + data.statusCatP + ": " + data.messageCatP);
                }
                submitButton.disabled = false;
                submitButton.style.backgroundColor = "#007096";
                return;
            }

        } catch (error) {
            console.error('Error: ', error);
            alert("Hubo un error al realizar la solicitud de creación de producto: " + error);
            return;
        }
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

    if(precio.value.trim() === "" || precio.value < 0 || isNaN(Number(precio.value)))
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

function validacionTypeImagen(imagen)
{
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (allowedTypes.indexOf(imagen.files[0].type) === -1) {
        return false;
    }

    return true;
}

function imagenesValidacion() {
    const maxSize = 1 * 1024 * 1024;
    
    for (let i = 1; i <= 5; i++)
    {
        let img = document.getElementById("fileInput" + i);
        if(img.files.length && !validacionTypeImagen(img))
        {
            alert(`La imagen ${i} no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
            return false;
        }
        else if (img.files.length && !validacionSizeImagen(img, maxSize))
        {
            alert(`La imagen ${i} es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
            return false;
        }
    }

    return true;
}

function cantidadApartarValidacion() {
    var apartado = document.querySelector('input[name="cantidadApartar"]');

    if(apartado.value.trim() === "" || apartado.value < 0 || isNaN(Number(apartado.value)))
    {
        return false;
    }

    return true;
}

async function sendFormWithoutImages(form, fileInputs) {
    const formData = new FormData(form);

    fileInputs.forEach(input => {
        formData.delete(input.name);
    });

    const response = await fetch(form.action, {
        method: form.method,
        body: formData
    });

    return response.json();
}

async function sendImage(input, url, idProducto, idImagen) {
    const formData = new FormData();
    formData.append(input.name, input.files[0]);
    formData.append('idProducto', idProducto); // Agregar el idProducto al formData
    formData.append(idImagen.name, idImagen.value);
    
    const responseImagenes = await fetch(url, {
        method: 'POST',
        body: formData
    });
    
    if (!responseImagenes.ok)
    {
        console.error("Error en la respuesta de imagenes: ", responseImagenes.statusText);
        return;
    }

    const dataImagenes = await responseImagenes.json();
    console.log(dataImagenes);

    if (dataImagenes.statusImagenes !== 'success') {
        alert("No se pudieron guardar las imágenes, ERROR: " + dataImagenes.statusImagenes + ": " + dataImagenes.messageImagenes);
    } 
}

function showNotification(message) {
    if (currentNotification) {
        currentNotification.remove();
    }

    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    document.body.appendChild(notification);
    
    currentNotification = notification;
}

function hideNotification() {
    if (currentNotification) {
        currentNotification.remove();
    }

    currentNotification = null;
}