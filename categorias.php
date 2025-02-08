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
    <link rel="stylesheet" href="Css/categorias.css">

    <style>
        /* Reset some basic styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        /* Header styling */
        header {
            background-color: #FFA500;
            padding: 10px 20px;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 24px;
            color: #333;
        }

        .logo span {
            color: white;
        }

        .search-bar {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Barra de navegación de escritorio */
        .nav-links-desktop {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px 0;
            background-color: #FFA500;
        }

        .nav-links-desktop a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .nav-links-desktop a:hover {
            text-decoration: underline;
        }

        /* Barra de navegación móvil */
        .nav-links-mobile {
            display: none;
        }

        /* Mobile-specific adjustments */
        @media (max-width: 780px) {
            .header-container {
                flex-direction: column;
                gap: 10px;
            }

            .nav-links-desktop {
                display: none;
            }

            .nav-links-mobile {
                display: flex;
                justify-content: space-around;
                align-items: center;
                background-color: #FFA500;
                padding: 10px 0;
                position: fixed;
                bottom: 0;
                width: 100%;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            }

            .nav-links-mobile .nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                color: white;
                text-decoration: none;
                font-size: 12px;
            }

            .nav-links-mobile .nav-item i {
                font-size: 20px;
                margin-bottom: 5px;
            }

            .nav-links-mobile .nav-item:hover {
                color: #fff5e6;
            }
        }

        /* Categorías */
        .categories {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px 0;
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }

        .category {
            flex: 1 0 calc(50% - 20px);
            max-width: 150px;
            text-align: center;
        }

        .category img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }

        @media (max-width: 780px) {
            #imagenesxd {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                padding: 10px;
            }

            .category {
                flex: 1 0 45%;
                max-width: 120px;
            }
        }

        /* General styles */
        .search-form {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .search-bar {
            padding: 8px;
            margin-right: 10px;
            width: 100%;
            max-width: 300px;
        }

        .search-button {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
        }

        .search-button i {
            margin-right: 5px;
        }

        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <h1 class="logo">Game<span>Shop</span></h1>
            <form method="GET" action="index.php" class="search-form">
                <input type="text" name="search" placeholder="Buscar productos" class="search-bar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
    </header>

    <!-- Categorías -->
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
       
    </nav>
    <p style="margin-top: 100px;"></p>

</body>
</html>
