<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <link rel="stylesheet" href="login.css">

</head>

<body>
    <div id="contenedor">

        <div id="contenedorcentrado">
            <div id="login">
                <form id="loginform" action="validarlogin.php" method="post">

                    <label for="usuario">Usuario</label>
                    <input id="usuario" type="text" name="usuario" placeholder="Usuario" required>

                    <label for="password">Contraseña</label>
                    <input id="password" type="password" placeholder="Contraseña" name="password" required>
                    <div class="g-recaptcha" data-sitekey="6Lc-SospAAAAADzEJdxJfSQIALBbLcjx3ZYI3VdD"></div>
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