<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_peluqueria'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $apertura = $_POST['apertura'];
    $cierre = $_POST['cierre'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $stmt = $conexion->prepare("CALL actualizar_peluqueria(?, ?, ?, ?, ?,?,?,?,?)");
    $stmt->bind_param("isssssiss", $id, $nombre, $direccion,$correo , $apertura, $cierre,$telefono, $latitud, $longitud);

    if ($stmt->execute()) {
        header("Location: inicio_admin.php");
        exit();
    } else {
        echo "Error al modificar la peluquería.";
    }
}
?>
