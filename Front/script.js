function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar.style.left === '-250px') {
        sidebar.style.left = '0';
    } else {
        sidebar.style.left = '-250px';
    }
}
function closeModal() {
    document.getElementById("eventModal").style.display = "none";
}

function deleteEvent(eventId) {
    // Aquí se manejará la eliminación de la cita
    console.log('Eliminar cita con ID: ', eventId);
    closeModal();
}

function viewEventDetails(eventId) {
    // Aquí se manejarán los detalles de la cita
    console.log('Ver detalles de la cita con ID: ', eventId);
    closeModal();
}

function initMap() {
    if (typeof latitud !== 'undefined' && typeof longitud !== 'undefined') {
        var peluqueriaLocation = { lat: latitud, lng: longitud };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: peluqueriaLocation
        });

        var marker = new google.maps.Marker({
            position: peluqueriaLocation,
            map: map
        });
    } else {
        console.error("Latitud y Longitud no están definidas.");
    }
}

