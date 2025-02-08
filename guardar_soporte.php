<?php
session_start();

if (!isset($_SESSION["UsuarioID"])) {
    echo "error: no sesión";
    exit();
}

require 'conexion.php'; // Conexión a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $issueType = $_POST['issueType'] ?? '';
    $message = $_POST['message'] ?? '';
    $userID = $_SESSION["UsuarioID"];

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($issueType) || empty($message)) {
        echo "error: campos vacíos";
        exit();
    }

    // Validar que el tipo de consulta sea válido
    $validTypes = ['pedido', 'pago', 'envio', 'devolucion', 'otro'];
    if (!in_array($issueType, $validTypes)) {
        echo "error: Tipo de consulta inválido";
        exit();
    }

    // Preparar y ejecutar la consulta para insertar el ticket
    $stmt = mysqli_prepare($conexion, "INSERT INTO soporte_tecnico (UsuarioID, Correo, TipoConsulta, Mensaje, Estado, FechaSolicitud) VALUES (?, ?, ?, ?, 'pendiente', NOW())");
    if (!$stmt) {
        echo "error: " . mysqli_error($conexion);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "isss", $userID, $email, $issueType, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        $ticketID = mysqli_insert_id($conexion); // Obtener ID del ticket

        // Insertar en seguimiento
        $stmtSeguimiento = mysqli_prepare($conexion, "INSERT INTO seguimiento_soporte (SoporteID, Comentario, Rol, FechaComentario) VALUES (?, ?, 'usuario', NOW())");
        if ($stmtSeguimiento) {
            mysqli_stmt_bind_param($stmtSeguimiento, "is", $ticketID, $message);
            mysqli_stmt_execute($stmtSeguimiento);
            mysqli_stmt_close($stmtSeguimiento);
        }

        echo "success"; // Respuesta exitosa
    } else {
        echo "error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "error: no POST";
}

mysqli_close($conexion);
?>
