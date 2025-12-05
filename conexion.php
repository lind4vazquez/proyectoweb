<?php
$host = "localhost";
$user = "root";
$pass = "061105";
$dbname = "tiendapc";
$conexion = new mysqli($host, $user, $pass, $dbname);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>