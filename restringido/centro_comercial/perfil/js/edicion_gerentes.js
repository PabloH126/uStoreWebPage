const deleteGerenteBtn = document.querySelector('.delete-store-btn');

const urlParams = new URLSearchParams(window.location.search);
const idGerente = urlParams.get('id');
let steps = 0;

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
                    isValid = passwordValidacion(expresiones.password);
                    break;
                case 4:
                    isValid = sucursalValidacion();
                    break;
                case 5:
                    isValid = imagenesValidacion();
                    break;

                default:
                    isValid = true;
                    break;
            }

            if (isValid == false) {
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

            steps = steps - 1;
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

    imagenInput.addEventListener('change', () => {
        const imagenSeleccionada = imagenInput.files[0];

        if (imagenSeleccionada)
        {
            const imagenURL = URL.createObjectURL(imagenSeleccionada);
            imagenMostrada.src = imagenURL;
        }
    });

    deleteIcon.addEventListener('click', () => {
        const imgId = deleteIcon.getAttribute('data-img-id');
        const imgElement = document.getElementById(imgId);

        if (imagenInput && imgElement)
        {
            imgElement.src = '';
            imagenInput.value = '';
        }
    });

    deleteGerenteBtn.addEventListener('click', function (e) {
        ModalConfirmacionEliminacion()
        .catch(error => {
            window.location.reload(true);
        });
    });

    mainForm.addEventListener('keydown', function (e) {
        if (e.key === 'Enter')
        {
            e.preventDefault();

            let clickEvent = new MouseEvent('click', {
                bubbles: true,
                cancelable: true,
                view: window
            });
            let currentStepEnter = steps + 1;
            let item = document.getElementById('item-' + currentStepEnter);
            let btnNext = item.querySelector('.bttn-next');
            if (btnNext)
            {
                btnNext.dispatchEvent(clickEvent);
            }
            return false;
        }
    });
    
    mainForm.addEventListener('submit', async function (e) {
        e.stopPropagation();
        e.preventDefault();

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

        let formData = new FormData(mainForm);
        const responseCorreo = await fetch(mainForm.action, {
            method: mainForm.method,
            body: formData
        });

        if (!responseCorreo.ok)
        {
            showNotificationError("Error de servidor en la respuesta de registro");
            submitButton.disabled = false;
            submitButton.textContent = "Guardar";
            div1.remove();
            div2.remove();
            div3.remove();
            submitButton.classList.remove("loading");
            return;
        }

        const dataResponse = await responseCorreo.json();

        if(dataResponse.status !== 'success')
        {
            showNotificationError(dataResponse.message);
            submitButton.disabled = false;
            submitButton.textContent = "Guardar";
            div1.remove();
            div2.remove();
            div3.remove();
            submitButton.classList.remove("loading");
            return;
        }
        else
        {
            showNotification(dataResponse.message);
            setTimeout(() => {
                hideNotification();
                window.location.href = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/perfil_gerentes.php';
            }, 2500);
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
    steps = steps + 1;
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

async function ModalConfirmacionEliminacion() {
    return new Promise((resolve, reject) => {
        const modalOverlay = document.createElement("div");
        modalOverlay.classList.add("modal-overlay");
        
        const modal = document.createElement("div");
        modal.classList.add("modal");

        modal.innerHTML = `
            <div class="modal-content">
                <p>¿Estás seguro de eliminar este gerente?</p>
                <p> Se eliminarán sus datos y se desvinculará de la tienda asignada.</p>
                <div class="modal-buttons">
                    <button class="modal-accept">Aceptar</button>
                    <button class="modal-cancel">Cancelar</button>
                </div>
            </div>
        `;

        modalOverlay.appendChild(modal);
        document.body.appendChild(modalOverlay);

        const acceptButton = modal.querySelector(".modal-accept");
        const cancelButton = modal.querySelector(".modal-cancel");

        function closeModal() {
            modalOverlay.remove();
        }

        acceptButton.addEventListener("click", async function() {
            acceptButton.disabled = true;
            cancelButton.disabled = true;
            acceptButton.style.backgroundColor = "gray";
            const responseEliminacion = await fetch("https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/eliminar_gerente.php?id=" + idGerente, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            });

            if (!responseEliminacion.ok)
            {
                showNotificationError("Hubo un error en la solicitud de eliminacion del gerente.");
                return;
            }

            const eliminacionData = await responseEliminacion.json();

            if(eliminacionData.status !== "success")
            {
                showNotificationError("Hubo un error en la eliminacion del gerente: ", eliminacionData.message);
                return;
            }
            else
            {
                showNotification("Gerente eliminado exitosamente.");
                setTimeout(() => {
                    hideNotification();
                    window.location.href = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/perfil_gerentes.php';
                }, 2500);
            }
        });

        cancelButton.addEventListener("click", function() {
            closeModal();
            reject(false);
        });

        modalOverlay.addEventListener("click", function(event) {
            if (event.target === modalOverlay) {
                closeModal();
                reject(false);
            }
        });
    });
}