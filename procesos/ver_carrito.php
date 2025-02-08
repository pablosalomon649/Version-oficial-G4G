<?php
include_once('conexion.php');

if (!isset($_SESSION['UsuarioID'])) {
    header("Location: login.php");
    exit;
}

$usuarioID = $_SESSION['UsuarioID'];

// Comprobar si se ha recibido una solicitud para eliminar un producto
if (isset($_GET['eliminar']) && isset($_GET['productoID'])) {
    $productoID = $_GET['productoID'];
    $eliminarSQL = "DELETE FROM carritodecompras WHERE UsuarioID = $usuarioID AND ProductoID = $productoID";
    mysqli_query($conexion, $eliminarSQL);
    echo "<p style: color='red'> Producto eliminado del carrito.</p>";
    // header("Location: carrito_compras.php");
}

// Consulta SQL para obtener los productos del carrito
$sql = "SELECT 
        p.ProductoID,
        p.Nombre AS Producto,
        p.Descripcion,
        c.Cantidad,
        p.Precio AS PrecioUnitario,
        (c.Cantidad * p.Precio) AS Subtotal,
        p.ImagenURL
    FROM 
        carritodecompras c
    JOIN 
        productos p ON c.ProductoID = p.ProductoID
    WHERE 
        c.UsuarioID = $usuarioID
";

$resultado = mysqli_query($conexion, $sql);

// Comprobar si se han encontrado productos en el carrito
if (mysqli_num_rows($resultado) > 0) {

    // Mostrar los productos del carrito
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='cart-item'>
            <img src='" . $fila['ImagenURL'] . "' alt='" . $fila['Producto'] . "'>
            <div class='item-details'>
                <h3>" . $fila['Producto'] . "</h3>
                <p>$" . $fila['PrecioUnitario'] . "</p>
                <p>Cantidad: " . $fila['Cantidad'] . "</p>
                <p>Subtotal: $" . $fila['Subtotal'] . "</p>
                <form action='' method='GET'>
                    <input type='hidden' name='productoID' value='" . $fila['ProductoID'] . "'>
                    <button type='submit' name='eliminar' value='1'>Eliminar</button>
                </form>
            </div>
        </div>";
    }

    // Sumar el total del carrito
    $totalCarritoSQL = "
        SELECT SUM(c.Cantidad * p.Precio) AS TotalCarrito
        FROM carritodecompras c
        JOIN productos p ON c.ProductoID = p.ProductoID
        WHERE c.UsuarioID = $usuarioID
    ";

    $totalCarritoResultado = mysqli_query($conexion, $totalCarritoSQL);
    $totalCarrito = mysqli_fetch_assoc($totalCarritoResultado);

    echo "
    <div class='subtotal'>
    <p>Subtotal: <span>$" . $totalCarrito['TotalCarrito'] . " </span></p>
    <form action='simu_pago_tarjeta.php' method='POST'>
    <button type='submit'>Pagar</button>
    </form>
    </div>";

} else {
    echo "<p>No hay productos en tu carrito.</p>";
}

mysqli_close($conexion);
?>
