<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página Web</title>
    <link rel="stylesheet" href="styles.css">
    <?php session_start(); ?>
</head>

<body>
    <header>
        <div class="menu-icon" onclick="toggleMenu()">
            &#9776;
        </div>
        <h1>
            <p>Bienvenido/a <?= htmlspecialchars($_SESSION['nombre']) ?></p>
        </h1>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a>
                <li><a href="logout.php">Cerrar sesion</a></li>
                </li>
            </ul>
        </nav>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleMenu()">&times;</div>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="perfil.html">Perfil</a></li>
            <li><a href="citas.php">Citas pedidas</a></li>

            <!-- Agrega más elementos de menú según sea necesario -->
        </ul>

    </aside>

    <main>
        <section class="cards-container">
            <?php include "../Back/get_peluquerias.php" ?>
        </section>
    </main>

    <footer>
        <div class="social-links">
            <a href="https://www.facebook.com/Spacetime" target="_blank">Facebook</a>
            <a href="https://www.twitter.com/Spacetime" target="_blank">Twitter</a>
            <a href="https://www.instagram.com/Spacetime" target="_blank">Instagram</a>
        </div>
        <div class="legal-links">
            <a href="politicas_privacidad.html">Políticas de Privacidad</a>
            <a href="aviso_legal.html">Aviso Legal</a>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>