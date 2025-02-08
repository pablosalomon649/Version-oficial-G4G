<?php
session_start();
include_once "conexion.php";

if (!isset($_SESSION["UsuarioID"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UsuarioID = $_POST['UsuarioID'];
    $Nombre = $_POST['Nombre'];
    $Telefono = $_POST['Telefono'];
    $ContrasenaActual = $_POST['ContrasenaActual'];
    $ContrasenaNueva = $_POST['ContrasenaNueva'];
    $ConfContrasenaNueva = $_POST['ConfContrasenaNueva'];

    $actualizado = false;
    $actualizaciones = [
        'Nombre' => $Nombre,
        'Telefono' => $Telefono,
        'Contrasena' => $ContrasenaNueva
    ];

    foreach ($actualizaciones as $campo => $valor) {
        if (!empty($valor)) {
            if ($campo == 'Contrasena') {
                $sqlActualizarContrasena = "SELECT * FROM usuarios WHERE UsuarioID = '$UsuarioID'";
                $resultado = mysqli_query($conexion, $sqlActualizarContrasena);
                $fila = mysqli_fetch_assoc($resultado);

                // Verificar la contraseña actual
                if ($fila["Contrasena"] == $ContrasenaActual) {
                    if ($ContrasenaNueva == $ConfContrasenaNueva) {
                        // Si la nueva contraseña coincide con la confirmación
                        $ContrasenaNueva = password_hash($ContrasenaNueva, PASSWORD_DEFAULT);
                        $sqlActualizarContrasena = "UPDATE usuarios SET Contrasena = '$ContrasenaNueva' WHERE UsuarioID = '$UsuarioID'";
                        if (mysqli_query($conexion, $sqlActualizarContrasena)) {
                            $actualizado = true;
                        } else {
                            echo json_encode(["message" => "Error al actualizar la contraseña."]);
                            exit;
                        }
                    } else {
                        echo json_encode(["message" => "Las contraseñas no coinciden."]);
                        exit;
                    }
                } else {
                    echo json_encode(["message" => "Contraseña actual incorrecta."]);
                    exit;
                }
            } else {
                // Actualizar nombre o teléfono
                $sqlActualizar = "UPDATE usuarios SET $campo = '$valor' WHERE UsuarioID = '$UsuarioID'";
                if (mysqli_query($conexion, $sqlActualizar)) {
                    $actualizado = true;
                }
            }
        }
    }

    if ($actualizado) {
        echo json_encode(["message" => "Datos guardados correctamente"]);
    } else {
        echo json_encode(["message" => "No se realizaron cambios."]);
    }
}

mysqli_close($conexion);
?>
