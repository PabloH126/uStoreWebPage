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
                    <p>¿Estás seguro de que deseas eliminar esta tienda? También se eliminarán todos los productos asociados a ella.</p>
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
                acceptButton.style.backgroundColor = "gray";

                showNotification('Eliminando tienda...');
                fetch('../tiendas/eliminarTienda.php', {
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
                        const url = "https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_tiendas.php?id=" + data.idMall;
                        hideNotification();
                        showNotification("Tienda eliminada exitosamente");
                        setTimeout(() => {
                            hideNotification();
                            window.location.href = url;
                        }, 2500);
                    }
                    else
                    {
                        alert("Hubo un error al eliminar la tienda" + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error: ', error);
                    alert("Hubo un error al eliminar la tienda");
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
