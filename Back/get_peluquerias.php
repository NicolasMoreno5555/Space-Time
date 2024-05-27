<?php
// Crear conexión
include "conexion.php";
$conn = new mysqli(DBSERVER, DBUSER, DBPSW, DBNAME);

// Verifico conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id_peluqueria, nombre, direccion, apertura, cierre FROM peluqueria";
$result = $conn->query($sql);

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

$conn->close();
