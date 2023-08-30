document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.file-input');

    mainForm.addEventListener('submit' , async function(e) {
        e.preventDefault();

        try {
            const data = await sendFormWitoutImages(mainForm, fileInputs);
            console.log(data);

            if (data.statusProducto === 'success' && data.statusCatP === 'success')
            {
                for (let input of fileInputs)
                {
                    if (input.files.length > 0)
                    {
                        await sendImage(input, "../imagenesProducto.php");
                    }
                }
                window.location.href = data.urlSalida;
            }
            else
            {
                alert("Hubo un error al guardar el producto <br>" + data.statusProducto + "<br>" + data.statusCatP);
            }

        } catch (error) {
            console.error('Error: ', error);
            alert("Hubo un error al realizar la solicitud de creacion de producto");
        }
        
    })
})

async function sendFormWitoutImages(form, fileInputs) {
    const formData = new FormData(form);

    fileInputs.forEach(input => {
        formData.delete(input.name);
    });

    const response = await fetch(form.action, {
        method: form.method,
        body: formData
    })


    return response.json();
};

async function sendImage(input, url) {
    const formData = new FormData();
    formData.append(input.name, input.files[0]);

    const response = await fetch(url, {
        method: 'POST',
        body: formData
    });
    
    const data = await response.json();

    if (data.status !== 'success')
    {
        alert("No se pudieron guardar las imagenes");
        throw new Error("Fallo al guardar imagenes de producto");
    } 
}

