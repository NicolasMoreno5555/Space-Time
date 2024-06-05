<?php
// Crear conexión
include("conexion.php");

$sql = "SELECT id_peluqueria, nombre, direccion, apertura, cierre, imagen FROM peluqueria";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $id_peluqueria = $row["id_peluqueria"];

        $directory = "imagenes_peluqueria/" . $id_peluqueria;
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        echo '<a href="detalles_peluqueria.php?id=' . $row["id_peluqueria"] . '" class="card-link">';
        echo '<div class="card">';
        $imagenPeluqueria = "data:image/png;base64," . $row["imagen"];
        echo '<img src="' . $imagenPeluqueria . '" alt="Imagen">';
        echo '<div class="card-content">';
        echo '<h2>' . $row["nombre"] . '</h2>';
        echo '<p>Dirección: ' . $row["direccion"] . '</p>';
        echo '<p>Horario: ' . $row["apertura"] . ' - ' . $row["cierre"] . '</p>';
        echo '</div>'; // Cierre
        echo '</div>';
        echo '</a>'; // Cierre de enlace
    }
} else {
    echo "0 resultados";
}
$result->close();
$conexion->close();
