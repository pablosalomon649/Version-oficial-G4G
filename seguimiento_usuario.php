<?php
session_start();
require 'conexion.php';

$soporteID = $_GET['id'] ?? 0;
$query = "SELECT * FROM soporte_tecnico WHERE ID = $soporteID";
$result = mysqli_query($conexion, $query);
$soporte = mysqli_fetch_assoc($result);

$querySeguimiento = "SELECT * FROM seguimiento_soporte WHERE SoporteID = $soporteID ORDER BY FechaComentario ASC";
$resultSeguimiento = mysqli_query($conexion, $querySeguimiento);
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
    <style>
        /* Estilos para el estado de la solicitud */
        .estado-solicitud .badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
        }

        /* Estilos para la lista de conversación */
        .conversacion-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Estilos para cada tarjeta de comentario */
        .comentario-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            transition: box-shadow 0.3s ease;
        }

        .comentario-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilos para el encabezado del comentario */
        .comentario-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .comentario-header strong {
            font-size: 1rem;
            color: #333;
        }

        .comentario-header small {
            font-size: 0.85rem;
            color: #777;
        }

        /* Estilos para el cuerpo del comentario */
        .comentario-body p {
            margin: 0;
            color: #555;
            font-size: 0.95rem;
        }

        /* Estilos para el formulario de comentarios */
        form textarea {
            resize: none;
        }

        form .btn {
            font-size: 1rem;
            padding: 0.5rem 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación de escritorio -->
    <header>
        <div class="header-container">
            <h1 class="logo"><a href="index.php"> G4G<span>Shop</span> </a></h1>
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
                        echo "<a href='panel_admin.php' class='nav-link'><i class='fas fa-cogs'></i> Panel de administrador</a>";
                    }
                    echo "<a href='perfil.php'><i class='fas fa-user'></i> " . $_SESSION["PrimerNombre"] . "</a>";
                    echo "<a href='procesos/cerrar_sesion.php'><i class='fas fa-sign-out-alt'></i> Cerrar Sesión</a>";
                } else {
                    echo "<a href='registro.php'><i class='fas fa-user-plus'></i> Crear cuenta</a>";
                    echo "<a href='login.php'><i class='fas fa-sign-in-alt'></i> Ingresar</a>";
                }
                ?>
                <a href="carrito_compras.php"><i class="fas fa-shopping-cart"></i> Carrito</a>
                <a href="mis_pedidos.php"><i class="fas fa-history"></i> Historial</a>
            </nav>
        </div>
    </header>

    <!-- Barra de navegación móvil -->
    <nav class="nav-links-mobile">
        <?php
        if (isset($_SESSION["UsuarioID"])) {
            if ($_SESSION['Correo'] == 'max1@outlook.com') {
                echo "<a href='panel_admin.php' class='nav-item'>
                    <i class='fas fa-cogs'></i>
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

    <div class="container mt-4">
        <h2 class="mb-4">📌 Seguimiento</h2>
        <div class="estado-solicitud mb-4">
            <p><strong>Estado:</strong> 
                <span class="badge bg-<?php echo $soporte['Estado'] == 'pendiente' ? 'warning' : ($soporte['Estado'] == 'resuelto' ? 'success' : 'secondary'); ?>">
                    <?php echo ucfirst($soporte['Estado']); ?>
                </span>
            </p>
        </div>

        <h3 class="mb-4">📌 Conversación:</h3>
        <div class="conversacion-list">
            <?php while ($row = mysqli_fetch_assoc($resultSeguimiento)) { ?>
                <div class="comentario-card mb-3">
                    <div class="comentario-header">
                        <strong><?php echo ucfirst($row['Rol']); ?></strong>
                        <small class="text-muted"><?php echo $row['FechaComentario']; ?></small>
                    </div>
                    <div class="comentario-body">
                        <p><?php echo $row['Comentario']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <form method="post" action="guardar_seguimiento.php" class="mt-4">
            <input type="hidden" name="soporteID" value="<?php echo $soporteID; ?>">
            <textarea name="comentario" class="form-control mb-3" rows="4" required placeholder="Añadir comentario..."></textarea>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>
</html>

<?php mysqli_close($conexion); ?>