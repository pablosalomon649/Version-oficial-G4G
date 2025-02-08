<?php
include_once('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['UsuarioID'])) {
    header("Location: login.php");
    exit;
}

$usuarioID = $_SESSION['UsuarioID'];

// Consulta SQL para obtener los pedidos del usuario
$sql_pedidos = "SELECT 
        p.PedidoID,
        p.Estado,
        p.Total,
        p.DireccionEnvio,
        p.FechaPedido
    FROM 
        pedidos p
    WHERE 
        p.UsuarioID = $usuarioID
    ORDER BY 
        p.FechaPedido DESC
";

$resultado_pedidos = mysqli_query($conexion, $sql_pedidos);

// Comprobar si se han encontrado pedidos
if (mysqli_num_rows($resultado_pedidos) > 0) {

    // Mostrar los pedidos del usuario
    while ($pedido = mysqli_fetch_assoc($resultado_pedidos)) {
        echo "<div class='cart-item'>
            <div class='item-details'>
            <h2>Pedido #" . $pedido['PedidoID'] . "</h2>
            <p>Estado: " . $pedido['Estado'] . "</p>
            <p>Total: $" . $pedido['Total'] . "</p>
            <p>Dirección de envío: " . $pedido['DireccionEnvio'] . "</p>
            <p>Fecha: " . $pedido['FechaPedido'] . "</p>
            </div>";

        // Consulta SQL para obtener los productos del pedido
        $sql_detalles = "SELECT 
                dp.ProductoID,
                p.Nombre AS Producto,
                dp.Cantidad,
                p.Precio AS Precio,
                p.ImagenURL
            FROM 
                detallesdepedido dp
            JOIN 
                productos p ON dp.ProductoID = p.ProductoID
            WHERE 
                dp.PedidoID = " . $pedido['PedidoID'] . "
        ";

        $resultado_detalles = mysqli_query($conexion, $sql_detalles);

        // Comprobar si se han encontrado productos en el pedido
        if (mysqli_num_rows($resultado_detalles) > 0) {
            echo "<div class='productos-del-pedido'>";
            while ($detalle = mysqli_fetch_assoc($resultado_detalles)) {
                echo "<div class='cart-item'>
                        <img src='" . $detalle['ImagenURL'] . "' alt='" . $detalle['Producto'] . "'>
                        <div class='item-details'>
                            <h3>" . $detalle['Producto'] . "</h3>
                            <p>Precio: $" . $detalle['Precio'] . "</p>
                        </div>
                    </div>";
            }
            echo "</div>";
        } else {
            echo "<p>No hay productos en este pedido.</p>";
        }

        echo "</div>";
    }

} else {
    echo "<p>No tienes pedidos realizados.</p>";
}

mysqli_close($conexion);
?>
