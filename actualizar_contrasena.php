<?php
session_start();
include_once "conexion.php";
header('Content-Type: application/json');

if (!isset($_SESSION["UsuarioID"])) {
    header("Location: index.php");
    exit;
}

$actualizado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UsuarioID = trim($_POST['UsuarioID']);
    $ContrasenaActual = trim($_POST['ContrasenaActual']);
    $ContrasenaNueva = trim($_POST['ContrasenaNueva']);
    $ConfContrasenaNueva = trim($_POST['ConfContrasenaNueva']);


    // ACTUALIZAR CONTRASENA-----------------
    if (!empty($ContrasenaActual) && !empty($ContrasenaNueva) && !empty($ConfContrasenaNueva)) {

        $sqlActualizarContrasena = "SELECT * FROM usuarios WHERE UsuarioID = '$UsuarioID'";
        $resultado = mysqli_query($conexion, $sqlActualizarContrasena);
        $fila = mysqli_fetch_assoc($resultado);

        if (password_verify($ContrasenaActual, $fila["Contrasena"])) {

            if ($ContrasenaNueva == $ConfContrasenaNueva) {

                $ContrasenaNueva = password_hash($ContrasenaNueva, PASSWORD_DEFAULT);
                // Actualizar contraseña en la base de datos
                $sqlActualizarContrasena = "UPDATE usuarios SET Contrasena = '$ContrasenaNueva' WHERE UsuarioID = '$UsuarioID'";
                if (mysqli_query($conexion, $sqlActualizarContrasena)) {
                    echo json_encode(["message" => "Contraseña actualizada"]);
                    $actualizado = true;
                } else {
                    echo json_encode(["message" => "Error al actualizar la contraseña."]);
                }
            } else {
                echo json_encode(["message" => "Las contraseñas deben coincidir."]);
                // $contrasenaNuevaError = "Las contraseñas deben coincidir.";
            }
        } else {
            echo json_encode(["message" => "Contrasena actual incorrecta."]);
            // $contrasenaActualError = "Contrasena actual incorrecta.";
        }
    }
    // FIN DE ACTUALIZAR CONTRASENA----------

    if ($actualizado) {
        echo json_encode(["message" => "Datos guardados correctamente"]);
    } else {
        echo json_encode(["message" => "No se realizaron cambios."]);
    }
}

mysqli_close($conexion);
?>