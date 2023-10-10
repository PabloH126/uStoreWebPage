let currentNotification;

const expresiones = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
    nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    password: /^.{8,50}$/, // 8 a 50 digitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}

document.addEventListener('DOMContentLoaded', function () {
    const mainForm = document.querySelector(".form-tiendas");
    const nextButtons = document.querySelectorAll('.bttn-next');
    const backButtons = document.querySelectorAll('.bttn-back');
    const finalNextBtn = document.getElementById('finalBtn');
    const correoNextBtn = document.getElementById('btnEmail');

    nextButtons.forEach(function (button) {
        button.addEventListener('click', async function (e) {
            e.stopPropagation();
            if (e.target !== button) return;

            const currentStep = parseInt(button.getAttribute('data-item'));

            let isValid = false;
            switch (currentStep) {
                case 1:
                    isValid = nombreValidacion(expresiones.nombre);
                    break;
                case 2:
                    isValid = apellidoValidacion(expresiones.nombre);
                    break;
                case 3:
                    isValid = await emailValidacion(expresiones.correo);
                    break;
                case 4:
                    isValid = passwordValidacion(expresiones.password);
                    break;
                case 5:
                    isValid = sucursalValidacion();
                    break;
                case 6:
                    isValid = await imagenesValidacion();
                    break;

                default:
                    isValid = true;
                    break;
            }

            if (isValid == false) {
                //e.target.preventDefault();
                return;
            }
            else {
                showNextStep(button, e);
            }
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
    /*
    correoNextBtn.addEventListener('click', async function (e) {
        let correo = document.getElementById("correoGerente").value;
        let formData = new FormData();
        formData.append('email', correo);
        const responseCorreoVerify = await fetch('verify_email_gerente.php', {
            method: 'POST',
            body: formData
        });

        if (!responseCorreoVerify.ok)
        {
            showNotificationError("Error de servidor en la respuesta de verificacion de email");
            return;
        }

        const correoVerifyResponse = await responseCorreoVerify.json();
        
        if (correoVerifyResponse.status !== 'success')
        {
            showNotificationError(correoVerifyResponse.message);
        }
        else
        {
            showNextStep(correoNextBtn, e);
            showNotification(dataResponse.message);
        }
    });
    
    finalNextBtn.addEventListener('click', async function (e) {
        if (!nombreValidacion(expresiones.nombre))
        {
            return;
        }
        else if (!apellidoValidacion(expresiones.nombre))
        {
            return;
        }
        else if (!emailValidacion(expresiones.correo))
        {
            return;
        }
        else if (!passwordValidacion(expresiones.password))
        {
            return;
        }
        else if (!sucursalValidacion())
        {
            return;
        }
        else if (!imagenesValidacion())
        {
            return;
        }
        else
        {
            let correo = document.getElementById("correoGerente").value;
            let nombre = document.getElementById("nombreGerente").value;
            let formData = new FormData();
            formData.append('email', correo);
            formData.append('nombre', nombre);
            const responseCorreo = await fetch("correo_confirmacion.php", {
                method: 'POST',
                body: formData
            });

            if (!responseCorreo.ok)
            {
                showNotificationError("Error de servidor en la respuesta de registro");
                return;
            }

            const dataResponse = await responseCorreo.json();

            if(dataResponse.status !== 'success')
            {
                showNotificationError(dataResponse.message);
            }
            else
            {
                showNextStep(finalNextBtn, e);
                showNotification(dataResponse.message);
            }
        }

        
    });
    */
    mainForm.addEventListener('submit', async function (e) {
        e.stopPropagation();
        e.preventDefault();
        if (!nombreValidacion(expresiones.nombre))
        {
            return;
        }
        else if (!apellidoValidacion(expresiones.nombre))
        {
            return;
        }
        else if (!emailValidacion(expresiones.correo))
        {
            return;
        }
        else if (!passwordValidacion(expresiones.password))
        {
            return;
        }
        else if (!sucursalValidacion())
        {
            return;
        }
        else if (!imagenesValidacion())
        {
            return;
        }
        else
        {
            let formData = new FormData(mainForm);
            const responseCorreo = await fetch(mainForm.action, {
                method: mainForm.method,
                body: formData
            });

            if (!responseCorreo.ok)
            {
                showNotificationError("Error de servidor en la respuesta de registro");
                return;
            }

            const dataResponse = await responseCorreo.json();

            if(dataResponse.status !== 'success')
            {
                showNotificationError(dataResponse.message);
            }
            else
            {
                
            }
        }
    });
});

function nombreValidacion(expresion) {
    let nombre = document.getElementById("nombreGerente");
    if (!nombre || !nombre.value.trim()) {
        showNotificationError("Se debe ingresar un nombre del gerente");
        return false;
    }
    else if (!expresion.test(nombre.value)) {
        showNotificationError("Nombre invalido, favor de ingresar un nombre que no contenga numeros");
        return false;
    }
    return true;
}

function apellidoValidacion(expresion) {
    let apellido = document.getElementById("apellidoGerente");
    if (!apellido || !apellido.value.trim()) {
        showNotificationError("Se debe ingresar un apellido del gerente");
        return false;
    }
    else if (!expresion.test(apellido.value)) {
        showNotificationError("Apellido invalido, favor de ingresar un nombre que no contenga numeros");
        return false;
    }
    return true;
}

async function emailValidacion(expresion) {
    let correo = document.getElementById("correoGerente");

    if (!correo || !correo.value.trim()) {
        showNotificationError("Se debe ingresar una direccion de correo electronico del gerente");
        return false;
    }
    else if (!expresion.test(correo.value)) {
        showNotificationError("Se debe ingresar una direccion de correo electronico valida");
        return false;
    }
    
    let formData = new FormData();
    formData.append('email', correo.value);
    const responseCorreoVerify = await fetch('verify_email_gerente.php', {
        method: 'POST',
        body: formData
    });

    if (!responseCorreoVerify.ok)
    {
        showNotificationError("Error de servidor en la respuesta de verificacion de email");
        return;
    }

    const correoVerifyResponse = await responseCorreoVerify.json();
    
    if (correoVerifyResponse.status !== 'success')
    {
        showNotificationError(correoVerifyResponse.message);
        return false;
    }
    else
    {
        showNotification(correoVerifyResponse.message);
        setTimeout(() => {
            hideNotification();
        }, 2500);
    }
    return true;
}

function passwordValidacion(expresion) {
    let password = document.getElementById("passwordGerente");
    let confirmPassword = document.getElementById("repasswordGerente");

    if (!password || !password.value.trim())
    {
        showNotificationError("Se debe ingresar una contraseña para la cuenta de gerente");
        return false;
    }
    else if (!expresion.test(password.value))
    {
        showNotificationError("Se debe ingresar una contraseña de al menos 8 caracteres");
        return false;
    }
    else if (!(password.value === confirmPassword.value))
    {
        showNotificationError("Las contraseñas no coinciden");
        return false;
    }
    return true;
}

function sucursalValidacion() {
    let sucursal = document.getElementById("seleccion_tienda");
    if (sucursal.value === "")
    {
        showNotificationError("Se debe seleccionar una sucursal para asignar al gerente");
        return false;
    }
    return true;
}

async function imagenesValidacion() {
    const maxSize = 1 * 1024 * 1024;
    let imagenInput = document.getElementById("logoTienda");
    if(imagenInput.files.length && !validacionTypeImagen(imagenInput))
    {
        showNotificationError(`La imagen no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
        return false;
    }
    else if (imagenInput.files.length && !validacionSizeImagen(imagenInput, maxSize))
    {
        showNotificationError(`La imagen es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
        return false;
    }

    let correo = document.getElementById("correoGerente").value;
    let nombre = document.getElementById("nombreGerente").value;
    let formData = new FormData();
    formData.append('email', correo);
    formData.append('nombre', nombre);
    const responseCorreo = await fetch("correo_confirmacion.php", {
        method: 'POST',
        body: formData
    });

    if (!responseCorreo.ok)
    {
        showNotificationError("Error de servidor en la respuesta de registro");
        return;
    }

    const dataResponse = await responseCorreo.json();

    if(dataResponse.status !== 'success')
    {
        showNotificationError(dataResponse.message);
        return false;
    }
    else
    {
        showNotification(dataResponse.message);
        setTimeout(() => {
            hideNotification();
        }, 2500);
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

function showNextStep(button ,e)
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

    const nextStep = parseInt(button.getAttribute('data-to_item'));
    showStep(nextStep);
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

function showNotificationError(message) {
    if (currentNotification) {
        currentNotification.remove();
    }
    const notification = document.createElement("div");
    notification.classList.add("notificationError");
    notification.textContent = message;
    document.body.appendChild(notification);
    console.log(notification);
    currentNotification = notification;
    setTimeout(() => {
        notification.classList.add("notificationErrorHide");
        setTimeout(() => {
            hideNotification();
        }, 550);
    }, 2500);

}