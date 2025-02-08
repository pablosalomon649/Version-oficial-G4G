<?php
session_start();
require 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['Correo'] != 'max1@outlook.com') {
    header("Location: index.php");
    exit;
}

$soporteID = $_GET['id'] ?? 0;
$query = "SELECT * FROM soporte_tecnico WHERE ID = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $soporteID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$soporte = mysqli_fetch_assoc($result);

$querySeguimiento = "SELECT * FROM seguimiento_soporte WHERE SoporteID = ? ORDER BY FechaComentario ASC";
$stmtSeguimiento = mysqli_prepare($conexion, $querySeguimiento);
mysqli_stmt_bind_param($stmtSeguimiento, "i", $soporteID);
mysqli_stmt_execute($stmtSeguimiento);
$resultSeguimiento = mysqli_stmt_get_result($stmtSeguimiento);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Shop - Panel Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="cssBoot/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Css/inicio_pri.css">
    <link rel="stylesheet" href="Css/categorias.css">
    <style>

.form-select {
    --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
    display: block;
    width: 30%;
    padding: .375rem 2.25rem .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: var(--bs-body-bg);
    background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

    </style>

</head>
<body>
    <!-- Barra de navegación -->
    <header>
        <div class="header-container">
            <h1 class="logo"><a href="index.php"> G4G<span>Shop</span> </a></h1>
            <form method="GET" action="index.php" class="search-form">
                <input type="text" name="search" placeholder="Buscar productos" class="search-bar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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
<body>
    <div class="container mt-4">
        <h2>Detalles de Soporte #<?php echo $soporte['ID']; ?></h2>
        <p><strong>Correo:</strong> <?php echo $soporte['Correo']; ?></p>
        <p><strong>Tipo de consulta:</strong> <?php echo ucfirst($soporte['TipoConsulta']); ?></p>
        <p><strong>Mensaje:</strong> <?php echo nl2br($soporte['Mensaje']); ?></p>
        <p><strong>Estado:</strong> 
            <span class="badge bg-<?php echo $soporte['Estado'] == 'pendiente' ? 'warning' : ($soporte['Estado'] == 'resuelto' ? 'success' : 'secondary'); ?>">
                <?php echo ucfirst($soporte['Estado']); ?>
            </span>
        </p>
        
        <form method="post" action="actualizar_estado.php" class="mb-4">
            <input type="hidden" name="soporteID" value="<?php echo $soporteID; ?>">
            <label for="estado">Actualizar Estado:</label>
            <select name="estado" class="form-select mb-2" required>
                <option value="pendiente" <?php if ($soporte['Estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                <option value="en proceso" <?php if ($soporte['Estado'] == 'en proceso') echo 'selected'; ?>>En proceso</option>
                <option value="resuelto" <?php if ($soporte['Estado'] == 'resuelto') echo 'selected'; ?>>Resuelto</option>
            </select>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>

        <h3>Conversación:</h3>
        <div class="list-group">
            <?php while ($row = mysqli_fetch_assoc($resultSeguimiento)) { ?>
                <div class="list-group-item">
                    <strong><?php echo ucfirst($row['Rol']); ?></strong>
                    <small class="text-muted float-end"> <?php echo $row['FechaComentario']; ?> </small>
                    <p><?php echo nl2br($row['Comentario']); ?></p>
                </div>
            <?php } ?>
        </div>
        
        <form method="post" action="guardar_seguimiento.php" class="mt-4">
            <input type="hidden" name="soporteID" value="<?php echo $soporteID; ?>">
            <textarea name="comentario" class="form-control mb-3" rows="4" required placeholder="Añadir respuesta..."></textarea>
            <button type="submit" class="btn btn-success">Responder</button>
        </form>
        <a href="admin_seguimiento.php" class="btn btn-secondary mt-3">Volver</a>
    </div>
</body>
</html>
<?php mysqli_close($conexion); ?>