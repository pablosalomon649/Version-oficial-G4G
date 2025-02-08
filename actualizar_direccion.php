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
        $Direccion = trim($_POST["Direccion"]);
        $Ciudad = trim($_POST["Ciudad"]);
        $CodigoPostal = trim($_POST["CodigoPostal"]);

        // Validamos que ninguna variable esté vacái
        $validaciones = [$Direccion, $Ciudad, $CodigoPostal];
        foreach ($validaciones as $validar) {
            if (empty($validar)) {
                echo json_encode(["status"=> "error","message"=> "No deje campos vacios"]);
                exit;
            }
        }

        if (!is_numeric($CodigoPostal) || strlen($CodigoPostal) < 5) {
            echo json_encode(["status" => "error", "message" => "Ingrese un código postal válido"]);
            exit;
        }        

        $sqlDireccion = "UPDATE usuarios 
        SET Direccion = '$Direccion', Ciudad = '$Ciudad', CodigoPostal = '$CodigoPostal' 
        WHERE UsuarioID = '$UsuarioID'";
        
        if(mysqli_query($conexion, $sqlDireccion)) {
            echo json_encode(["status"=> "success","message"=> "Dirección actualizada"]);
        } else {
            echo json_encode(["status"=> "error","message"=> "Error al actualizar dirección"]);
        }

    }

    // Cerrar conexion
    mysqli_close($conexion);
    ?>