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
    fetch('actualizar_stock.php?idProducto=' + idProducto + '&stock=' + stock, {
        method: 'POST',
        headers()
    });
}
