<?php

const DBSERVER = "localhost";
const DBUSER = "Nicolas";
const DBPSW = "nico123";
const DBNAME = "timespace";

$conexion = new mysqli(DBSERVER, DBUSER, DBPSW, DBNAME);

// Verifico conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

//$conexion = new mysqli(DBSERVER, DBUSER, DBPSW,DBNAME);

//if ($conexion->connect_error) {
//    die("Conexión fallida: " . $conexion->connect_error);
//}

//$conexion->close();
