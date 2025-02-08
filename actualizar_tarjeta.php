<?php
    session_start();
    include_once "conexion.php";
    header('Content-Type: application/json');

    if (!isset($_SESSION["UsuarioID"])) {
        header("Location: login.php");
        exit;
    }
    

    // Procesar registro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $UsuarioID = trim($_POST["UsuarioID"]);
        $NumeroTarjeta = trim($_POST["NumeroTarjeta"]);
        $NombreTitular = trim($_POST["NombreTitular"]);
        $FechaExpiracion = trim($_POST["FechaExpiracion"]);
        $CVV = trim($_POST["CVV"]);
        $TipoTarjeta = trim($_POST["TipoTarjeta"]);


        // Validamos que ninguna variable esté vacái
        $validaciones = [$NumeroTarjeta, $NombreTitular, $FechaExpiracion, $CVV, $TipoTarjeta];
        foreach ($validaciones as $validar) {
            if (empty($validar)) {
                echo json_encode(["status"=> "error","message"=> "Por favor llenar todos los campos."]);
                exit;
            }
        }

        // valida el número de la tarjeta
        if (!is_numeric($NumeroTarjeta) || strlen($NumeroTarjeta) < 13 || $NumeroTarjeta < 0) {
            echo json_encode(["status" => "error", "message" => "Ingrese una tarjeta válida."]);
            exit;
        }
        
        // "valida" el cvv
        if (!is_numeric($CVV) || strlen($CVV) < 3 || $CVV < 0) {
            echo json_encode(["status" => "error", "message" => "No pudimos validar la tarjeta, compruebe los datos."]);
            exit;
        }

        // Busca si el usuario ya tiene una tarjeta guardada 
        $sqlTarjetaSeleccion = "SELECT * FROM tarjetas WHERE UsuarioID = '$UsuarioID'";
        $resultado = mysqli_query($conexion, $sqlTarjetaSeleccion);
        // Si existe la actualizará
        if (mysqli_num_rows($resultado) > 0) {
            $sqlTarjeta = "UPDATE tarjetas 
            SET NumeroTarjeta = '$NumeroTarjeta', NombreTitular = '$NombreTitular', FechaExpiracion = '$FechaExpiracion', CVV = '$CVV', TipoTarjeta = '$TipoTarjeta' 
            WHERE UsuarioID = '$UsuarioID'";
            
        // Sino la insertará/registrará
        } else {
            $sqlTarjeta = "INSERT INTO tarjetas (UsuarioID, NumeroTarjeta, NombreTitular, FechaExpiracion, CVV, TipoTarjeta)
            VALUES ('$UsuarioID', '$NumeroTarjeta', '$NombreTitular', '$FechaExpiracion', '$CVV', '$TipoTarjeta')";
        }
        
        // Se ejecuta la consulta
        if (mysqli_query($conexion, $sqlTarjeta)) {
            echo json_encode(["status" => "success", "message" => "Tarjeta actualizada."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar tarjeta: "]);
        }        
    }

    // Cerrar conexion
    mysqli_close($conexion);
    ?>