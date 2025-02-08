<?php
include_once('conexion.php');
// Verificar si la sesión está activa y si el correo es el correcto (para administradores, por ejemplo)
if (!isset($_SESSION['UsuarioID']) || $_SESSION['Correo'] !== 'max1@outlook.com') {
    header("Location: index.php");
    exit;
}

// Verificar si el ESTADO formulario fue enviado para actualizarlo
if (isset($_POST['PedidoID']) && isset($_POST['nuevo_estado'])) {
    $pedidoID = $_POST['PedidoID'];
    $nuevoEstado = $_POST['nuevo_estado'];

    // Actualizar el estado del pedido
    $sql = "UPDATE pedidos SET Estado = '$nuevoEstado' WHERE PedidoID = $pedidoID";

    if (mysqli_query($conexion, $sql)) {
        echo "<p style='color: green;'>Estado del pedido actualizado correctamente.</p>";
    } else {
        echo "<p style='color: red;'>Error al actualizar el estado del pedido: " . mysqli_error($conexion) . "</p>";
    }
}

// Consulta para obtener todos los pedidos con la información relacionada
$sql = "SELECT 
    p.PedidoID,
    p.FechaPedido,
    p.Estado AS EstadoPedido,
    p.Total AS TotalPedido,
    p.DireccionEnvio,
    u.Nombre AS NombreUsuario,
    u.Correo AS CorreoUsuario,
    GROUP_CONCAT(CONCAT(pr.Nombre, ' (Cantidad: ', dp.Cantidad, ', Precio: $', dp.PrecioUnitario, ')') ORDER BY dp.ProductoID SEPARATOR ', ') AS Productos
FROM 
    pedidos p
JOIN 
    usuarios u ON p.UsuarioID = u.UsuarioID
JOIN 
    detallesdepedido dp ON p.PedidoID = dp.PedidoID
JOIN 
    productos pr ON dp.ProductoID = pr.ProductoID
GROUP BY 
    p.PedidoID, p.FechaPedido, p.Estado, p.Total, p.DireccionEnvio, u.Nombre, u.Correo
ORDER BY 
    p.FechaPedido DESC;
";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $sql);

// Comprobar si se han encontrado pedidos
if (mysqli_num_rows($resultado) > 0) {
    // Mostrar los pedidos
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='order-card'>
            <div class='order-details'>
            <h3>Pedido ID: " . $fila['PedidoID'] . "</h3>
            <p><strong>Fecha de Pedido:</strong> " . $fila['FechaPedido'] . "</p>
            <p><strong>Usuario:</strong> " . $fila['NombreUsuario'] . "</p>
            <p><strong>Correo:</strong> " . $fila['CorreoUsuario'] . "</p>
            <p><strong>Dirección de Envío:</strong> " . $fila['DireccionEnvio'] . "</p>
            <p><strong>Total:</strong> $" . $fila['TotalPedido'] . "</p>
            <p><strong>Estado:</strong> " . $fila['EstadoPedido'] . "</p>";

        // Mostrar los productos en el pedido
        echo "<h4>Productos en este pedido:</h4>";
        echo "<ul>";
        $productos = explode(", ", $fila['Productos']); // Convertir el string de productos a un array
        foreach ($productos as $producto) {
            echo "<li>" . $producto . "</li>"; // Mostrar cada producto
        }
        echo "</ul> </div>";

        // Formulario para cambiar el estado del pedido
        echo "<div class='order-actions'>";
        echo "<form action='' method='POST'>
                <input type='hidden' name='PedidoID' value='" . $fila['PedidoID'] . "'>
                <select name='nuevo_estado' class='btn-processing'>
                    <option value='Entregado' " . ($fila['EstadoPedido'] == 'Entregado' ? 'selected' : '') . ">Entregado</option>
                    <option value='Enviado' " . ($fila['EstadoPedido'] == 'Enviado' ? 'selected' : '') . ">Enviado</option>
                    <option value='Pendiente' " . ($fila['EstadoPedido'] == 'Pendiente' ? 'selected' : '') . ">Pendiente</option>
                    <option value='Cancelado' " . ($fila['EstadoPedido'] == 'Cancelado' ? 'selected' : '') . ">Cancelado</option>
                </select>
                <button class='btn-add' type='submit'>Actualizar Estado</button>
            </form>";

        echo "</div>";
        echo "</div>";
        echo "<hr>";
    }
} else {
    echo "No se encontraron pedidos.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
