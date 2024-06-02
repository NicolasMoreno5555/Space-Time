<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <?php

    session_start();

    // manejo errores
    $errores = [];

    // Valido que se envíe por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validación de datos enviados
        $usuario = htmlspecialchars(trim($_POST['usuario']));
        $contraseña = htmlspecialchars(trim($_POST['password']));

        // Validar que los datos no estén vacíos
        if (empty($usuario)) {
            $errores[] = "El email o nickname está vacío.";
        }
        if (empty($contraseña)) {
            $errores[] = "La contraseña está vacía.";
        }

        // Continuar solo si no hay errores
        if (empty($errores)) {
            // Cifrar la contraseña una vez comprobada que existe
            $contraseñaCifrada = md5($contraseña);

            // Incluir el archivo de conexión a la base de datos
            include("conexion.php");

            // Comprobar la conexión
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Preparar la consulta SQL
            $stmt = $conexion->prepare("
            SELECT id, nombre, apellido, email, nickname, password 
            FROM usuario 
            WHERE email = ? OR nickname = ?
            
            ");

            // Vincular los parámetros
            $stmt->bind_param("ss", $usuario, $usuario);
            // Ejecutar la consulta
            $stmt->execute();
            // Obtener el resultado de la consulta
            $resultadosUsuario = $stmt->get_result();

            if ($fila = $resultadosUsuario->fetch_assoc()) {
                // Verificar la contraseña cifrada
                // Después de obtener $fila
                echo "Hash DB: " . $fila['password'] . "<br>";
                echo "Hash Generado: " . $contraseñaCifrada . "<br>";
                if ($contraseñaCifrada === $fila['password']) {
                    // Establecer las variables de sesión
                    $_SESSION['id'] = $fila['id'];
                    $_SESSION['nombre'] = $fila['nombre'];
                    $_SESSION['apellido'] = $fila['apellido'];

                    // Redirigir a inicio.php
                    echo "Redirigiendo al inicio";
                    header("Location: inicio.php");
                    exit();

                    header("Location: inicio.php");
                    exit();
                } else {
                    $errores[] = "contraseña incorrecta.";
                }
            } else {
                $errores[] = "No se pudo iniciar sesión, inténtelo otra vez.";
            }

            // Cerrar la conexión
            $stmt->close();
            $conexion->close();
        }

        // Recorrer el array de errores y mostrarlos en una lista
        if (!empty($errores)) {
            echo "<ul>";
            foreach ($errores as $error) {
                echo "<li>Ha ocurrido el siguiente error: $error</li>";
            }
            echo "</ul>";
        }
    }
    ?>


</head>

<body>
    <div id="contenedor" onclick="algo">

        <div id="contenedorcentrado">
            <div id="login">
                <form id="loginform" action="#" method="post">

                    <label for="usuario">Usuario</label>
                    <input id="usuario" type="text" name="usuario" placeholder="Usuario" required>

                    <label for="password">Contraseña</label>
                    <input id="password" type="password" placeholder="Contraseña" name="password" required>

                    <button type="submit" title="Ingresar" name="Ingresar">Entrar</button>
                </form>
            </div>
            <div id="derecho">
                <div class="titulo">
                    <p>Space&Time
                        Bienvenido</p>
                </div>
                <hr>
                <div class="pie-form">
                    <a href="#">Olvidaste tu contraseña?</a>
                    <a href="registrar.php">¿No tienes Cuenta? Registrate</a>
                    <hr>
                    <a href="#" style="display: none">« Volver</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>