document.addEventListener("DOMContentLoaded", function() {
    const switchCheckbox = document.querySelectorAll(".switch-input");

    switchCheckbox.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            if (this.checked) {
                updateStock()
            }
        })
    })

});

function updateStock(idProducto, stock)
{
    const formData = new URLSearchParams();
    formData.append('idProducto', idProducto);
    formData.append('stock', stock);
    fetch('actualizar_stock.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
