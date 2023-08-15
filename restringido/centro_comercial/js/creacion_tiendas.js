document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('#checkbox-list input[type="checkbox"]');
    var maxSelect = 8;

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var counter = document.querySelectorAll('#checkbox-list input[type="checkbox"]:checked').length;

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

function horariosConfigurados() {
    const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

    for (let dia of dias)
    {
        let horaApertura = document.querySelector(`select[name="horas${dia}apertura"]`).value;
        let minutoApertura = document.querySelector(`select[name="minutos${dia}apertura"]`).value;
        let ampmApertura = document.querySelector(`select[name="am/pm${dia}apertura"]`).value;
        
        let horaCierre = document.querySelector(`select[name="horas${dia}cierre"]`).value;
        let minutoCierre = document.querySelector(`select[name="minutos${dia}cierre"]`).value;
        let ampmCierre = document.querySelector(`select[name="am/pm${dia}cierre"]`).value;

        if(horaApertura !== "00" || minutoApertura !== "00" || ampmApertura !== "am" || horaCierre !== "00" || minutoCierre !== "00" || ampmCierre !== "am")
        {
            return true;
        }
    }   

    return false;
}

function periodosConfigurados() {
    const periodos = ["Periodo1", "Periodo2", "Periodo3"];

    for (let periodo of periodos)
    {
        let numero = document.querySelector(`select[name="numero${periodo}"]`).value;
        let tiempo = document.querySelector(`select[name="tiempo${periodo}"]`).value;

        if(numero !== "1" || tiempo !== "minutos")
        {
            return true;
        }
    }

    return false;
}

document.querySelector("form").addEventListener("submit", function (e) {
    let img1 = document.getElementById("fileInput1").value;
    let img2 = document.getElementById("fileInput2").value;
    let img3 = document.getElementById("fileInput3").value;

    let logoTienda = document.getElementById("logoTienda").value;


    if (!logoTienda) {
        alert("Se debe subir un logo de tienda");
        e.preventDefault();
        return;
    }
    else if (!img1 && !img2 && !img3) {
        alert("Se debe subir al menos una imagen paraa el banner de la tienda");
        e.preventDefault();
        return;
    }

    let checkboxSelected = document.querySelectorAll('input[type="checkbox"]');
    let checked = Array.from(checkboxSelected).some(checkbox => checkbox.checked);

    if (!checked) {
        alert("Se debe seleccionar aal menos una categoria");
        e.preventDefault();
        return;
    }

    if(!horariosConfigurados())
    {
        alert("Se debe configurar al menos un horario");
        e.preventDefault();
    }
});