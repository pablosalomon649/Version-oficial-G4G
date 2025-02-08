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
        <button class="button" onclick="location.href='anadir_inventario.php'">
            <span class="title">Inventario</span>
            <span class="description">Editar, Añadir Productos.</span>
        </button>

        <button class="button" onclick="location.href='editor_pedidos.php'">
            <span class="title">Revisar Pedidos</span>
            <span class="description">Administrar los pedidos, historial de pedidos.</span>
        </button>

        <button class="button" onclick="location.href='editor_usuario.php'">
            <span class="title">Usuarios</span>
            <span class="description">Ver y dar de baja usuarios registrados.</span>
        </button>

        <button class="button" onclick="location.href='admin_seguimiento.php'">
            <span class="title">Soporte Tecnico</span>
            <span class="description">Problemas tecnicos, compras y stock etc....</span>
        </button>



        <button type="button" onclick="location.href='procesos/cerrar_sesion.php'">Cerrar Sesion</button>

    </div>
    <p style="margin-top: 100px;"></p>
</body>

</html>