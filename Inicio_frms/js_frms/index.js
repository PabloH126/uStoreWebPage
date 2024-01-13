const alertaEmailRegistrado = document.getElementById("formulario__mensaje");
const formRegistro = document.getElementById("formR");
document.addEventListener('DOMContentLoaded', function () {
    formRegistro.addEventListener('submit', async function (e) {
        e.preventDefault();
        let emailInput = document.getElementById('emailA');
        console.log("holi");
        if (emailInput.value !== "")
        {
            //const responseVerifyEmail = await fetch(`https://ustoreapi.azurewebsites.net/api/Register/VerifyEmail?email=${emailInput.value}`);
            
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