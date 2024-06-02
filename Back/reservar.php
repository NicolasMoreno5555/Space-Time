<?php
session_start();

include ("../front/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id'];
    $id_peluqueria = $_POST['id_peluqueria'];
    $id_servicio = $_POST['id_servicio'];

    // Obtener la duración del servicio
    $query_servicio = "SELECT duracion FROM servicio WHERE id_servicio = ?";
    $stmt_servicio = $conexion->prepare($query_servicio);
    $stmt_servicio->bind_param("i", $id_servicio);
    $stmt_servicio->execute();
    $result_servicio = $stmt_servicio->get_result();
    $servicio = $result_servicio->fetch_assoc();
    $duracion = $servicio['duracion'];

    $fecha_reserva = date('Y-m-d H:i:s');
    $precio_reserva = 1; // Precio fijo de 1€

    // insertp la reserva en la base de datos
    $query_reserva = "INSERT INTO reserva (id_usuario, id_peluqueria, fecha_reserva, duracion, precio_reserva, id_servicio) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_reserva = $conexion->prepare($query_reserva);
    $stmt_reserva->bind_param("iisiii", $id_usuario, $id_peluqueria, $fecha_reserva, $duracion, $precio_reserva, $id_servicio);
    if ($stmt_reserva->execute()) {
        header("Location: ../Front/detalles_peluqueria.php?id=$id_peluqueria&status=success");
    } else {
        header("Location: ../Front/detalles_peluqueria.php?id=$id_peluqueria&status=error");
    }
}
