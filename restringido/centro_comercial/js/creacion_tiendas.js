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

document.querySelector("form").addEventListener("submit", function (e) {
    let img1 = document.getElementById("fileInput1").value;
    let img2 = document.getElementById("fileInput2").value;
    let img3 = document.getElementById("fileInput3").value;

    let logoTienda = document.getElementById("logoTienda").value;

    if(!nombreValidacion())
    {
        alert("Por favor ingresa un nombre para la tienda");
        e.preventDefault();
        return;
    }

    if (!logoTienda) {
        alert("Se debe subir un logo de tienda");
        e.preventDefault();
        return;
    }

    let checkboxSelected = document.querySelectorAll('input[type="checkbox"]');
    let checked = Array.from(checkboxSelected).some(checkbox => checkbox.checked);

    if (!checked) {
        alert("Se debe seleccionar al menos una categoria");
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

    if (!img1 && !img2 && !img3) {
        alert("Se debe subir al menos una imagen paraa el banner de la tienda");
        e.preventDefault();
        return;
    }

    if(!periodosConfigurados())
    {
        alert("Se debe configurar al menos un periodo de apartado predeterminado");
        e.preventDefault();
        return;
    }
});