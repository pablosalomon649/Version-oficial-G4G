<?php
session_start();
include_once "conexion.php";
header('Content-Type: application/json');

if (!isset($_SESSION["UsuarioID"])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado un ID de producto
if (isset($_POST['ProductoID'])) {
    $UsuarioID = $_SESSION["UsuarioID"];
    $ProductoID = $_POST['ProductoID'];

    // Verificar si el producto ya está en el carrito
    $sql = "SELECT Cantidad FROM carritodecompras 
    WHERE UsuarioID = $UsuarioID 
    AND ProductoID = $ProductoID";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado->num_rows > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        if ($fila["Cantidad"] > 0) {
            echo json_encode(["status" => "error", "message" => "Producto ya en el carrito"]);
            exit();
        }
    } else {
        // Si el producto no está en el carrito, agregarlo
        $Cantidad = 1;
        $sql = "INSERT INTO carritodecompras (UsuarioID, ProductoID, Cantidad) 
        VALUES ('$UsuarioID', '$ProductoID', '$Cantidad')";

        if (mysqli_query($conexion, $sql)) {
            echo json_encode(["status" => "success", "message" => "Producto añadido."]);
        } else {
            echo "Error al guardar los datos: " . mysqli_error($conexion);
        }
    }
    exit();
}

mysqli_close($conexion);
