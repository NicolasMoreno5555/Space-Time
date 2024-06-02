<?php
include "conexion.php";
$conexion = new mysqli(DBSERVER, DBUSER, DBPSW, DBNAME);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}


//manejar con datos de sesion mas adelante


$sql = "SELECT id, title, start, end FROM citas WHERE user_id = ?"; // Ajusta la consulta según tu base de datos
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $userId); // asume qq $userId es el ID del usuario actual
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end']
    ];
}

$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas | Space & Time</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: [
                    // Aquí se cargarán las citas desde la base de datos
                    // Por ejemplo:
                    // {
                    //     title: 'Cita con Juan',
                    //     start: '2024-05-26T10:00:00',
                    //     end: '2024-05-26T11:00:00',
                    //     id: '1'
                    // }
                ],
                eventClick: function(info) {
                    var eventObj = info.event;
                    var modal = document.getElementById("eventModal");
                    var modalContent = document.getElementById("modalContent");

                    modalContent.innerHTML = `
                        <h2>${eventObj.title}</h2>
                        <p>Fecha: ${eventObj.start.toLocaleString()}</p>
                        <button onclick="deleteEvent(${eventObj.id})">Eliminar Cita</button>
                        <button onclick="viewEventDetails(${eventObj.id})">Ver Detalles</button>
                    `;
                    modal.style.display = "block";
                }
            });

            calendar.render();
        });

        function closeModal() {
            document.getElementById("eventModal").style.display = "none";
        }

        function deleteEvent(eventId) {
            // Aquí se manejarán las eliminaciónes de lsa citas
            console.log('Eliminar cita con ID: ', eventId);
            closeModal();
        }

        function viewEventDetails(eventId) {
            // Aquí se manejan los detalles de la cita
            console.log('Ver detalles de la cita con ID: ', eventId);
            closeModal();
        }
    </script>
</head>
<body>
    <header>
        <div class="menu-icon" onclick="toggleMenu()">
            &#9776;
        </div>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="perfil.html">Perfil</a></li>
                <li><a href="citas.php">Mis Citas</a></li>
            </ul>
        </nav>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleMenu()">&times;</div>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="perfil.html">Perfil</a></li>
            <li><a href="citas.php">Mis Citas</a></li>
        </ul>
    </aside>

    <main>
        <div id="calendar"></div>
    </main>

    <footer>
        <div class="social-links">
            <!-- Links a redes sociales -->
        </div>
        <div class="legal-links">
            <a href="politicas_privacidad.html">Políticas de Privacidad</a>
            <a href="aviso_legal.html">Aviso Legal</a>
        </div>
    </footer>

    <div id="eventModal" style="display: none;">
        <div id="modalContent"></div>
        <button onclick="closeModal()">Cerrar</button>
    </div>

    <script src="script.js"></script>
</body>
</html>
