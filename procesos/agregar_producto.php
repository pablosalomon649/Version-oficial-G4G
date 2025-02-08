<?php
include "../conexion.php";

// Verificar si se recibieron los datos del formulario
if (isset($_POST['nombre'], $_POST['precio'], $_POST['categoria'], $_POST['descripcion'])) {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    // $imagenURL = $_POST['imagenURL'];
    
    // Se prepara la carga de imagenes, primero apuntamos la RUTA
    $RUTA = "img_bd/"; 
    // Luego de cada imagen ingresado en el input obtenemos su nombre de archivo
    $imagenURL = basename($_FILES["imagenURL"]["name"]);
    // Preparamos los archivos concatenando la ruta con el nombre de archivo y lo almacenamos en una variable
    $ImagenPreparada = $RUTA . $imagenURL;

    // Mover las imagenes a la carpeta de destino, el tmp name es la ubicacion temporal de la imagen en el server.
    if (move_uploaded_file($_FILES["imagenURL"]["tmp_name"], "../" . $ImagenPreparada)) {

    // Insertar el producto en la base de datos
    $sql = "INSERT INTO productos (Nombre, Precio, Categoria, ImagenURL, Descripcion) 
            VALUES ('$nombre', '$precio', '$categoria', '$ImagenPreparada', '$descripcion')";

    
    if (mysqli_query($conexion, $sql)) {
        // Redirigir a la página de productos después de agregar
        header("Location: ../anadir_inventario.php");
    } else {
        echo "Error al agregar el producto: " . mysqli_error($conexion);
    }
}
echo "Error al cargar la imagen.";
}
?>
