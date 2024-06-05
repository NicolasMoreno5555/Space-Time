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

    //recaptcha
    if (isset($_POST['Ingresar'])) {

        // Storing google recaptcha response 
        // in $recaptcha variable 
        $recaptcha = $_POST['g-recaptcha-response'];
        // Put secret key here, which we get 
        // from google console 
        $secret_key = '6Lc-SospAAAAADdmDMBZi1y70kpnDKyy9Sdi7Sc6';
        // Hitting request to the URL, Google will 
        // respond with success or error scenario 
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
            . $secret_key . '&response=' . $recaptcha;
        // Making request to verify captcha 
        $response = file_get_contents($url);
        // Response return by google is in 
        // JSON format, so we have to parse 
        // that json 
        $response = json_decode($response);

        // Checking, if response is true or not 
        if ($response->success == true) {
            echo '<script>alert("Google reCAPTACHA verified")</script>';
            //si no es un bot inicia sesion
        } else {
            echo '<script>alert("Error in Google reCAPTACHA")</script>';
            exit();
        }
    }

    // Continuar solo si no hay errores
    if (empty($errores)) {
        // Cifrar la contraseña una vez comprobada que existe
        $contraseñaCifrada = md5($contraseña);

        // Incluir el archivo de conexión a la base de datos
        include("conexion.php");

        // Preparar la consulta SQL
        $stmt = $conexion->prepare("
            SELECT id, nombre, apellido, email, nickname, password, admin
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
            if ($contraseñaCifrada === $fila['password']) {
                
                // Establecer las variables de sesión
                $_SESSION['id'] = $fila['id'];
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['apellido'] = $fila['apellido'];
                $_SESSION['admin'] = $fila['admin'];

                // Redirigir a inicio.php
                echo "Redirigiendo al inicio";
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
