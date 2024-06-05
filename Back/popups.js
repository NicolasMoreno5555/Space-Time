//  para agarrar el parametro status en la URL y mostrar mensaje
function getParameterByName(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

document.addEventListener('DOMContentLoaded', () => {
    const status = getParameterByName('status');
    console.log('URL status parameter:', status);  // Debug log
    if (status) {
        let message = '';
        let messageType = '';

        if (status === 'success') {
            message = 'Su reserva ha sido enviada con éxito.';
            messageType = 'success';
        } else if (status === 'error') {
            message = 'Hubo un error al procesar su reserva. Por favor, inténtelo de nuevo.';
            messageType = 'error';
        }

        if (message) {
            const messageContainer = document.createElement('div');
            messageContainer.className = `message ${messageType}`;
            messageContainer.textContent = message;
            document.body.appendChild(messageContainer);

            // Ocultar el mensaje después de 5 segundos
            setTimeout(() => {
                messageContainer.remove();
            }, 3000);
        }
    }
});

// para manejar el popup de confirmación
function confirmReservation(form) {
    const popup = document.getElementById('confirmationPopup');
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'block';
    popup.style.display = 'block';

    document.getElementById('confirmBtn').onclick = function () {
        form.submit();
    };
    document.getElementById('cancelBtn').onclick = function () {
        overlay.style.display = 'none';
        popup.style.display = 'none';
    };
}

function validateTime() {
    const apertura = "Esa hora no esta disponible, es muy temprano";
    const cierre = "o te has pasado de la hora de cierre";
    const selectedTime = document.getElementById('hora').value;

    if (selectedTime > apertura || selectedTime < cierre) {
        alert(`Por favor, seleccione una hora entre ${apertura} y ${cierre}.`);
        return false;
    }
    return true;
}