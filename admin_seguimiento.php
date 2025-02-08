<?php
session_start();
require 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['UsuarioID']) || $_SESSION['Correo'] != 'max1@outlook.com') {
    header("Location: index.php");
    exit;
}

// Obtener todas las solicitudes de soporte
$query = "SELECT * FROM soporte_tecnico ORDER BY FechaSolicitud DESC";
$result = mysqli_query($conexion, $query);
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
        body {
            background-color: #f4f6f9;
        }

        .panel-container {
            background: linear-gradient(135deg, #007bff, #0056b3);
            text-align: center;
            border-radius: 10px;
            padding: 20px;
            color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table th {
            text-align: center;
            background-color: #343a40;
            color: white;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .badge {
            font-size: 14px;
            padding: 6px 12px;
        }

        .btn-sm {
            font-size: 14px;
            padding: 5px 10px;
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

    <!-- Panel de soporte técnico -->
    <div class="container mt-4">
        <div class="panel-containe">
            <h2>📌 Panel de Soporte Técnico</h2>
            <div class="alert alert-info mb-4">

            Gestiona y da seguimiento a las solicitudes de soporte enviadas por los usuarios. Revisa cada caso, actualiza su estado y brinda
             una mejor experiencia de atención. 📞 Si un caso requiere asistencia urgente, no dudes en contactar directamente al usuario.
    </div>
        </div>

        <table class="table table-hover mt-3 shadow-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['ID']; ?></td>
                        <td><?php echo $row['Correo']; ?></td>
                        <td><?php echo ucfirst($row['TipoConsulta']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $row['Estado'] == 'pendiente' ? 'warning' : ($row['Estado'] == 'resuelto' ? 'success' : 'secondary'); ?>">
                                <?php echo ucfirst($row['Estado']); ?>
                            </span>
                        </td>
                        <td><?php echo $row['FechaSolicitud']; ?></td>
                        <td>
                            <a href="seguimiento_detalle.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php mysqli_close($conexion); ?>
