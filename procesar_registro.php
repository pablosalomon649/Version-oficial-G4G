 <?php
    include "conexion.php";
    header('Content-Type: application/json');

    // Procesar registro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Nombre = trim($_POST["Nombre"]);
        $Correo = filter_input(INPUT_POST, 'Correo', FILTER_VALIDATE_EMAIL);
        $Correo = trim($Correo);
        $Contrasena = trim($_POST["Contrasena"]);
        $Telefono = trim($_POST["Telefono"]);
        $Edad = trim($_POST["Edad"]);
        // $Direccion = trim($_POST["Direccion"]);
        $Confirmar_Contrasena = trim($_POST["Confirmar_Contrasena"]);

        // Validamos que ninguna variable esté vacái
        $validaciones = [$Nombre, $Correo, $Contrasena, $Telefono, $Edad, $Confirmar_Contrasena];
        foreach ($validaciones as $validar) {
            if (empty($validar)) {
                echo json_encode(["message" => "Por favor llenar todos los campos"]);
                exit;
            }
        }

        // Validar edad
        if (!is_numeric($Edad) || $Edad < 18) {
            echo json_encode(["message" => "Debes tener al menos 18 años de edad para registrarte."]);
            exit;
        }

        // Validar número de teléfono
        if (!is_numeric($Telefono) || strlen($Telefono) < 10) {
            echo json_encode(["message" => "Ingrese un número válido con al menos 10 dígitos."]);
            exit;
        }
        
        // Verificar si el correo ya está registrado
        $sql = "SELECT * FROM usuarios WHERE Correo = '$Correo'";
        $resultado = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            echo json_encode(["message" => "Correo ya registrado."]);
            exit;
        }

        // Validar contraseñas
        if ($Contrasena != $Confirmar_Contrasena) {
            echo json_encode(["message" => "Las contraseñas no coinciden."]);
            exit;
        }
        $Contrasena = password_hash($Contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (Nombre, Edad, Correo, Contrasena, Telefono)
        VALUES ('$Nombre', '$Edad', '$Correo', '$Contrasena', '$Telefono')";

        if (mysqli_query($conexion, $sql)) {
            echo json_encode(["message" => "Usuario registrado con éxito."]);
        } else {
            echo json_encode(["message" => "Error al guardar los datos: " . mysqli_error($conexion)]);
        }

    } else {
        header("Location: registro.php");
    }

    // Cerrar conexion
    mysqli_close($conexion);
    ?>