<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password_confirm = htmlspecialchars(trim($_POST['password_confirm']));
    $nickname = htmlspecialchars(trim($_POST['nickname']));

    // Validar campos vacíos
    if (empty($nombre)) {
        $errors['nombre'] = "El nombre es obligatorio.";
    }
    if (empty($apellido)) {
        $errors['apellido'] = "El apellido es obligatorio.";
    }
    if (empty($email)) {
        $errors['email'] = "El email es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "El formato del email es incorrecto.";
    }
    if (empty($password)) {
        $errors['password'] = "La contraseña es obligatoria.";
    }
    if (empty($password_confirm)) {
        $errors['password_confirm'] = "Debe confirmar la contraseña.";
    } elseif ($password !== $password_confirm) {
        $errors['password_confirm'] = "Las contraseñas no coinciden.";
    }
    if (empty($nickname)) {
        $errors['nickname'] = "El nickname es obligatorio.";
    }

    // Verificar si el email o el nickname ya existen

    include ("conexion.php");

    if (empty($errors)) {
        $sql = "SELECT id FROM usuario WHERE email = ? OR nickname = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $email, $nickname);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id);
            while ($stmt->fetch()) {
                if ($email == $email) {
                    $errors['email'] = "El email ya está en uso.";
                }
                if ($nickname == $nickname) {
                    $errors['nickname'] = "El nickname ya está en uso.";
                }
            }
        }
        $stmt->close();
    }

    if (empty($errors)) {
        // Hash de la contraseña
        $hashed_password = md5($password);

        // Insertar el nuevo usuario
        $sql = "INSERT INTO usuario (nombre, apellido, email, password, nickname) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $hashed_password, $nickname);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error: " . $conexion->error;
        }

        $stmt->close();
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body {
            color: #1b262c;
            background-color: #5f6769;
            text-align: center;
        }

        #contenedorcentrado {
            background-color: #719192;
            width: 300px;
            /* Ancho del formulario */
            margin: 0 auto;
            /* Centrar horizontalmente */
            padding: 20px;
            /* Espaciado interno */
            /* Color de fondo */
            border-radius: 10px;
            /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Sombra */
        }

        label {
            text-align: center;
            display: block;
            /* Mostrar etiquetas en una línea separada */
            margin-bottom: 5px;
            /* Espaciado inferior */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            /* Ancho completo */
            padding: 8px;
            /* Espaciado interno */
            margin-bottom: 10px;
            /* Espaciado inferior */
            border: 1px solid #ccc;
            /* Borde gris */
            border-radius: 5px;
            /* Bordes redondeados */
            box-sizing: border-box;
            /* Incluir padding y borde en el tamaño */
        }

        input[type="submit"] {
            font-family: 'Overpass', sans-serif;
            font-size: 110%;
            color: #1b262c;
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 3px 3px 3px 3px;
            -moz-border-radius: 3px 3px 3px 3px;
            -webkit-border-radius: 3px 3px 3px 3px;
            background-color: #dfcdc3;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #555;
            /* Cambio de color al pasar el mouse */
        }

        .error {
            color: red;
            /* Color del texto de error */
            font-size: 14px;
            /* Tamaño de fuente del texto de error */
        }
    </style>
</head>

<body>
    <h2>Registro de Usuario</h2>
    <form method="post" action="">
        <div id="contenedorcentrado">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"><br>
            <span class="error"><?= $errors['nombre'] ?? '' ?></span><br>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>"><br>
            <span class="error"><?= $errors['apellido'] ?? '' ?></span><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
            <span class="error"><?= $errors['email'] ?? '' ?></span><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"><br>

            <label for="password_confirm">Confirmar Contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm"><br>
            <span class="error"><?= $errors['password_confirm'] ?? '' ?></span><br>

            <label for="nickname">Nickname:</label>
            <input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($_POST['nickname'] ?? '') ?>"><br>
            <span class="error"><?= $errors['nickname'] ?? '' ?></span><br>

            <input type="submit" value="Registrar">

    </form>
</body>

</html>