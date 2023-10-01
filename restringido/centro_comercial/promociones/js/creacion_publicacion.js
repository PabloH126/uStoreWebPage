let currentNotification;
const imagenInput = document.getElementById('logoTienda');
const imagenMostrada = document.getElementById('imagenSelec');
const deleteIcon = document.querySelector('.delete-icon');
document.addEventListener('DOMContentLoaded', function () {
    const mainForm = document.querySelector('.form-tiendas');
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
                    isValid = tiendasValidacion();
                    break; 
                case 2:
                    isValid = descripcionValidacion();
                    break;
                case 3:
                    isValid = logoValidacion();
                    break;
                default:
                    isValid = true;
                    break;
            }

            if (isValid == false) {
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

    mainForm.addEventListener('submit', async function(e) {
        if (!tiendasValidacion())
        {
            alert("Se debe seleccionar una tienda");
            e.preventDefault();
            return;
        }
        
        if (!descripcionValidacion())
        {
            alert("Se debe ingresar una descripción de la publicación");
            e.preventDefault();
            return;
        }

        if (!logoValidacion())
        {
            e.preventDefault();
            return;
        }

        var submitButton = document.getElementById("submitBtn");
        submitButton.disabled = true;
        submitButton.textContent = "";

        let div1 = document.createElement("div");
        div1.classList.add("ball1");
        let div2 = document.createElement("div");
        div2.classList.add("ball2");
        let div3 = document.createElement("div");
        div3.classList.add("ball3");

        submitButton.appendChild(div1);
        submitButton.appendChild(div2);
        submitButton.appendChild(div3);
        
        submitButton.classList.add("loading");
    });
});

if(imagenInput && imagenMostrada)
{
    imagenInput.addEventListener('change', (e) => {
        const imagenSeleccionada = e.target.files[0];

        if (imagenSeleccionada) {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada.src = imagenURL;
        }
    });
}

deleteIcon.addEventListener('click', () => {
    const inputId = deleteIcon.getAttribute('data-input-id');
    const imgId = deleteIcon.getAttribute('data-img-id');
    const inputElement = document.getElementById(inputId);
    const imgElement = document.getElementById(imgId);
    deleteIcon.disabled = true;
    imgElement.src = '';
    inputElement.value = '';
});

function tiendasValidacion() {
    var tiendasSelect = document.getElementById('seleccion_tienda');

    if(!tiendasSelect.value)
    {
        showNotificationError("Se debe seleccionar una tienda para hacer la publicacion");
        return false;
    }
    return true;
}

function descripcionValidacion() {
    var descripcion = document.getElementById('descripcionProducto');

    if(!descripcion || !descripcion.value.trim())
    {
        showNotificationError("Se debe ingresar una descripción de la publicación");
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

function logoValidacion() {
    const maxSize = 1 * 1024 * 1024;
    let logoTienda = document.getElementById("logoTienda");

    if(logoTienda.files.length && !validacionTypeImagen(logoTienda))
    {
        showNotificationError(`La imagen del logo de la tienda no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
        return false;
    }
    else if (logoTienda.files.length && !validacionSizeImagen(logoTienda, maxSize))
    {
        showNotificationError(`La imagen del logo de la tienda es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
        return false;
    }

    return true;
}

function showNotificationError(message) {
    if (currentNotification) {
        currentNotification.remove();
    }
    const notification = document.createElement("div");
    notification.classList.add("notificationError");
    notification.textContent = message;
    document.body.appendChild(notification);

    currentNotification = notification;
    setTimeout(() => {
        notification.classList.add("notificationErrorHide");
        setTimeout(() => {
            hideNotification();
        }, 550);
    }, 2500);
}

function hideNotification() {
    if (currentNotification) {
        currentNotification.remove();
    }

    currentNotification = null;
}