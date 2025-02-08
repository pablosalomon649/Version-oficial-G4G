<?php
include_once "conexion.php";

if (isset($_SESSION["UsuarioID"])) {

    $UsuarioID = $_SESSION["UsuarioID"];
    // SELECCION DE DATOS DEL USUARIO
    $sql_usuario = "SELECT * FROM usuarios WHERE UsuarioID = '$UsuarioID'";
    $resultado_usuario = mysqli_query($conexion, $sql_usuario);

    if (mysqli_num_rows($resultado_usuario) > 0) {
        $fila_usuario = mysqli_fetch_array($resultado_usuario);

        $Nombre = $fila_usuario["Nombre"];
        $Correo = $fila_usuario["Correo"];
        $Direccion = $fila_usuario["Direccion"];
        $Ciudad = $fila_usuario["Ciudad"];
        $CodigoPostal = $fila_usuario["CodigoPostal"];
        $Telefono = $fila_usuario["Telefono"];
    }
    // SELECCION DE DATOS DE LA TARJETA DEL USUARIO
    $sql_tarjeta = "SELECT * FROM tarjetas WHERE UsuarioID = '$UsuarioID'";
    $resultado_tarjeta = mysqli_query($conexion, $sql_tarjeta);

    if (mysqli_num_rows($resultado_tarjeta) > 0) {
        $fila_tarjeta = mysqli_fetch_array($resultado_tarjeta);

        $NumeroTarjeta = $fila_tarjeta["NumeroTarjeta"];
        $NombreTitular = $fila_tarjeta["NombreTitular"];
        $FechaExpiracion = $fila_tarjeta["FechaExpiracion"];
        $TipoTarjeta = $fila_tarjeta["TipoTarjeta"];
        $CVV = $fila_tarjeta["CVV"];

    } else {
        $NumeroTarjeta = "";
        $NombreTitular = "";
        $FechaExpiracion = "";
        $TipoTarjeta = "";
        $CVV = "";
    }
}

mysqli_close($conexion);
?>