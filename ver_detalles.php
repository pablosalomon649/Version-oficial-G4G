<?php

session_start();
include_once "procesos/ver_detalle_producto.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto - Game Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="Css/produc.css">
</head>
<style>
    .detalle-producto img {
        width: 30%;
        height: auto;
    }

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

    <main class="contenido-producto">
        <section class="detalle-producto">
            <img src=" <?php echo $ImagenURL ?> " class="imagen-producto">

            <div class="info-producto">
                <h2> <?php echo $Nombre ?> </h2>
                <p class="plataforma"> <?php echo $Categoria ?> </p>
                <p class="precio"> <?php echo $Precio ?> </p>
                
                <form id="botones">

                    <input type="hidden" name="ProductoID" value="<?php echo $ProductoID; ?>">
                    <button type="button" class="boton-carrito" onclick="agregarAlCarrito()">Agregar al carrito</button>

                </form>

                <div class="descripcion-producto">
                    <h3>Acerca de este artículo</h3>
                    <ul>
                        <p> <?php echo $Descripcion ?> </p>
                    </ul>
                </div>
            </div>
        </section>

        <section class="productos-relacionados">
            <h3>Productos relacionados</h3>
            <div class="productos-grid">
                <?php
                include_once "procesos/productos_relacionados.php"
                ?>
            </div>
        </section>
    </main>

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
                    <button type="button" class="close-btn" data-dismiss="modal" onclick="document.location.reload();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function agregarAlCarrito() {
            var datos = new FormData(document.getElementById("botones"));
            fetch('agregar_al_carrito.php', {
                    method: 'POST',
                    body: datos
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log("Esto es una prueba");
                        mostrarModal(data.message, 'success');
                    } else {
                        mostrarModal(data.message, 'error');
                    }
                })
                .catch(error => {
                    mostrarModal("Ocurrió un error al intentar agregar  al carrito", 'error');
                });
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
    </script>
<!-- Agregar enlaces a jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>