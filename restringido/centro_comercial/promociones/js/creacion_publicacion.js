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
        let logoTienda = document.getElementById("logoTienda");
        
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
        submitButton.style.backgroundColor = "gray";
    });
});