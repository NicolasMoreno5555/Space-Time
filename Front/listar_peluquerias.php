<?php
include("conexion.php");

$result = $conexion->query("SELECT id_peluqueria, nombre, direccion, correo, apertura, cierre, telefono, latitud, longitud, imagen FROM peluqueria");

while ($row = $result->fetch_assoc()) {
    $id = $row['id_peluqueria'];
    echo "<div class='card-peluqueria' id='card-{$row['id_peluqueria']}'>";
    echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
    echo "<p>Dirección: " . htmlspecialchars($row['direccion']) . "</p>";
    echo "<p>Teléfono: " . htmlspecialchars($row['telefono']) . "</p>";
    echo "<p>Apertura: " . htmlspecialchars($row['apertura']) . "</p>";
    echo "<p>Cierre: " . htmlspecialchars($row['cierre']) . "</p>";
    echo "<button onclick='toggleEditForm({$id})'>Modificar</button>";

    // Formulario para modificar peluquería
    echo "<form id='editForm-{$id}' style='display:none;' action='update_peluqueria.php' method='post'>";
    echo "<input type='hidden' name='id_peluqueria' value='" . $row['id_peluqueria'] . "'>";
    echo "<label for='nombre'>Nombre:</label>";
    echo "<input type='text' id='nombre' name='nombre' value='" . htmlspecialchars($row['nombre']) . "' required>";
    echo "<label for='direccion'>Dirección:</label>";
    echo "<input type='text' id='direccion' name='direccion' value='" . htmlspecialchars($row['direccion']) . "' required>";
    echo "<label for='correo'>Correo:</label>";
    echo "<input type='text' id='correo' name='correo' value='" . htmlspecialchars($row['correo']) . "' required>";
    echo "<label for='telefono'>Teléfono:</label>";
    echo "<input type='text' id='telefono' name='telefono' value='" . htmlspecialchars($row['telefono']) . "' required>";
    echo "<label for='apertura'>Apertura:</label>";
    echo "<input type='text' id='apertura' name='apertura' value='" . htmlspecialchars($row['apertura']) . "' required>";
    echo "<label for='cierre'>Cierre:</label>";
    echo "<input type='text' id='cierre' name='cierre' value='" . htmlspecialchars($row['cierre']) . "' required>";
    echo "<label for='latitud'>Latitud:</label>";
    echo "<input type='text' id='latitud' name='latitud' value='" . htmlspecialchars($row['latitud']) . "' required>";
    echo "<label for='longitud'>Longitud:</label>";
    echo "<input type='text' id='longitud' name='longitud' value='" . htmlspecialchars($row['longitud']) . "' required>";
    echo "<input type='submit' value='Guardar'>";
    echo "<button type='button' onclick='toggleEditForm({$id})'>Cancelar</button>";
    echo "</form>";

    // Formulario para eliminar peluquería
    echo "<form action='eliminar_peluqueria.php' method='post' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar esta peluquería?\");'>";
    echo "<input type='hidden' name='id_peluqueria' value='" . $row['id_peluqueria'] . "'>";
    echo "<input type='submit' value='Eliminar'>";
    echo "</form>";

    echo "</div>";
}
?>
<script>
    function toggleEditForm(id_peluqueria) {
        const form = document.getElementById('editForm-' + id_peluqueria);
        const card = document.getElementById('card-' + id_peluqueria);
        if (form.style.display === 'none') {
            form.style.display = 'block';
            card.querySelector('h3').style.display = 'none';
            card.querySelectorAll('p').forEach(p => p.style.display = 'none');
            card.querySelector('button[onclick^="toggleEditForm"]').style.display = 'none';
        } else {
            form.style.display = 'none';
            card.querySelector('h3').style.display = 'block';
            card.querySelectorAll('p').forEach(p => p.style.display = 'block');
            card.querySelector('button[onclick^="toggleEditForm"]').style.display = 'block';
        }
    }
</script>