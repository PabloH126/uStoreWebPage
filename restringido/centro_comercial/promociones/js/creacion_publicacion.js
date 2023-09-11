let currentNotification;

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

    mainForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        let logoTienda = document.getElementById("logoTienda");
        
        if (!descripcionValidacion())
        {
            alert("Se debe ingresar una descripción de la publicación");
            e.preventDefault();
            return;
        }

        if (!imagenesValidacion(logoTienda))
        {
            e.preventDefault();
            return;
        }

        var submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.style.backgroundColor = "gray";
    });
});

function descripcionValidacion() {
    var descripcion = document.getElementById('descripcionPublicacion');

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

function imagenesValidacion(logoTienda) {
    const maxSize = 1 * 1024 * 1024;

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