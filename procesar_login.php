 <?php
session_start();
include "conexion.php";
header('Content-Type: application/json');
    // $correoError = "";
    // $contrasenaError = "";

    // Procesar login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Correo = trim($_POST["Correo"]);
        $Contrasena = trim($_POST["Contrasena"]);

        // Consultar el usuario en la base de datos usando su correo
        $sql = "SELECT * FROM usuarios WHERE Correo = '$Correo'";
        $resultado = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($resultado);

        // Comprobar si existen datos guardados con ese correo
        if (mysqli_num_rows($resultado) > 0) {
            // Comprobar contraseñas
            if (password_verify($Contrasena, $fila["Contrasena"])) {

                $_SESSION['UsuarioID'] = $fila['UsuarioID'];
                $_SESSION['Correo'] = $fila['Correo'];
                $_SESSION['Nombre'] = $fila['Nombre'];
                $_SESSION['Direccion'] = $fila['Direccion'];
                $_SESSION['Ciudad'] = $fila['Ciudad'];
                $_SESSION['CodigoPostal'] = $fila['CodigoPostal'];
                $_SESSION['Telefono'] = $fila['Telefono'];

                $nombreCompleto = $fila['Nombre'];
                $nombreArray = explode(' ', $nombreCompleto);
                $primerNombre = $nombreArray[0];
                $_SESSION['PrimerNombre'] = $primerNombre;

                echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso"]);
                exit();
            } else {
                // En caso de no coincidir contraseñas
                echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
            }
        } else {
            // En caso de no existir datos con ese correo
            echo json_encode(["status" => "error", "message" => "Usuario no registrado"]);
        }
    }

    // Cerrar conexion
    mysqli_close($conexion);
    ?>
