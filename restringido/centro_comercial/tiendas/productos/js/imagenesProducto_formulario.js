document.querySelectorAll('.file-input').forEach(input => {
    input.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if(file)
        {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgSrc = e.target.result;
                
            }
        }
    });
});

function createImageForm(imgSrc, inputElement) {
    const form = document.createElement('form');
    form.action = 'uploadImagenProducto.php';
    form.method = 'post';
    form.enctype = 'multipart/form-data';

    const img = document.createElement('img');
    img.src = imgSrc;
    img.alt = 
}

