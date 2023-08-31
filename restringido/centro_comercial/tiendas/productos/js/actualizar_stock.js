document.addEventListener("DOMContentLoaded", function() {
    const switchCheckbox = document.querySelectorAll(".switch-input");
    const stocksStatus = document.querySelectorAll('.stock-status');
    switchCheckbox.forEach((checkbox, index) => {
        const stockStatus = stocksStatus[index];

        checkbox.addEventListener("change", async function() {
            this.value = this.checked ? "1" : "0";
            await updateStock(this.dataset.productoId, this.value, this, stockStatus);
        });
    })

});

async function updateStock(idProducto, stock, checkbox, stockStatus)
{
    const formData = new URLSearchParams();
    formData.append('idProducto', idProducto);
    formData.append('stock', stock);
    const response = await fetch('actualizar_stock.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success')
        {
            showNotification(data.message);
            if(checkbox.value == "1")
            {
                stockStatus.classList.remove("stock-unavailable");
                stockStatus.classList.add("stock-available");
                stockStatus.textContent = "En stock";
            }
            else
            {
                stockStatus.classList.remove("stock-available");
                stockStatus.classList.add("stock-unavailable");
                stockStatus.textContent = "Sin stock";
            }
        }
        else
        {
            alert('Hubo un error en la actualizacion de stock: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showNotification(message) {
    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => {
        notification.remove();
    }, 2500);
}
