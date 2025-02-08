<?php
include "../conexion.php";

// Verificar si se recibió el ID del producto
if (isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Eliminar el producto de la base de datos
    $sql = "DELETE FROM productos WHERE ProductoID = $producto_id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../anadir_inventario.php");
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($conexion);
    }
}
?>
