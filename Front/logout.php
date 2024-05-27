<?php
// Iniciar la sesión si no está iniciada
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Finalmente, destruir la sesión
session_destroy();

// Redireccionar al usuario a la página de inicio de sesión
header("Location: login.php");
exit();
?>
