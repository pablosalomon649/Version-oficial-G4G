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
    <title>GameShop Login</title>
    <link rel="stylesheet" href="Css/registro.css">
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
    <div class="container">
        <!-- Sección de Inicio de Sesión (Izquierda) -->
        <div class="login-section">
            <h2>Bienvenido</h2>
            <form id="login-form">
                <label for="Correo">Email</label>
                <input type="email" id="email" name="Correo" placeholder="Correo electrónico">
                <!-- <p id="correo_login" style="color: red;"> <?php echo $correoError; ?> </p> -->

                <label for="Contrasena">Contraseña</label>
                <input type="password" id="password" name="Contrasena" placeholder="Introducir contraseña">
                <!-- <p id="contrasena_login" style="color: red;"> <?php echo $contrasenaError; ?> </p> -->

                <button type="button" onclick="iniciarSesion()">Iniciar</button>

            </form>
            <a href="">Recuperar contraseña</a>
        </div>

        <!-- Sección de Bienvenida (Derecha) -->
        <div class="welcome-section">
            <h1>Bienvenido</h1>
            <h2>GameShop</h2>
            <a href="registro.php"><button class="register-button">Regístrate</button></a>

            <!-- Imagen del tubo verde -->
            <div class="pipe-icon">
                <img src="img_products/logo.png" alt="Tubo verde">
            </div>
        </div>
    </div>

    <!-- modal De Respuesta -->
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.location.reload();">Cerrar</button>
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


        function iniciarSesion() {
            const formulario = document.getElementById("login-form");
            const formData = new FormData(formulario);

            fetch('procesar_login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarModal(data.message);
                        window.location.href = 'index.php';
                    } else {
                        mostrarModal(data.message);
                    }
                    formulario.reset();
                })
                .catch(error => {
                    mostrarModal("Ocurrió un error al intentar registrar al usuario. Intente de nuevo.");
                });
        }
    </script>
</body>

</html>