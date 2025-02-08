<?php
session_start();
require 'conexion.php';

// Guardar una nueva solicitud de soporte
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $tipoConsulta = $_POST["tipoConsulta"];
    $mensaje = $_POST["mensaje"];

    $stmt = mysqli_prepare($conexion, "INSERT INTO soporte_tecnico (Correo, TipoConsulta, Mensaje) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $correo, $tipoConsulta, $mensaje);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION["Correo"] = $correo;
}

// Mostrar solicitudes del usuario
$correoUsuario = $_SESSION["Correo"] ?? "";
$query = "SELECT * FROM soporte_tecnico WHERE Correo = '$correoUsuario' ORDER BY FechaSolicitud DESC";
$result = mysqli_query($conexion, $query);
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
        /* Estilos para la lista de solicitudes */
        .solicitudes-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Estilos para cada tarjeta de solicitud */
        .solicitud-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            transition: box-shadow 0.3s ease;
        }

        .solicitud-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilos para el encabezado de la solicitud */
        .solicitud-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .solicitud-header strong {
            font-size: 1.1rem;
            color: #333;
        }

        .solicitud-header .badge {
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
        }

        /* Estilos para el cuerpo de la solicitud */
        .solicitud-body p {
            margin: 0;
            color: #555;
            font-size: 0.95rem;
        }

        /* Estilos para el pie de la solicitud */
        .solicitud-footer {
            margin-top: 0.5rem;
            text-align: right;
        }

        .solicitud-footer .btn {
            font-size: 0.9rem;
            padding: 0.25rem 0.75rem;
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
    <hr>
    <h3 class="mb-4">📌 Mis Solicitudes</h3>
    
    <!-- Mensaje adicional -->
    <div class="alert alert-info mb-4">
        <p>Aquí puedes ver el estado de las solicitudes que has enviado. Si tienes alguna duda o no encuentras una solicitud, no dudes en <a href="contacto.php" class="alert-link">contactarnos</a>.</p>
        <p class="mb-0">Recuerda que las solicitudes en estado <strong>pendiente</strong> están siendo revisadas, mientras que las <strong>resueltas</strong> ya han sido atendidas.</p>
    </div>

    <div class="solicitudes-list">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="solicitud-card">
                <div class="solicitud-header">
                    <strong><?php echo ucfirst($row['TipoConsulta']); ?></strong>
                    <span class="badge bg-<?php echo $row['Estado'] == 'pendiente' ? 'warning' : ($row['Estado'] == 'resuelto' ? 'success' : 'secondary'); ?>">
                        <?php echo ucfirst($row['Estado']); ?>
                    </span>
                </div>
                <div class="solicitud-body">
                    <p><?php echo $row['Mensaje']; ?></p>
                </div>
                <div class="solicitud-footer">
                    <a href="seguimiento_usuario.php?id=<?php echo $row['ID']; ?>" class="btn btn-sm btn-primary">Ver detalles</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>

<?php mysqli_close($conexion); ?>