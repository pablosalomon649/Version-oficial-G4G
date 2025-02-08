<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $soporteID = $_POST['soporteID'];
    $comentario = trim($_POST['comentario']);
    
    // Determinar el rol y el nombre a mostrar
    if (isset($_SESSION['UsuarioID']) && $_SESSION['Correo'] == 'max1@outlook.com') {
        $rol = 'admin'; // Debe coincidir con ENUM en la BD
        $nombre = $_SESSION["PrimerNombre"]; // Nombre real del admin
    } else {
        $rol = 'usuario'; // Debe coincidir con ENUM en la BD
        $nombre = $_SESSION["PrimerNombre"]; // Nombre real del usuario
    }

    // Consulta para guardar el comentario
    $stmt = mysqli_prepare($conexion, "INSERT INTO seguimiento_soporte (SoporteID, Comentario, Rol, NombreUsuario, FechaComentario) VALUES (?, ?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "isss", $soporteID, $comentario, $rol, $nombre);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: seguimiento_usuario.php?id=$soporteID");
        exit;
    } else {
        echo "Error al guardar el comentario.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
