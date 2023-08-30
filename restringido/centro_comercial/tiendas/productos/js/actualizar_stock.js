document.addEventListener("DOMContentLoaded", function() {
    const switchCheckbox = document.querySelectorAll(".switch-input");

    switchCheckbox.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            if (this.checked) {
                updateStock
            }
        })
    })

});

function updateStock(idProducto, stock)
{
    fetch('https://ustoreapi.azurewebsites.net/api/Productos/CreateProducto?idProducto')
}
