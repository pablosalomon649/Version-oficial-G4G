<?php
session_start();
require 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['Correo'] != 'max1@outlook.com') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $soporteID = $_POST['soporteID'];
    $nuevoEstado = $_POST['estado'];

    $stmt = mysqli_prepare($conexion, "UPDATE soporte_tecnico SET Estado = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "si", $nuevoEstado, $soporteID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: seguimiento_detalle.php?id=$soporteID&success=1");
    } else {
        header("Location: seguimiento_detalle.php?id=$soporteID&error=1");
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
