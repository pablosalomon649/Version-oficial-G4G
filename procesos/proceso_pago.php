<?php
session_start();
include('../conexion.php');

$usuarioID = $_SESSION['UsuarioID'];
$direccion = $_SESSION['Direccion'];
$ciudad = $_SESSION['Ciudad'];
$CP = $_SESSION['CodigoPostal'];

// Paso 1: Obtener los productos del carrito del usuario
$sql_carrito = "SELECT c.ProductoID, c.Cantidad, p.Precio
                  FROM carritodecompras c
                  INNER JOIN productos p ON c.ProductoID = p.ProductoID
                  WHERE c.UsuarioID = $usuarioID";
$resultado_carrito = mysqli_query($conexion, $sql_carrito);

// Paso 2: Calcular el total del pedido y crear el pedido
$total = 0;
$productos = [];
while ($fila = mysqli_fetch_assoc($resultado_carrito)) {
    $productoID = $fila['ProductoID'];
    $cantidad = $fila['Cantidad'];
    $precio = $fila['Precio'];
    $total += $precio * $cantidad;
    $productos[] = ['ProductoID' => $productoID, 'Cantidad' => $cantidad, 'PrecioUnitario' => $precio];
}

// Crear el pedido en la tabla 'pedidos'
$estado_pedido = 'Pendiente';
$direccion_envio = $CP . " - " . $ciudad . " - " . $direccion;

$sql_pedido = "INSERT INTO pedidos (UsuarioID, Estado, Total, DireccionEnvio)
                 VALUES ('$usuarioID', '$estado_pedido', '$total', '$direccion_envio')";
if (mysqli_query($conexion, $sql_pedido)) {
    // Obtener el ID del nuevo pedido
    $pedidoID = mysqli_insert_id($conexion);

    // Paso 3: Insertar los detalles del pedido
    foreach ($productos as $producto) {
        $productoID = $producto['ProductoID'];
        $cantidad = $producto['Cantidad'];
        $precioUnitario = $producto['PrecioUnitario'];

        $sql_detalle = "INSERT INTO detallesdepedido (PedidoID, ProductoID, Cantidad, PrecioUnitario)
                          VALUES ($pedidoID, $productoID, $cantidad, $precioUnitario)";
        mysqli_query($conexion, $sql_detalle);
    }

    // Paso 4: Eliminar los productos del carrito
    $sql_eliminar_carrito = "DELETE FROM carritodecompras WHERE UsuarioID = $usuarioID";
    mysqli_query($conexion, $sql_eliminar_carrito);

    // echo "Pago exitoso. Pedido realizado con éxito.";
    header("Location: ../pantalla_exitosa.php");
} else {
    // echo "Error al realizar el pedido: " . mysqli_error($conexion);
    header("Location: ../pantalla_error.php");
}
// Cerrar la conexión
mysqli_close($conexion);
