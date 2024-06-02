<?php
// Crear conexión
include ("conexion.php");

$sql = "SELECT id_peluqueria, nombre, direccion, apertura, cierre FROM peluqueria";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<a href="detalles_peluqueria.php?id=' . $row["id_peluqueria"] . '" class="card-link">';
        echo '<div class="card">';
        echo '<img src="..\imagenes_peluquerias\\' . $row["id_peluqueria"] . '\\foto.jpg">';
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

$conexion->close();