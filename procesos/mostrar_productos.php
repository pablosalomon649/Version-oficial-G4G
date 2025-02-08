<?php
include "conexion.php";

// Capturamos el término de búsqueda si existe
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Si hay un término de búsqueda, usamos LIKE en la consulta
if ($search) {
    // Consulta SQL con LIKE para buscar productos por nombre o descripción
    $sql = "SELECT * FROM productos WHERE Nombre LIKE ? OR Categoria LIKE ? " ;
    $stmt = mysqli_prepare($conexion, $sql);
    
    // Preparar el término de búsqueda con comodines %
    $searchTerm = "%" . $search . "%";
    
    // Vinculamos los parámetros y ejecutamos la consulta
    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    // Si no hay búsqueda, mostramos todos los productos
    $sql = "SELECT * FROM productos";
    $resultado = mysqli_query($conexion, $sql);
}

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {

    // Mostrar productos
    echo "<section class='products'>"; // Inicia la sección de productos
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='product'>"; // Inicia cada producto
        echo "<a href='ver_detalles.php?id=" . $fila["ProductoID"] . "'>"; // Iniciar botón para ver más detalles ---
        echo "<img src='" . $fila["ImagenURL"] . "' alt='" . $fila["Nombre"] . "'>"; // Muestra la imagen del producto
        echo "<p>" . $fila["Nombre"] . "</p>"; // Nombre y descripción
        echo "<span class='price'>$" . $fila["Precio"] . "</span>"; // Precio
        echo "</a>"; // Cierra botón para ver más detalles ---
        echo "</div>";
    }
    echo "</section>"; // Cierra la sección de productos
} else {
    echo "No se encontraron productos.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>