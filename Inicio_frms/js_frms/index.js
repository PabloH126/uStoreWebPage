const alertaEmailRegistrado = document.getElementById("formulario__mensaje");
const formRegistro = document.getElementById("RegistroAdmin");
document.addEventListener('DOMContentLoaded', function () {
    formRegistro.addEventListener('submit', async function (e) {
        e.preventDefault();
        let emailInput = document.getElementById('emailA');
        if (emailInput.value !== "")
        {
            const responseVerifyEmail = await fetch(`https://ustoreapi.azurewebsites.net/api/Register/VerifyEmail?email=${emailInput.value}`, {
                method: 'GET'
            });

            if (responseVerifyEmail.status === 200)
            {
                formRegistro.submit();
            }
            else if (responseVerifyEmail.status === 409)
            {
                alertaEmailRegistrado.classList.add('formulario__mensaje-activo');
            }
            else
            {
                console.error(`Error en la solicitud. Código de estado: ${responseVerifyEmail.status}`);
            }
            
        }
        
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