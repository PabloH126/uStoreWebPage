document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.file-input');

    mainForm.addEventListener('submit' , async function(e) {
        e.preventDefault();

        const response = await sendFormWitoutImages(mainForm);
        console.log(response);

        for (let input of fileInputs)
        {
            if (input.files.length > 0) {
                await sendImage(input, "../imagenesProducto.php");
            }
        }

        alert("formulario enviado con exito");
    })
})

function sendFormWitoutImages(form) {
    return new Promise((resolve, reject) => {
        const formData = new FormData(form);

        fileInputs.forEach(input => {
            formData.delete(input.name);
        });

        const xhr = new XMLHttpRequest();
        xhr.open(form.method, form.action);
        xhr.onload = () => resolve(xhr.responseText);
        xhr.onerror = () => reject(xhr.statusText);
        xhr.send(formData);
    })
}

function sendImage(input, url) {
    return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append(input.name, input.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.onload = () => resolve(xhr.responseText);
        xhr.onerror = () => reject(xhr.statusText);
        xhr.send(formData);
    })
}

