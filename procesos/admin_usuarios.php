<?php
include_once('conexion.php');
// Verificación de sesión
if (!isset($_SESSION['UsuarioID']) || $_SESSION['Correo'] !== 'max1@outlook.com') {
    header("Location: index.php");
    exit;
}

// Eliminar usuario
if (isset($_POST['eliminar_usuario'])) {
    $usuarioID = $_POST['UsuarioID'];

    // Consulta para eliminar usuario
    $sql_eliminar = "DELETE FROM usuarios WHERE UsuarioID = $usuarioID";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql_eliminar)) {
        echo "<p style='color: red;'>Usuario eliminado correctamente.</p>";
    } else {
        echo "<p>Hubo un error al eliminar el usuario.</p>";
    }
}

// Consulta para obtener todos los usuarios registrados
$sql = "SELECT * FROM usuarios";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $sql);

// Comprobar si se han encontrado usuarios
if (mysqli_num_rows($resultado) > 0) {
    // Mostrar los usuarios registrados
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='user-card'>
                <p><strong>Usuario:</strong> " . $fila['Nombre'] . "</p>
                <p><strong>Correo:</strong> " . $fila['Correo'] . "</p>
                <p><strong>Edad:</strong> " . $fila['Edad'] . "</p>
                <p><strong>Dirección:</strong> " . $fila['Direccion'] . "<br>
                    " . $fila['Ciudad'] . "<br>
                    " . $fila['CodigoPostal'] . "
                </p>
                <div class='buttons'>
                    <form action='' method='POST'>
                        <input type='hidden' name='UsuarioID' value='" . $fila['UsuarioID'] . "'>
                        <button type='submit' name='eliminar_usuario' class='btn-delete'>Eliminar</button>
                    </form>
                </div>
            </div>";
    }
} else {
    echo "<p>No se encontraron usuarios registrados.</p>";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
