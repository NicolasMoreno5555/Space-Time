<?php
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];

// Obtener los datos del usuario
$sql = "SELECT nombre, apellido, email, biografia FROM usuario WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $biografia = htmlspecialchars(trim($_POST['biografia']));

    // Actualizar los datos del usuario
    $sqlUpdate = "UPDATE usuario SET nombre = ?, apellido = ?, biografia = ? WHERE id = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $nombre, $apellido, $biografia, $userId);
    if ($stmtUpdate->execute()) {
        header("Location: perfil.php");
        exit();
    } else {
        echo "Error al actualizar el perfil.";
    }
}

// Obtener la foto de perfil
$profilePhotoDir = "../fotosPerfil/" . $userId;
$profilePhoto = $profilePhotoDir . "/fotoperfil.jpg";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../Front/styles.css">
</head>
<body>
    <header>
        <span class="menu-icon" onclick="toggleSidebar()">&#9776;</span>
        <h1>Perfil de Usuario</h1>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar sesion</a></li>
            </ul>
        </nav>
    </header>

    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="citas.php">Citas pedidas</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
            <!-- Agregar otros enlaces según sea necesario -->
        </ul>
    </div>

    <main>
        <div class="cards-container">
            <div class="card profile-card">
                <img src="<?= $profilePhoto ?>" alt="Foto de perfil">
                <h2><?= htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']) ?></h2>
                <p><?= htmlspecialchars($usuario['email']) ?></p>
                <p><?= htmlspecialchars($usuario['biografia']) ?></p>

                <button onclick="toggleEditForm()">Editar Perfil</button>

                <div id="editForm" style="display: none;">
                    <form method="post" action="perfil.php">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br>

                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" required><br>

                        <label for="biografia">Biografía:</label>
                        <textarea id="biografia" name="biografia" required><?= htmlspecialchars($usuario['biografia']) ?></textarea><br>

                        <input type="submit" value="Guardar cambios">
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Space & Time. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function toggleEditForm() {
            const form = document.getElementById('editForm');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</body>
</html>
