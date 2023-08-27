document.addEventListener("DOMContentLoaded", function() {
    const deleteStoreButtons = document.querySelectorAll(".delete-store-btn");

    deleteStoreButtons.forEach(button => {
        button.addEventListener("click", function() {
            const storeId = this.getAttribute("data-store-id");
            const modal = document.createElement("div");
            modal.classList.add("modal");

            modal.innerHTML = `
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas eliminar esta tienda?</p>
                    <div class="modal-buttons">
                        <button type="button" class="modal-accept" onclick="https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/eliminarTienda.php">Aceptar</button>
                        <button type="button" class="modal-cancel">Cancelar</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            const acceptButton = modal.querySelector(".modal-accept");
            const cancelButton = modal.querySelector(".modal-cancel");

            acceptButton.addEventListener("click", function() {
                acceptButton.disabled = true;
                cancelButton.disabled = true;
                fetch('https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/eliminarTienda.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success')
                    {
                        modal.remove();
                        const url = "https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_tiendas.php?id=" + data.idMall;
                        showNotification("Tienda eliminada exitosamente", url);
                    }
                    else
                    {
                        alert("Hubo un error al eliminar la tienda" + data.message);
                    }
                })
                .then(

                )
                .catch(error => {
                    console.error('Error: ', error);
                    alert("Hubo un error al eliminar la tienda");
                })
            });

            cancelButton.addEventListener("click", function() {
                modal.remove();
            });
        });
    });

    function showNotification(message, url) {
        const notification = document.createElement("div");
        notification.classList.add("notification");
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
            if (url)
            {
                window.location.href = url;
            }
        }, 3000);
    }
});