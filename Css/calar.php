<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="cssBoot/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Css/inicio_pri.css">
    <link rel="stylesheet" href="Css/categorias.css">
    <link rel="stylesheet" href="Css/carrusel.css.css">

</head>

<body>
    <!-- Barra de navegación de escritorio -->
    <header>
        <div class="header-container">
        <h1 class="logo">
   

        <nav style="display: flex; align-items: center; background-color: ##ffa500; height: 90px; padding: 0 20px;">
    <h1 class="logo" style="margin: 0; height: 100px; flex: 0 0 auto;">
        <a href="index.php" style="display: block; height: 100px;">
            <img src="img_products/g4g.png" alt="GameShop Logo" style="height: 90px; width: 120px; object-fit: contain;">
        </a>
    </h1>
</nav>


</h1>
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







   <!-- Categoras  de productos index-->
   <section class="categories" id="imagenesxd">
        <?php
        $categorias = [
            "Nintendo" => "img_products/nitendo.png",
            "PlayStation" => "img_products/logoplay.jpg",
            "Xbox" => "img_products/xbox_logo.jpg",
            "Accesorios" => "img_products/acce.jpg",
            "Videojuegos" => "img_products/videojuegos.jpg"
        ];
        $activeCategory = isset($_GET['search']) ? $_GET['search'] : '';
        foreach ($categorias as $categoria => $imagen) {
            $isActive = ($categoria === $activeCategory) ? "active" : "";
            echo "
            <div class='category'>
                <a href='index.php?search=$categoria' class='$isActive'>
                    <img src='$imagen' alt='$categoria'>
                    $categoria
                </a>
            </div>";
        }
        ?>
    </section>
    <!-- Productos -->
    <?php include "procesos/mostrar_productos.php"; ?>

    <p style="margin-top: 100px;"></p>




    
  <!-- Soporte Técnico (Engranaje) -->
  <div class="position-fixed bottom-0 end-0 m-3">
        <button class="btn btn-primary rounded-circle" style="width: 60px; height: 60px;" data-bs-toggle="modal" data-bs-target="#soporteModal">
            <i class="bi bi-gear-fill" style="font-size: 1.5rem;"></i>
        </button>
    </div>

    <!-- Modal de Soporte Técnico -->
    <div class="modal fade" id="soporteModal" tabindex="-1" aria-labelledby="soporteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="soporteModalLabel">Soporte Técnico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿En qué podemos ayudarte?</p>
                    <form>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="userEmail" placeholder="tuemail@ejemplo.com">
                        </div>
                        <div class="mb-3">
                            <label for="userMessage" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="userMessage" rows="3" placeholder="Describe tu problema..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>