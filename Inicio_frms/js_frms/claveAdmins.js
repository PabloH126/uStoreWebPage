let currentNotification;
const formClave = document.getElementById('ClaveAdmin');
const alertaClave = document.getElementById('formulario__mensaje');

document.addEventListener('DOMContentLoaded', function () {
    formClave.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = (formClave);
        fetch(formClave.action, {
            method: formClave.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success")
            {
                showNotification("Registro exitoso ¡Bienvenido a uStore!");
                setTimeout(() => {
                    hideNotification();
                    window.location.href = "https://ustoree.azurewebsites.net/index.php";
                }, 2500);
            }
            else
            {
                alertaClave.classList.add('formulario__mensaje-activo');  
            }
        })
        .catch(error => {
            showNotificationError(error);
        });
    })
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

function showNotificationError(message) {
    if (currentNotification) {
        currentNotification.remove();
    }
    const notification = document.createElement("div");
    notification.classList.add("notificationError");
    notification.textContent = message;
    document.body.appendChild(notification);
    console.log(notification);
    currentNotification = notification;
    setTimeout(() => {
        notification.classList.add("notificationErrorHide");
        setTimeout(() => {
            hideNotification();
        }, 550);
    }, 2500);
    
}