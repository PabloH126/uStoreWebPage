document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.optionsC input[type="checkbox"]');
    var maxSelect = 8;
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.fileInputBanner');
    let currentNotification;

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

        if (!logoTienda.files.length) 
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

        if (!img1.files.length && !img2.files.length && !img3.files.length) {
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

        var submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        try {
            const data = await sendFormWithoutImages(mainForm, fileInputs);

            if (data.statusTienda === 'success' && data.statusHorarios === 'success' && data.statusCatT === 'success' && data.statusPeriodos === 'success') {
                showNotification("Cargando imagenes...", currentNotification);
                alert(data.idTienda);
                for (let input of fileInputs) {
                    if (input && input.files.length > 0) {
                        await sendImage(input, "imagenesTienda.php", data.idTienda); // Pasar el idTienda
                    }
                }
                hideNotification(currentNotification);
                showNotification("Tienda creada", currentNotification);
                setTimeout(() => {
                    hideNotification();
                }, 2500);
                //window.location.href = data.urlSalida;
            } else {
                alert("Hubo un error al guardar la tienda. Estatus de la tienda: " + data.statusTienda + ". Estatus de los horarios: " + data.statusHorarios + ". Estatus de las categorias: " + data.statusCatT + ". Estatus de los periodos: " + data.statusPeriodos);
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

        if(apertura || cierre)
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
            alert(`Por favor ingresa la hora de cierre del ${dia}`)
            return false;
        }
        else if(!apertura && cierre)
        {
            alert(`Por favor ingresa la hora de apertura de ${dia}`)
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
            alert(`Por favor ingresa un horario válido para el día ${dia}.`);
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
            alert(`Por favor ingresa un periodo de apartado predeterminado válido para el ${periodo}`);
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

function imagenesValidacion(logoTienda) {
    const maxSize = 1 * 1024 * 1024;

    if(logoTienda.files.length && !validacionTypeImagen(logoTienda))
    {
        alert(`La imagen del logo de la tienda no es valida, por favor sube una imagen que sea JPEG, PNG o JPG`);
        return false;
    }
    else if (logoTienda.files.length && !validacionSizeImagen(logoTienda, maxSize))
    {
        alert(`La imagen del logo de la tienda es demasiado pesada, por favor sube una imagen que pese máximo 1 megabyte`);
        return false;
    }
    
    for (let i = 1; i <= 3; i++)
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

async function sendImage(input, url, idTienda) {
    const formData = new FormData();
    formData.append(input.name, input.files[0]);
    formData.append('idTienda', idTienda); // Agregar el idTienda al formData
    alert(idTienda + ' sendImage');
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
        alert("No se pudieron guardar las imágenes, ERROR: " + dataImagenes.statusImagenes + " " + dataImagenes.messageImagenes);
    } 
}

function showNotification(message, currentNotification) {
    if (currentNotification) {
        currentNotification.remove();
    }

    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    document.body.appendChild(notification);
    
    currentNotification = notification;
}

function hideNotification(currentNotification) {
    if (currentNotification) {
        currentNotification.remove();
        currentNotification = null;
    }
}