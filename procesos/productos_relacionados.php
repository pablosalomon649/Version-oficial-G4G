<?php
include_once("conexion.php");

$sql_relacionados = "SELECT * FROM productos 
                    WHERE Categoria = '$Categoria' 
                    AND ProductoID != '$id'
                    LIMIT 4";
                    
$productos_relacionados_resultado = mysqli_query($conexion, $sql_relacionados);

if (mysqli_num_rows($productos_relacionados_resultado) > 0) {
    while ($producto_relacionado = mysqli_fetch_assoc($productos_relacionados_resultado)) {
        $nombre_relacionado = $producto_relacionado["Nombre"];
        $imagen_relacionada = $producto_relacionado["ImagenURL"];
        $precio_relacionado = $producto_relacionado["Precio"];
        $id_relacionado = $producto_relacionado["ProductoID"];
        echo "
                <div class='producto-relacionado'>
                <a href='ver_detalles.php?id=$id_relacionado'>
                    <img src='$imagen_relacionada' alt='$nombre_relacionado'>
                    <p>$nombre_relacionado</p>
                    <span class='precio'>$ $precio_relacionado</span>
                </a>
                </div>
                ";
    }
}

mysqli_close($conexion);

?>