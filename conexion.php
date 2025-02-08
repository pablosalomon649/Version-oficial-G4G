<?php 
$host = "localhost";
$dbnombre = "tienda";
$usuario = "root";
$contrasena = "";

$conexion = mysqli_connect($host, $usuario, $contrasena, $dbnombre);

if (!$conexion) {
    die("Fallo en la conexión: " . mysqli_connect_error());
}