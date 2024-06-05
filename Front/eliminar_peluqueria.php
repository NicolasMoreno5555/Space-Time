<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_peluqueria'];

    $stmt = $conexion->prepare("CALL eliminar_peluqueria(?)");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: inicio_admin.php");
        exit();
    } else {
        echo "Error al eliminar la peluquería.";
    }
}
?>
