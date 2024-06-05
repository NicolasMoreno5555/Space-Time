<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilo para las tarjetas */

        body {
            display: flex;
            flex-direction: column;
            /* Alineación vertical de todos los elementos del body */
            align-items: center;
            /* Centrado horizontal */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        main{
            width: 85%;
        }
        .container-titulo{
            max-width: 100%;
            width: 100%;
            height: 100%;
            text-align: center;
            justify-content: center;
            padding: 0;
        }
        .titulo{
            padding: 0;
            margin-left: 5%;
        }
        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 40%;
            max-width: 100%;
            /* Centra los elementos en la dirección horizontal */
            padding: 1%;
            margin: 0;
        }

        /* Estilo para los títulos */
        .card h3 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
        }

        /* Estilo para los párrafos */
        .card p {
            margin: 8px 0;
            color: #555;
        }

        /* Estilo para los botones */
        .card button,
        .card input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
        }

        /* Estilo para los botones en estado hover */
        .card button:hover,
        .card input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .card-peluqueria {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: calc(50% - 20px);
            /* Ancho calculado para que dos tarjetas llenen el 100% menos 20px de espacio entre ellas */
            transition: box-shadow 0.3s ease-in-out;
        }

        /* Estilo para el formulario de edición */
        .card form {
            display: flex;
            flex-direction: column;
        }

        .card form label {
            margin-top: 10px;
            font-weight: bold;
        }

        .card form input[type="text"] {
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Estilo para el formulario de eliminación */
        .card form[action="eliminar_peluqueria.php"] {
            margin-top: 20px;
        }

        .card form[action="eliminar_peluqueria.php"] input[type="submit"] {
            background-color: #dc3545;
        }

        .card form[action="eliminar_peluqueria.php"] input[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
    <?php
    session_start();
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        header("Location: inicio.php");
        exit();
    }
    ?>
</head>

<body>

    <header>
        <div class="menu-icon" onclick="toggleMenu()">
            &#9776;
        </div>
        <h1 class="welcome-message">
            Bienvenido/a <?= htmlspecialchars($_SESSION['nombre']) ?> al Panel de Administración
        </h1>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) : ?>
                    <li><a href="inicio_admin.php">Panel de Administración</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleMenu()">&times;</div>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="citas.php">Citas pedidas</a></li>
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) : ?>
                <li><a href="inicio_admin.php">Panel de Administración</a></li>
            <?php endif; ?>
        </ul>
    </aside>

    <main>
        <section class="cards-container">
            <div class="container-titulo">
            <h2 class="titulo">Gestionar Peluquerías</h2>
            </div>
            <!-- Formulario para agregar nueva peluquería -->
            <div class="card">
                <h2>Agregar Peluquería</h2>
                <form action="agregar_peluqueria.php" method="post">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" required>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" required>
                    <label for='apertura'>Apertura:</label>
                    <input type='text' id='apertura' name='apertura' required>
                    <label for='cierre'>Cierre:</label>
                    <input type='text' id='cierre' name='cierre' required>
                    <label for='latitud'>Latitud:</label>
                    <input type='text' id='latitud' name='latitud' required>
                    <label for='longitud'>Longitud:</label>
                    <input type='text' id='longitud' name='longitud' required>
                    <input type="submit" value="Agregar">
                </form>
            </div>

            <!-- Listado de peluquerías con opciones para modificar y eliminar -->
            <div class="card">
                <h2>Listado de Peluquerías</h2>
                <?php include "listar_peluquerias.php"; ?>
            </div>
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