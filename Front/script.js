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