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
                        <button class="modal-accept">Aceptar</button>
                        <button class="modal-cancel">Cancelar</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            const acceptButton = modal.querySelector(".modal-accept");
            const cancelButton = modal.querySelector(".modal-cancel");

            acceptButton.addEventListener("click", function() {
                // Aquí puedes hacer lo que necesites al confirmar la eliminación
                console.log("Tienda eliminada:", storeId);
                // Cierra el modal
                modal.remove();
                // Mostrar notificación in-app
                showNotification("Tienda eliminada exitosamente");
            });

            cancelButton.addEventListener("click", function() {
                // Cierra el modal sin hacer nada
                modal.remove();
            });
        });
    });

    function showNotification(message) {
        const notification = document.createElement("div");
        notification.classList.add("notification");
        notification.textContent = message;
        document.body.appendChild(notification);
    }
});