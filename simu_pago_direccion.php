<?php
session_start();
// Incluir conexión
include "conexion.php";
include "procesos/select_datos_usuario.php";

if (!isset($_SESSION["UsuarioID"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Game Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="Css/perfil.css">
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

        .modal-footer .save-btn,
        .modal-footer .close-btn {
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
</head>

<body>
    <!-- Barra de navegación de escritorio -->
    <header>
        <div class="header-container">
            <h1 class="logo"><a href="index.php"> Game<span>Shop</span> </a></h1>
            <!-- Formulario de búsqueda -->
            <form method="GET" action="index.php" class="search-form">
                <input type="text" name="search" placeholder="Buscar productos" class="search-bar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <!-- Botón para realizar la búsqueda -->
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
            <nav class="nav-links-desktop">
                <?php
                if (isset($_SESSION["UsuarioID"])) {
                    if ($_SESSION['Correo'] == 'max1@outlook.com') {
                        echo "<a href='panel_admin.php' class='nav-link'>Panel de administrador</a>";
                    }
                    echo "<a href='perfil.php'>" . $_SESSION["PrimerNombre"] . "</a>";
                    echo "<a href='procesos/cerrar_sesion.php'>Cerrar Sesión</a>";
                } else {
                    echo "<a href='registro.php'>Crear cuenta</a>";
                    echo "<a href='login.php'>Ingresar</a>";
                }
                ?>
                <a href="carrito_compras.php">Carrito</a>
                <a href="mis_pedidos.php">Historial</a>
            </nav>
        </div>
    </header>
    <!-- Barra de navegación móvil -->
    <nav class="nav-links-mobile">
        <?php
        if (isset($_SESSION["UsuarioID"])) {
            if ($_SESSION['Correo'] == 'max1@outlook.com') {
                echo "<a href='panel_admin.php'class='nav-item'>
                <i class=''></i>
                <span> ADMIN </span>
                </a>";
            }
            echo "
            <a href='perfil.php' class='nav-item'>
                <i class='fas fa-user'></i>
                <span>" . $_SESSION["PrimerNombre"] . "</span>
            </a>";
        } else {
            echo "
            <a href='registro.php' class='nav-item'>
                <i class='fas fa-user-plus'></i>
                <span>Crear</span>
            </a>
            <a href='login.php' class='nav-item'>
                <i class='fas fa-sign-in-alt'></i>
                <span>Ingresar</span>
            </a>";
        }
        ?>

        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
        </a>
        <a href="carrito_compras.php" class="nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Carrito</span>
        </a>
        <a href="categorias.php" class="nav-item">
            <i class="fas fa-bars"></i>
            <span>Categorías</span>
        </a>
    </nav>
    <!-- BODY -->
    <div class="profile-info">

        <button class="button" onclick="openModal('modal-direcciones')">
            <span class="title">Dirección</span>
            <span class="description">Direcciones</span>
        </button>

        <!-- Datos de la tarjeta en un formulario OCULTO -->
        <form id="form-validation" style="display: none;">
            <input type="hidden" id="Direccion" value="<?php echo $Direccion ?>" />
            <input type="hidden" id="Ciudad" value="<?php echo $Ciudad ?>" />
            <input type="hidden" id="CodigoPostal" value="<?php echo $CodigoPostal ?>" />
        </form>

        <p id="error-message" style="color: red; display: none; font-size: 14px;"></p>
        <button type="button" class="button-continuar" onclick="validarFormulario()">Completar el Pago</button>

    </div>

    <!-- Modales -->
    <div class="modal-overlay" id="modal-overlay"></div>

    <!-- Modal Direcciones -->
    <div class="modal" id="modal-direcciones">
        <div class="modal-header">Editar Dirección</div>
        <div class="modal-content">
            <form id="actualizar_direccion">
                <input type="hidden" value="<?php echo $UsuarioID ?>" name="UsuarioID" />
                <input type="text" placeholder="Calle y número" value="<?php echo $Direccion ?>" name="Direccion" />
                <input type="text" placeholder="Ciudad" value="<?php echo $Ciudad ?>" name="Ciudad" />
                <input type="text" placeholder="Código postal" value="<?php echo $CodigoPostal ?>" name="CodigoPostal" />
            </form>
        </div>
        <div class="modal-footer">
            <button class="close-btn" onclick="closeModal()">Cancelar</button>
            <button class="save-btn" onclick="actualizarDireccion()">Guardar </button>
        </div>
    </div>

    <div class="modal" id="modal-compra">
        <div class="modal-header">Compra Exitosa</div>
        <div class="modal-content">
            <p>¡Gracias por tu compra! Tu pedido ha sido procesado con éxito.</p>
            <div style="text-align: center;">
                <!-- Espacio para la imagen -->
                <img id="compra-imagen" src="img_products/logo.png" alt="Compra Exitosa" style="width: 100%; max-width: 300px; margin: 10px 0;">
            </div>
        </div>
        <div class="modal-footer">
            <button class="close-btn" onclick="cerrarModal()">Cerrar</button>
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
        function actualizarDireccion() {
            var datos = new FormData(document.getElementById("actualizar_direccion"));
            fetch('actualizar_direccion.php', {
                    method: 'POST',
                    body: datos
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        mostrarModal(data.message, 'success');
                    } else {
                        mostrarModal(data.message, 'error');
                    }
                })
                .catch(error => {
                    mostrarModal("Ocurrió un error al intentar registrar la dirección. Intente de nuevo.", 'error');
                });
        }

        // Función para mostrar el modal de compra
        function mostrarCompraModal() {
            document.getElementById('modal-compra').classList.add('modal-active');
            document.getElementById('modal-overlay').classList.add('modal-active');
        }

        // Reutilizar función para cerrar los modales
        function cerrarModal() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => modal.classList.remove('modal-active'));
            document.getElementById('modal-overlay').classList.remove('modal-active');
        }

        // Mostrar el mensaje del modal y aplicar el estilo según el status
        function mostrarModal(mensaje, tipo) {
            const modalMessage = document.getElementById("modal-message");
            modalMessage.textContent = mensaje;
            // Mostrar el modal usando Bootstrap
            $('#responseModal').modal('show');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('modal-active');
            document.getElementById('modal-overlay').classList.add('modal-active');
        }

        function closeModal() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => modal.classList.remove('modal-active'));
            document.getElementById('modal-overlay').classList.remove('modal-active');
        }

        function validarFormulario() {
            // Obtener los valores del formulario oculto
            var Direccion = document.getElementById("Direccion").value;
            var Ciudad = document.getElementById("Ciudad").value;
            var CodigoPostal = document.getElementById("CodigoPostal").value;

            // Obtener el párrafo para el mensaje de error
            var errorMessage = document.getElementById("error-message");

            // Comprobamos si algún campo está vacío
            if (!Direccion || !Ciudad || !CodigoPostal) {
                // Si algún campo está vacío, mostramos un mensaje de advertencia
                errorMessage.textContent = "Por favor, complete toda la información requerida antes de continuar.";
                errorMessage.style.display = "block"; // Hacemos visible el mensaje
            } else {
                // Si todo está completo, ocultamos el mensaje de error y redirigimos al proceso de pago
                errorMessage.style.display = "none";
                window.location.href = 'procesos/proceso_pago.php'; // O la URL que corresponda para el proceso de pago
            }
        }
    </script>

</body>

</html>