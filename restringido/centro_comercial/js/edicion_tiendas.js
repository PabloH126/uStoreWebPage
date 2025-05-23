document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.optionsC input[type="checkbox"]');
    var maxSelect = 8;
    const mainForm = document.querySelector('.form-tiendas');
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    const idTienda = params.get('id');
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
                    isValid = logoValidacion();
                    break;
                case 3:
                    isValid = validacionCategorias();
                    break;
                case 4:
                    isValid = validacionHorarios();
                    break;
                case 5:
                    isValid = validacionBanner();
                    break;
                case 6:
                    isValid = validacionCompletaPeriodos();
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

    mainForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        let checkboxSelected = document.querySelectorAll('input[type="checkbox"]');
        let checked = Array.from(checkboxSelected).some(checkbox => checkbox.checked);

        let logoTienda = document.getElementById("logoTienda");
        let img1 = document.getElementById("fileInput1");
        let img2 = document.getElementById("fileInput2");
        let img3 = document.getElementById("fileInput3");
        
        if (!nombreValidacion())
        {
            alert("Se debe ingresar un nombre de la tienda");
            e.preventDefault();
            return;
        }

        if (!logoTienda.files.length && logoTienda.files.length > 0) 
        {
            alert("Se debe subir un logo de tienda");
            e.preventDefault();
            return;
        }

        if (!checked) 
        {
            alert("Se debe seleccionar al menos una categoria para la tienda");
            e.preventDefault();
            return;
        }

        if(!horariosConfigurados())
        {
            alert("Se debe configurar al menos un horario");
            e.preventDefault();
            return;
        }

        if(!validarHorariosCorrectos())
        {
            e.preventDefault();
            return;
        }

        if (!img1.files.length && !img2.files.length && !img3.files.length && img1.files.length > 0 && img2.files.length > 0 && img3.files.length > 0) {
            alert("Se debe subir al menos una imagen para el banner de la tienda");
            e.preventDefault();
            return;
        }

        if (!imagenesValidacion(logoTienda))
        {
            e.preventDefault();
            return;
        }

        if(!periodosConfigurados())
        {
            alert("Se debe configurar al menos un periodo de apartado predeterminado");
            e.preventDefault();
            return;
        }

        if(!validacionPeriodos())
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
        
        try {
            const fileInputs = document.querySelectorAll('.fileInputBanner');
            const idImagenes = document.querySelectorAll('.idImagenes');
            showNotification("Actualizando tienda...");
            await deleteImages('../tiendas/eliminar_imagen_tienda.php');
            const data = await sendFormWithoutImages(mainForm, fileInputs);
            hideNotification();
            if (data.statusTienda === 'success' && data.statusHorarios === 'success' && data.statusCatT === 'success' && data.statusPeriodos === 'success') {
                showNotification("Verificando imagenes...");
                
                for (let i = 0; i < fileInputs.length; i++) {
                    if (fileInputs[i] && fileInputs[i].files.length > 0) {
                        let idImagen = idImagenes[i];
                        await sendImage(fileInputs[i], "actualizarImagenesTienda.php", idTienda, idImagen); // Pasar el idTienda
                    }
                }
                hideNotification();
                
                showNotification("Tienda actualizada");
                setTimeout(() => {
                    hideNotification();
                    window.location.href = data.urlSalida;
                }, 2500);
            } else {
                if(!data.statusTienda)
                {
                    alert("Hubo un error al guardar la tienda: " + data.messageCatT);
                }
                else
                {
                    alert("Hubo un error al guardar la tienda. Estatus de la tienda " + data.statusTienda + ": " + data.messageTienda + ". Estatus de los horarios " + data.statusHorarios + ": " + data.messageHorarios + ". Estatus de las categorias " + data.statusCatT + ": " + data.messageCatT + ". Estatus de los periodos " + data.statusPeriodos + ": " + data.messagePeriodos);
                }
                submitButton.disabled = false;
                submitButton.style.backgroundColor = "#007096";
                return;
            }

        } catch (error) {
            console.error('Error: ', error);
            alert("Hubo un error al realizar la solicitud de creación la tienda: " + error);
            return;
        }
    });
});

function nombreValidacion() {
    var nombre = document.querySelector(`input[id="nombreTienda"]`);

    if(!nombre || !nombre.value.trim())
    {
        showNotificationError("Se debe ingresar un nombre de la tienda");
        return false;
    }

    return true;
}


function horariosConfigurados() {
    const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

    for (let dia of dias)
    {
        let apertura  = document.querySelector(`input[name="${dia}_apertura"]`).value;
        let cierre  = document.querySelector(`input[name="${dia}_cierre"]`).value;

        if((apertura || cierre) && (apertura !== "00:00" || cierre !== "00:00"))
        {
            return true;
        }
    }   

    return false;
}

function validarHorariosCorrectos()
{
    const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

    for(let dia of dias)
    {
        let apertura  = document.querySelector(`input[name="${dia}_apertura"]`).value;
        let cierre  = document.querySelector(`input[name="${dia}_cierre"]`).value;

        if(apertura && !cierre)
        {
            showNotificationError(`Por favor ingresa la hora de cierre del ${dia}`)
            return false;
        }
        else if(!apertura && cierre)
        {
            showNotificationError(`Por favor ingresa la hora de apertura de ${dia}`)
            return false;
        }
        else if(!apertura && !cierre)
        {
            continue;
        }

        let[horaApertura, minutoApertura] = apertura.split(":").map(val => parseInt(val, 10));
        let[horaCierre, minutoCierre] = cierre.split(":").map(val => parseInt(val, 10));

        let tiempoApertura = horaApertura * 60 + minutoApertura;
        let tiempoCierre = horaCierre * 60 + minutoCierre;

        if(tiempoApertura > tiempoCierre)
        {
            showNotificationError(`Por favor ingresa un horario válido para el día ${dia}.`);
            return false;
        }
    }

    return true;
}

function periodosConfigurados() {
    const periodos = ["Periodo1", "Periodo2", "Periodo3"];

    for (let periodo of periodos)
    {
        let numero = document.querySelector(`input[name="numero${periodo}"]`).value;
        let tiempo = document.querySelector(`select[name="tiempo${periodo}"]`).value;

        if(numero !== "" || tiempo !== "")
        {
            return true;
        }
    }

    return false;
}


function validacionPeriodos() {
    const periodos = ["Periodo1", "Periodo2", "Periodo3"];

    for (let periodo of periodos)
    {
        let numero = document.querySelector(`input[name="numero${periodo}"]`).value;
        let tiempo = document.querySelector(`select[name="tiempo${periodo}"]`).value;

        if((!numero && tiempo !== "") || (numero && tiempo === ""))
        {
            showNotificationError(`Por favor ingresa un periodo de apartado predeterminado válido para el ${periodo}`);
            return false;
        }
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
    let imagenLogoTienda = document.getElementById("imagenSelec");

    if (logoTienda.files.length <= 0 && (imagenLogoTienda.src == '' || imagenLogoTienda.src == window.location.href)) 
    {
        showNotificationError("Se debe subir un logo de tienda");
        return false;
    }
    else if(logoTienda.files.length && !validacionTypeImagen(logoTienda))
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
    
    for (let i = 1; i <= 3; i++)
    {
        let img = document.getElementById("fileInput" + i);
        if(img.files.length && !validacionTypeImagen(img))
        {
            showNotificationError(`La imagen ${i} no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
            return false;
        }
        else if (img.files.length && !validacionSizeImagen(img, maxSize))
        {
            showNotificationError(`La imagen ${i} es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
            return false;
        }
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

async function sendImage(input, url, idTienda, idImagen) {
    console.log(idImagen);
    const formData = new FormData();
    formData.append(input.name, input.files[0]);
    formData.append('idTienda', idTienda); // Agregar el idTienda al formData
    formData.append(idImagen.name, idImagen.value); // Agregar el idImagen al formData

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
        alert("No se pudieron guardar las imágenes, ERROR: " + dataImagenes.statusImagenes + " " + dataImagenes.messageImagenes);
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
        showNotificationError("Se debe seleccionar al menos una categoria para la tienda");
        return false;
    }
    return true;
}

function validacionHorarios() {
    if(!horariosConfigurados())
    {
        showNotificationError("Se debe configurar al menos un horario");
        return false;
    }

    else if(!validarHorariosCorrectos())
    {
        return false;
    }
    return true;
}

function validacionBanner() {
    let img1 = document.getElementById("fileInput1");
    let imgSelec1 = document.getElementById("imagenSelec1");
    
    let img2 = document.getElementById("fileInput2");
    let imgSelec2 = document.getElementById("imagenSelec2");

    let img3 = document.getElementById("fileInput3");
    let imgSelec3 = document.getElementById("imagenSelec3");

    let logoTienda = document.getElementById("logoTienda");

    if (!img1.files.length && !img2.files.length && !img3.files.length && imgSelec1.src === window.location.href && imgSelec2.src === window.location.href && imgSelec3.src === window.location.href)
    {
        showNotificationError("Se debe subir al menos una imagen para el banner de la tienda");
        return false;
    }

    if (!imagenesValidacion(logoTienda))
    {
        return false;
    }
    return true;
}

function validacionCompletaPeriodos() {
    if(!periodosConfigurados())
    {
        showNotificationError("Se debe configurar al menos un periodo de apartado predeterminado");
        return false;
    }

    if(!validacionPeriodos())
    {
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