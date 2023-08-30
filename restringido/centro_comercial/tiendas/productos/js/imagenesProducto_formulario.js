document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.querySelector('.form-tiendas');
    const fileInputs = document.querySelectorAll('.file-input');

    mainForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const data = await sendFormWithoutImages(mainForm, fileInputs);
            console.log(data);

            if (data.statusProducto === 'success' && data.statusCatP === 'success') {
                for (let input of fileInputs) {
                    if (input.files.length > 0) {
                        await sendImage(input, "../imagenesProducto.php", data.idProducto); // Pasar el idProducto
                    }
                }
                
                window.location.href = data.urlSalida;
            } else {
                alert("Hubo un error al guardar el producto <br>" + data.statusProducto + "<br>" + data.statusCatP);
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

    const response = await fetch(url, {
        method: 'POST',
        body: formData
    });
    
    const data = await response.json();

    if (data.statusImagenes !== 'success') {
        alert("No se pudieron guardar las imágenes, ERROR: " + data.statusImagenes);
        throw new Error("Fallo al guardar imágenes de producto");
    } 
}