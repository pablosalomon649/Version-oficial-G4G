<?php
include "../conexion.php";

// Verificar si se recibió el ID del producto
if (isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    // Actualizar el producto en la base de datos
    $sql = "UPDATE productos 
    SET Nombre = '$nombre', Precio = '$precio', Descripcion = '$descripcion' 
    WHERE ProductoID = $producto_id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../anadir_inventario.php");
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($conexion);
    }
}
?>
