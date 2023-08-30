$(document).ready(function() {
    $(".switch-input").change(function() {
        var isChecked = $(this).prop("checked");
        var stockStatus = isChecked ? "Hay Stock" : "Sin Stock";
        $(this).closest(".stock-switch").find(".stock-status").text(stockStatus);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const switchCheckbox = document.querySelectorAll(".switch-input");

    switchCheckbox.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            this.value = this.checked ? "1" : "0";
            updateStock(this.dataset.productoId, this.value);
        });
    })

});

async function updateStock(idProducto, stock)
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
            showNotification("")
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showNotification(message, url) {
    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => {
        notification.remove();
    }, 2500);
}
