<?php
session_start();
include_once "conexion.php";
header('Content-Type: application/json');

if (!isset($_SESSION["UsuarioID"])) {
    header("Location: index.php");
    exit;
}

$contrasenaActualError = "";
$contrasenaNuevaError = "";
$actualizado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UsuarioID = trim($_POST['UsuarioID']);
    $Nombre = trim($_POST['Nombre']);
    $Telefono = trim($_POST['Telefono']);
    $ContrasenaActual = trim($_POST['ContrasenaActual']);
    $ContrasenaNueva = trim($_POST['ContrasenaNueva']);
    $ConfContrasenaNueva = trim($_POST['ConfContrasenaNueva']);

    // ACTUALIZAR CONTRASEÑA
    if (!empty($ContrasenaActual) && !empty($ContrasenaNueva) && !empty($ConfContrasenaNueva)) {
        $sqlActualizarContrasena = "SELECT * FROM usuarios WHERE UsuarioID = '$UsuarioID'";
        $resultado = mysqli_query($conexion, $sqlActualizarContrasena);
        $fila = mysqli_fetch_assoc($resultado);

        if (password_verify($ContrasenaActual, $fila["Contrasena"])) {
            if ($ContrasenaNueva == $ConfContrasenaNueva) {
                $ContrasenaNueva = password_hash($ContrasenaNueva, PASSWORD_DEFAULT);
                // Intentar actualizar la contraseña
                $sqlActualizarContrasena = "UPDATE usuarios SET Contrasena = '$ContrasenaNueva' WHERE UsuarioID = '$UsuarioID'";
                if (mysqli_query($conexion, $sqlActualizarContrasena)) {
                    $actualizado = true;
                    $messageContrasena = "Contraseña actualizada correctamente.";
                } else {
                    $messageContrasena = "Error al actualizar la contraseña.";
                }
            } else {
                $messageContrasena = "Las contraseñas deben coincidir.";
            }
        } else {
            $messageContrasena = "Contraseña actual incorrecta.";
        }
    } else {
        $messageContrasena = "No se proporcionaron cambios en la contraseña.";
    }

    // ACTUALIZAR NOMBRE
    if (!empty($Nombre)) {
        $sqlActualizarNombre = "UPDATE usuarios SET Nombre = '$Nombre' WHERE UsuarioID = '$UsuarioID'";
        if (mysqli_query($conexion, $sqlActualizarNombre)) {
            $actualizado = true;
        }
    }

    // ACTUALIZAR TELÉFONO
    if (!empty($Telefono)) {
        if (is_numeric($Telefono) && strlen($Telefono) >= 10) {
            $sqlActualizarTelefono = "UPDATE usuarios SET Telefono = '$Telefono' WHERE UsuarioID = '$UsuarioID'";
            if (mysqli_query($conexion, $sqlActualizarTelefono)) {
                $actualizado = true;
            }
        } else {
            $messageTelefono = "Teléfono inválido.";
        }
    }

    // Generar la respuesta final
    if ($actualizado) {
        $response = ["message" => "Datos guardados correctamente"];
    } else {
        $response = ["message" => "No se realizaron cambios."];
    }

    // Si se presentó algún error con la contraseña o teléfono, agregar los mensajes de error
    if (isset($messageContrasena)) {
        $response["statusContrasena"] = "error";
        $response["messageContrasena"] = $messageContrasena;
    }

    if (isset($messageTelefono)) {
        $response["statusTelefono"] = "error";
        $response["messageTelefono"] = $messageTelefono;
    }

    echo json_encode($response);
    exit;
}

mysqli_close($conexion);
?>