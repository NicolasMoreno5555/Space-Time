<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $apertura = $_POST['apertura'];
    $cierre = $_POST['cierre'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];


    $stmt = $conexion->prepare("CALL agregar_peluqueria(?, ?, ?, ?,?,?,?,?,?)");
    $stmt->bind_param("isssssiss", $nombre, $direccion, $correo, $telefono, $apertura, $cierre, $latitud, $longitud);

    if ($stmt->execute()) {
        header("Location: inicio_admin.php");
        exit();
    } else {
        echo "Error al agregar la peluquería.";
    }
}
