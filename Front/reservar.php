<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id'];
    $id_peluqueria = $_POST['id_peluqueria'];
    $id_servicio = $_POST['id_servicio'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $minutos = $_POST['minutos'] . '0';
    $minutos = substr($minutos, 0, 2);
    $date_time = $fecha . ' ' . $hora . ':' . $minutos . ':00';
    $precio_reserva = 1; // Precio fijo de 1€


    echo $date_time;

    // Obtener la duración del servicio
    $query_servicio = "SELECT duracion FROM servicio WHERE id_servicio = ?";
    $stmt_servicio = $conexion->prepare($query_servicio);
    $stmt_servicio->bind_param("i", $id_servicio);
    echo $query_servicio;
    $stmt_servicio->execute();
    $result_servicio = $stmt_servicio->get_result();
    $servicio = $result_servicio->fetch_assoc();
    $duracion = $servicio['duracion'];


    // Calcular la hora de finalización de la reserva
    $timestamp_inicio = strtotime($date_time);
    $timestamp_fin = strtotime("+$duracion hour", $timestamp_inicio);
    $date_time_fin = date('Y-m-d H:i:s', $timestamp_fin);

    // Verificar si hay una reserva en el mismo horario
    $query_check = "SELECT * FROM reserva WHERE id_peluqueria = ? AND (
                    (fecha_reserva <= ? AND DATE_ADD(fecha_reserva, INTERVAL duracion HOUR) > ?) OR
                    (fecha_reserva < ? AND DATE_ADD(fecha_reserva, INTERVAL duracion HOUR) >= ?)
                    )";
    $stmt_check = $conexion->prepare($query_check);
    $stmt_check->bind_param("issss", $id_peluqueria, $date_time, $date_time, $date_time_fin, $date_time);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        die("Error: La hora seleccionada ya está reservada.");
    } else {
        $query_reserva = "INSERT INTO reserva   (id_usuario, id_peluqueria, fecha_reserva, duracion, precio_reserva, id_servicio) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_reserva = $conexion->prepare($query_reserva);
        $stmt_reserva->bind_param("iisiii", $id_usuario, $id_peluqueria, $date_time, $duracion, $precio_reserva, $id_servicio);
        if ($stmt_reserva->execute()) {
            header("Location: ../Front/detalles_peluqueria.php?id=$id_peluqueria&status=success");
        } else {
            header("Location: ../front/detalles_peluqueria.php?id=$id_peluqueria&status=error");
        }
        $stmt_reserva->close();
        $stmt_servicio->close();
    }




    // Insertar la reserva en la base de datos

    $conexion->close();
    exit();
}
