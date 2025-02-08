<?php

session_start();
// Incluir conexión
include_once "conexion.php";

if (isset($_SESSION["UsuarioID"])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="Css/registro_u.css">
</head>
<style>
    /* Modales */
    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        width: 90%;
        max-width: 500px;
    }

    .modal-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .modal-content input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .modal-footer {
        text-align: right;
    }

    .modal-footer button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
    }

    .modal-footer .save-btn {
        background-color: #4CAF50;
        color: white;
    }

    .modal-footer .close-btn {
        background-color: #f44336;
        color: white;
    }

    /* Fondo oscuro al abrir el modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .modal-active {
        display: block;
    }
</style>

<body>
<body>
    <div class="container">
        <!-- Sección Izquierda -->
        <div class="form-section">
            <h2>Registro</h2>
            <form id="form-registro">
                <label for="Nombre">Nombre</label>
                <input type="text" name="Nombre" placeholder="Nombre completo" required>

                <label for="Correo">Email</label>
                <input type="email" name="Correo" placeholder="Correo electrónico" required>

                <label for="Contrasena">Contraseña</label>
                <input type="password" name="Contrasena" placeholder="Introducir contraseña" required>

                <label for="Confirmar_Contrasena">Contraseña</label>
                <input type="password" name="Confirmar_Contrasena" placeholder="Confirmar contraseña" required>

                <label for="Edad">Edad</label>
                <input type="number" name="Edad" placeholder="Edad" required>

                <label for="Telefono">Número celular</label>
                <input type="text" name="Telefono" placeholder="Número" required>

                <button type="button" onclick="crearUsuario()">Registrar</button>
            </form>

            <!-- Botón de inicio de sesión -->
            <a href="login.php"><button class="login-button">Iniciar sesión</button></a>
        </div>
        
        <!-- Sección de Bienvenida (Derecha) -->
        <div class="welcome-section" id="welcome-section">
            <div>
                <img style="scale: 50%;" src="img_products/nintendoRegistro.png" alt="Nintendo">
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Mensaje</h5>
                </div>
                <div class="modal-body" id="modal-message">
                    <!-- El mensaje se mostrará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Agregar enlaces a jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function mostrarModal(mensaje) {
            // Insertar el mensaje en el cuerpo del modal
            const modalMessage = document.getElementById("modal-message");
            modalMessage.textContent = mensaje;

            // Mostrar el modal usando Bootstrap
            $('#responseModal').modal('show');
        }

        function crearUsuario() {
            const formulario = document.getElementById("form-registro");
            const formData = new FormData(formulario);
            // fetch enviará la peticion para procesar los datos con el método indicado y los datos seleccionados de la constante formData
            fetch('procesar_registro.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    mostrarModal(data.message);
                    formulario.reset();
                })
                .catch(error => {
                    mostrarModal("Ocurrió un error al intentar registrar al usuario. Intente de nuevo.");
                });
        }
    </script>
</body>

</html>