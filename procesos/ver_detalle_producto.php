<?php
include "conexion.php";

// Verificar si se ha pasado un ID en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar el producto por el ID
    $sql = "SELECT * FROM productos WHERE ProductoID = '$id'";
    $resultado = mysqli_query($conexion, $sql);

    // Verificar si se encontró el producto
    if (mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);

        $ProductoID = $producto["ProductoID"];
        $Nombre = $producto["Nombre"];
        $ImagenURL = $producto["ImagenURL"];
        $Descripcion = $producto["Descripcion"];
        $Precio = $producto["Precio"];
        $Stock = $producto["Stock"];
        $Categoria = $producto["Categoria"];

    } else {
        echo "Producto no encontrado.";
    }
} else {
    header("Location: index.php");
}

?>