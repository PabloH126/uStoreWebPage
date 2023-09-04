let currentNotification;

document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.optionsC input[type="checkbox"]');
    var maxSelect = 8;
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.file-input');
    const nextButtons = document.querySelectorAll('.bttn-next');
    const backButtons = document.querySelectorAll('.bttn-back');


    nextButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            if (e.target !== button) return;

            const currentStep = parseInt(button.getAttribute('data-item'));

            let isValid = false;
            switch (currentStep) {
                case 1:
                    isValid = nombreValidacion();
                    break;
                case 2:
                    isValid = validacionCategorias();
                    break;
                case 3:
                    isValid = precioValidacion();
                    break;
                case 4:
                    isValid = descripcionValidacion();
                    break;
                case 5:
                    isValid = validacionImagenesProducto();
                    break;
                case 6:
                    isValid = cantidadApartarValidacion();
                    break;

                default:
                    isValid = true;
                    break;
            }

            if (isValid == false) {
                e.target.preventDefault();
                return;
            }
            else 
            {
                let element = e.target;
                let isButtonNext = element.classList.contains('bttn-next');
                let isButtonBack = element.classList.contains('bttn-back');

                if (isButtonNext || isButtonBack) {
                    let currentStep = document.getElementById('item-' + element.getAttribute('data-item'));
                    let jumpStep = document.getElementById('item-' + element.getAttribute('data-to_item'));
                    currentStep.classList.remove('active');
                    jumpStep.classList.add('active');
                    if (isButtonNext) {
                        currentStep.classList.add('to-left');
                        progressOptions[element.dataset.to_step - 1].classList.add('active');
                    } else {
                        jumpStep.classList.remove('to-left');
                    }
                }
            }

            const nextStep = parseInt(button.getAttribute('data-to_item'));
            showStep(nextStep);
        });
    });

    backButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            if (e.target !== button) return;

            let element = e.target; 
            let isButtonNext = element.classList.contains('bttn-next');
            let isButtonBack = element.classList.contains('bttn-back');

            if (isButtonNext || isButtonBack) {
                let currentStep = document.getElementById('item-' + element.getAttribute('data-item'));
                let jumpStep = document.getElementById('item-' + element.getAttribute('data-to_item'));
                currentStep.classList.remove('active');
                jumpStep.classList.add('active');
                if (isButtonNext) {
                    currentStep.classList.add('to-left');
                    progressOptions[element.dataset.to_step - 1].classList.add('active');
                } else {
                    jumpStep.classList.remove('to-left');
                }
            }
        });
    });
    
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

        if (!img1.files.length && !img2.files.length && !img3.files.length && !img4.files.length && !img5.files.length)
        {
            alert("Se debe subir al menos una imagen del producto");
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
            showNotification("Cargando producto...");
            const data = await sendFormWithoutImages(mainForm, fileInputs);
            hideNotification();
            if (data.statusProducto === 'success' && data.statusCatP === 'success') {
                showNotification("Cargando imagenes...");
                for (let input of fileInputs) {
                    if (input && input.files.length > 0) {
                        await sendImage(input, "imagenesProducto.php", data.idProducto); // Pasar el idProducto
                    }
                }
                hideNotification();
                
                showNotification("Producto creado");
                setTimeout(() => {
                    hideNotification();
                    window.location.href = data.urlSalida;
                }, 2500);
            } else {
                alert("Hubo un error al guardar el producto. Estatus del producto: " + data.statusProducto + ". Estatus de las categorias: " + data.statusCatP);
            }

        } catch (error) {
            console.error('Error: ', error);
            alert("Hubo un error al realizar la solicitud de creación de producto: " + error);
            submitButton.disabled = false;
            submitButton.style.backgroundColor = "#007096";
        }
    });
});

function nombreValidacion() {
    var nombre = document.querySelector(`input[id="nombreProducto"]`);

    if(!nombre || !nombre.value.trim())
    {
        alert("Se debe ingresar un nombre de producto");
        return false;
    }

    return true;
}

function precioValidacion() {
    var precio = document.querySelector('input[name="precioProducto"]');

    if(precio.value.trim() === "" || precio.value < 0 || isNaN(Number(precio.value)))
    {
        alert("Se debe ingresar un precio del producto");
        return false;
    }

    return true;
}

function descripcionValidacion() {
    var descripcion = document.getElementById('descripcionProducto');

    if(!descripcion || !descripcion.value.trim())
    {
        alert("Se debe ingresar una descripcion del producto");
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
        alert("Se debe ingresar una cantidad válida de unidades del producto para apartado");
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

async function sendImage(input, url, idProducto) {
    const formData = new FormData();
    formData.append(input.name, input.files[0]);
    formData.append('idProducto', idProducto); // Agregar el idProducto al formData

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

    if (dataImagenes.statusImagenes !== 'success') {
        alert("No se pudieron guardar las imágenes, ERROR: " + dataImagenes.statusImagenes);
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

function validacionCategorias() {
    let checkboxSelected = document.querySelectorAll('input[type="checkbox"]');
    let checked = Array.from(checkboxSelected).some(checkbox => checkbox.checked);
    if (!checked) 
    {
        alert("Se debe seleccionar al menos una categoria para el producto");
        return false;
    }
    return true;
}


function validacionImagenesProducto() {
    let img1 = document.getElementById("fileInput1");
    let img2 = document.getElementById("fileInput2");
    let img3 = document.getElementById("fileInput3");
    let img4 = document.getElementById("fileInput4");
    let img5 = document.getElementById("fileInput5");
    if (!img1.files.length && !img2.files.length && !img3.files.length && !img4.files.length && !img5.files.length) {
        alert("Se debe subir al menos una imagen del producto");
        return false;
    }

    if (!imagenesValidacion())
    {
        return false;
    }
    return true;
}