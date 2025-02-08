<?php
session_start();
include_once "conexion.php";
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
    <title>Inventario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="cssBoot/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Css/anadir_inventario.css">
</head>
<body>
<!-- Barra de navegación de escritorio -->
<header>
        <div class="header-container">
        <h1 class="logo"><a href="index.php"> Game<span>Shop</span> </a></h1>
        <form method="GET" action="index.php" class="search-form">
                <input type="text" name="search" placeholder="Buscar productos" class="search-bar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <!-- Botón para realizar la búsqueda -->
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>            <nav class="nav-links-desktop">
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

<!-- Sidebar -->
<div class="col-md-4">
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Agregar Productos al sistema</h5>
            <img src="img_products/logo.png" alt="Agregar producto" class="img-fluid mb-3" style="max-width: 120px;">
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addProductModal">Añadir</button>
        </div>
    </div>
</div>

    <?php
        include_once "procesos/mostrar_inventario.php";
    ?>
    <p style="margin-top: 100px;"></p>

<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="procesos/agregar_producto.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="productName" class="form-label">Producto</label>
                            <input type="text" class="form-control" id="productName" name="nombre" placeholder="Nombre del producto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="productPrice" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="productPrice" name="precio" placeholder="Precio" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="productCategory" class="form-label">Categoría</label>
                            <select id="productCategory" class="form-select" name="categoria" required>
                                <option value="" selected>Seleccione</option>
                                <option value="CONSOLAS">Consolas</option>
                                <option value="ACCESORIOS">Accesorios</option>
                                <option value="VIDEOJUEGOS">Videojuegos</option>
                                <option value="CONTROLES">Controles</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="productImage" class="form-label">Imagen del producto</label>
                            <input type="file" class="form-control" id="productImage" name="imagenURL" required>
                        </div>
                        <div class="col-12">
                            <label for="productDescription" class="form-label">Descripción del producto</label>
                            <textarea class="form-control" id="productDescription" name="descripcion" rows="3" placeholder="Descripción" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning">Agregar producto</button>
            </div>
            </form>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
