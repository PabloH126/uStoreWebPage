let form = document.querySelector('.form-tiendas');
let progressOptions = document.querySelectorAll('.progressbar__option');

form.addEventListener('click', function(e) {
    let element = e.target; //detectar donde se hace click
    let isButtonNext = element.classList.contains('bttn-next');
    let isButtonBack = element.classList.contains('bttn-back');

    if (isButtonNext || isButtonBack) {
        //si fue seleccionado el bttn-next o el bttn-back
        let currentStep = document.getElementById('item-' + element.dataset.item);
        let jumpStep = document.getElementById('item-' + element.dataset.to_item);
        alert(currentStep, jumpStep);        /*
        currentStep.addEventListener('animationend', function callback() {
            currentStep.classList.remove('active');
            jumpStep.classList.add('active');
            if (isButtonNext) {
                currentStep.classList.add('to-left');
                progressOptions[element.dataset.to_step - 1].classList.add('active');
            } else {
                jumpStep.classList.remove('to-left');
                progressOptions[element.dataset.step - 1].classList.remove('active');
            }
            currentStep.removeEventListener('animationend', callback);
        });
        currentStep.classList.add('inactive');
        jumpStep.classList.remove('inactive');*/
    }
});