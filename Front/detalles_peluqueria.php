<?php
session_start();
include('conexion.php'); // Incluye tu archivo de conexión a la base de datos

// Obtener el ID de la peluquería desde la URL
$id_peluqueria = $_GET['id'];



// Consultar detalles de la peluquería
$query_peluqueria = "SELECT nombre, direccion, telefono FROM peluqueria WHERE id_peluqueria = ?";
$stmt_peluqueria = $conexion->prepare($query_peluqueria);
$stmt_peluqueria->bind_param("i", $id_peluqueria);
$stmt_peluqueria->execute();
$result_peluqueria = $stmt_peluqueria->get_result();
$peluqueria = $result_peluqueria->fetch_assoc();

// Consultar servicios de la peluquería
$query_servicios = "SELECT id_servicio, nombre, duracion, precio, disponible FROM servicio WHERE id_peluqueria = ?";
$stmt_servicios = $conexion->prepare($query_servicios);
$stmt_servicios->bind_param("i", $id_peluqueria);
$stmt_servicios->execute();
$result_servicios = $stmt_servicios->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Peluquería</title>
    <link rel="stylesheet" href="styles.css">
    <script src="../Back/popups.js"></script>
    <style>
        /* Estilos para los mensajes de éxito y error */
        .message {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .message.success {
            background-color: green;
        }

        .message.error {
            background-color: red;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
        }

        #confirmationPopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: none;
            z-index: 1001;
        }

        #confirmationPopup button {
            margin: 5px;
        }
    </style>

</head>

<body>

    <header>
        <div class="menu-icon" onclick="toggleMenu()">
            &#9776;
        </div>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a>
                <li><a href="logout.php">Cerrar sesion</a></li>
                </li>
            </ul>
        </nav>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleMenu()">&times;</div>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="perfil.html">Perfil</a></li>
            <li><a href="citas.php">Citas pedidas</a></li>
        </ul>
    </aside>

    <main>

        <div class="profile-card">
            <img src="../imagenes_peluquerias/<?= $id_peluqueria ?>/foto.jpg" alt="Foto de la Peluquería">
            <h2><?php echo htmlspecialchars($peluqueria['nombre']); ?></h2>
            <p>Dirección: <?php echo htmlspecialchars($peluqueria['direccion']); ?></p>
            <p>Teléfono: <?php echo htmlspecialchars($peluqueria['telefono']); ?></p>
        </div>

        <div class="content-container">
            <h2>Servicios Ofrecidos</h2>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Duración</th>
                    <th>Precio</th>
                    <th>Disponibilidad</th>
                    <th>Reservar</th>
                </tr>
                <?php while ($servicio = $result_servicios->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($servicio['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($servicio['duracion']); ?> minutos</td>
                        <td>€<?php echo htmlspecialchars($servicio['precio']); ?></td>
                        <td><?php echo $servicio['disponible'] ? 'Sí' : 'No'; ?></td>
                        <td>
                            <?php if ($servicio['disponible'] === 1) { ?>
                                <form onsubmit="event.preventDefault(); if (validateTime()) confirmReservation(this);" action="reservar.php" method="POST">
                                    <input type="hidden" name="id_peluqueria" value="<?php echo $id_peluqueria; ?>">
                                    <input type="hidden" name="id_servicio" value="<?php echo $servicio['id_servicio']; ?>">
                                    <label for="fecha">Fecha:</label>
                                    <input type="date" id="fecha" name="fecha" required>
                                    <label for="hora">Hora:</label>
                                    <input type="time" id="hora" name="hora" required>
                                    <input type="submit" value="Reservar">
                                    </form>
                                <?php } else { ?>
                                    <p>No disponible</p>
                                <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>


    <div id="overlay"></div>
    <div id="confirmationPopup">
        <p>¿Está seguro de que desea confirmar la reserva?</p>
        <button id="confirmBtn">Confirmar</button>
        <button id="cancelBtn">Cancelar</button>
    </div>

</body>

</html>