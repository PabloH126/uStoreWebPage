document.addEventListener("DOMContentLoaded", function() {
    const deleteStoreButtons = document.querySelectorAll(".delete-store-btn");

    deleteStoreButtons.forEach(button => {
        button.addEventListener("click", function() {
            const storeId = this.getAttribute("data-store-id");
            const modalOverlay = document.createElement("div");
            modalOverlay.classList.add("modal-overlay");
            
            const modal = document.createElement("div");
            modal.classList.add("modal");

            modal.innerHTML = `
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas eliminar este producto?</p>
                    <div class="modal-buttons">
                        <button class="modal-accept">Aceptar</button>
                        <button class="modal-cancel">Cancelar</button>
                    </div>
                </div>
            `;

            modalOverlay.appendChild(modal);
            document.body.appendChild(modalOverlay);

            const acceptButton = modal.querySelector(".modal-accept");
            const cancelButton = modal.querySelector(".modal-cancel");

            function closeModal() {
                modalOverlay.remove();
            }

            acceptButton.addEventListener("click", function() {
                acceptButton.disabled = true;
                cancelButton.disabled = true;
                submitButton.style.backgroundColor = "gray";
                fetch('../eliminar_producto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success')
                    {
                        closeModal();
                        const url = "https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/productos/lista_productos.php?id=" + data.idTienda;
                        showNotification("Producto eliminado exitosamente", url);
                    }
                    else
                    {
                        alert("Hubo un error al eliminar el producto: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error: ', error);
                    alert("Hubo un error al eliminar el producto");
                })
            });

            cancelButton.addEventListener("click", function() {
                closeModal();
            });

            modalOverlay.addEventListener("click", function(event) {
                if (event.target === modalOverlay) {
                    closeModal();
                }
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
            if (url) {
                window.location.href = url;
            }
        }, 2500);
    }

    function showNotification(message) {
        if (currentNotification) {
            currentNotification.remove();
        }
    
        const notification = document.createElement("div");
        notification.classList.add("notification");
        notification.textContent = message;
        document.body.appendChild(notification);
        
        currentNotification = notification;
    }
    
    function hideNotification() {
        if (currentNotification) {
            currentNotification.remove();
        }
    
        currentNotification = null;
    }
});
