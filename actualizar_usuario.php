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
    $Nombre = trim($_POST['Nombre']);
    $Telefono = trim($_POST['Telefono']);

    // ACTUALIZAR NOMBRE
    if (!empty($Nombre)) {
        $sqlActualizarNombre = "UPDATE usuarios SET Nombre = '$Nombre' WHERE UsuarioID = '$UsuarioID'";
        if (mysqli_query($conexion, $sqlActualizarNombre)) {
            // echo json_encode(["statusNombre"=> "success", "messageNombre" => "Nombre actualizado"]);
            $actualizado = true;
        }
    }

    // ACTUALIZAR TELÉFONO
    if (!empty($Telefono)) {
        if (is_numeric($Telefono) && strlen($Telefono) >= 10) {
            $sqlActualizarTelefono = "UPDATE usuarios SET Telefono = '$Telefono' WHERE UsuarioID = '$UsuarioID'";
            if (mysqli_query($conexion, $sqlActualizarTelefono)) {
                // echo json_encode(["statusTelefono"=> "success", "messageTelefono" => "Teléfono actualizado"]);
                $actualizado = true;
            }
        } else {
            echo json_encode(["statusTelefono"=> "error", "messageTelefono" => "Teléfono inválido"]);
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