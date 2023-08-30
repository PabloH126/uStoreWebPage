document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.file-input');

    mainForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const data = await sendFormWithoutImages(mainForm, fileInputs);

            if (data.statusProducto === 'success' && data.statusCatP === 'success') {
                for (let input of fileInputs) {
                    if (input && input.files.length > 0) {
                        await sendImage(input, "imagenesProducto.php", data.idProducto); // Pasar el idProducto
                    }
                }
                
                window.location.href = data.urlSalida;
            } else {
                alert("Hubo un error al guardar el producto. Estatus del producto: " + data.statusProducto + ". Estatus de las categorias: " + data.statusCatP);
            }

        } catch (error) {
            console.error('Error: ', error);
            alert("Hubo un error al realizar la solicitud de creación de producto: " + error);
        }
    });
});

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

async function sendImage(input, url, idProducto) {
    const formData = new FormData();
    formData.append(input.name, input.files[0]);
    formData.append('idProducto', idProducto); // Agregar el idProducto al formData

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
        alert("No se pudieron guardar las imágenes, ERROR: " + dataImagenes.statusImagenes);
    } 
}