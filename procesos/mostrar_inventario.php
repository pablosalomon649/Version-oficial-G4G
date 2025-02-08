<?php

include "conexion.php";

// Consultar productos en base de datos
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {

    // Mostrar resultados
    echo "<div class='row mb-3'>";
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='col-md-8'>";  // Contenedor de cada producto

        // Artículo
        echo "<div class='d-flex align-items-center border rounded p-3 mb-3 bg-light'>";
        echo "<img src='" . $fila["ImagenURL"] . "' alt='" . $fila["Nombre"] . "' class='me-3' style='width: 80px; height: auto;'>"; // Imagen del producto
        echo "<div>"; // Detalles del producto
        echo "<h5>" . $fila["Nombre"] . "</h5>";
        echo "<p class='text-muted'>$" . number_format($fila["Precio"], 2) . "</p>";
        echo "</div>";

        // Botones de acción
        echo "<div class='ms-auto'>";
        // Botón Eliminar
        echo "<form action='procesos/eliminar_producto.php' method='POST' style='display:inline-block;'>";
        echo "<input type='hidden' name='producto_id' value='" . $fila["ProductoID"] . "'>";
        echo "<button type='submit' class='btn btn-danger btn-sm me-2'>Eliminar</button>";
        echo "</form>";

        // Botón Editar (Activando un modal)
        echo "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editarModal" . $fila["ProductoID"] . "'>Editar</button>";
        echo "</div>";
        echo "</div>";

        // Modal para editar producto
        echo "<div class='modal fade' id='editarModal" . $fila["ProductoID"] . "' tabindex='-1' aria-labelledby='editarModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='editarModalLabel'>Editar Producto</h5>";
        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        echo "<form action='procesos/editar_producto.php' method='POST'>";
        echo "<input type='hidden' name='producto_id' value='" . $fila["ProductoID"] . "'>";
        
        // Nombre del producto
        echo "<div class='mb-3'>";
        echo "<label for='nombre' class='form-label'>Nombre</label>";
        echo "<input type='text' class='form-control' id='nombre' name='nombre' value='" . $fila["Nombre"] . "' required>";
        echo "</div>";
        
        // Precio del producto
        echo "<div class='mb-3'>";
        echo "<label for='precio' class='form-label'>Precio</label>";
        echo "<input type='number' class='form-control' id='precio' name='precio' value='" . $fila["Precio"] . "' step='0.01' required>";
        echo "</div>";
        
        // Descripción del producto
        echo "<div class='mb-3'>";
        echo "<label for='descripcion' class='form-label'>Descripción</label>";
        echo "<textarea class='form-control' id='descripcion' name='descripcion' required>" . $fila["Descripcion"] . "</textarea>";
        echo "</div>";
        
        // Categoría del producto (select)
        echo "<div class='mb-3'>";
        echo "<label for='categoria' class='form-label'>Categoría</label>";
        echo "<select class='form-select' id='categoria' name='categoria' required>";
        $categorias = ['ACCESORIOS', 'CONTROLES', 'CONSOLAS', 'VIDEOJUEGOS'];
        foreach ($categorias as $categoria) {
            $selected = ($fila['Categoria'] == $categoria) ? 'selected' : '';
            echo "<option value='$categoria' $selected>$categoria</option>";
        }
        echo "</select>";
        echo "</div>";
        
        // Imagen URL del producto
        echo "<div class='mb-3'>";
        echo "<label for='imagenURL' class='form-label'>Imagen URL</label>";
        echo "<input type='text' class='form-control' id='imagenURL' name='imagenURL' value='" . $fila["ImagenURL"] . "' required>";
        echo "</div>";

        echo "<button type='submit' class='btn btn-primary'>Guardar Cambios</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        echo "</div>"; // Cierra col-md-8
    }
    echo "</div>"; // Cierra row
} else {
    echo "No hay productos en la base de datos.";
}
?>
