<?php
// Iniciar la sesión
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
<body>

<div class="container mt-5">
    <h1>Contacto</h1>
    <p>Si tienes alguna duda o necesitas ayuda, no dudes en contactarnos.</p>

    <!-- Formulario de Soporte Técnico -->
    <div class="card shadow-lg p-4">
        <h2 class="mb-4" style="color: #5955DD;"><i class="fas fa-headset"></i> Soporte Técnico</h2>
        <p>Cuéntanos tu problema, ¡estamos aquí para ayudarte!</p>
        <form id="supportForm">
            <div class="mb-3">
                <label for="userEmail" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="userEmail" value="<?php echo isset($_SESSION['Correo']) ? $_SESSION['Correo'] : ''; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="issueType" class="form-label">Tipo de Consulta</label>
                <select class="form-select" id="issueType" required>
                    <option value="">Selecciona una opción...</option>
                    <option value="pedido">Problema con mi pedido</option>
                    <option value="pago">Dudas sobre pagos</option>
                    <option value="envio">Estado del envío</option>
                    <option value="devolucion">Devoluciones y reembolsos</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="userMessage" class="form-label">Mensaje</label>
                <textarea class="form-control" id="userMessage" rows="4" placeholder="Describe tu problema..." required></textarea>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #5955DD;">Enviar</button>
        </form>
    </div>
</div>

<!-- Modal de Cargando / Procesando -->
<div class="modal fade" id="processingModal" tabindex="-1" aria-labelledby="processingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="processingModalLabel">Procesando...</h5>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-3">Estamos procesando tu solicitud. Por favor espera.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">¡Solicitud Enviada!</h5>
            </div>
            <div class="modal-body text-center">
                <p>Tu solicitud ha sido enviada con éxito. Nos pondremos en contacto pronto.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: #5955DD;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Error -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">¡Error!</h5>
            </div>
            <div class="modal-body text-center">
                <p>Hubo un error al intentar enviar tu mensaje. Por favor, inténtalo nuevamente.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" style="background-color: #5955DD;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Estilos específicos para mejorar la visualización en móviles -->
<style>
    .btn {
        background-color: #5955DD;
        border-color: #5955DD;
    }

    .btn:hover {
        background-color: #4d4ab7;
        border-color: #4d4ab7;
    }

    .card {
        border: none;
        border-radius: 10px;
    }

    .card h2 {
        color: #5955DD;
    }

    .card p {
        color: #5955DD;
    }
</style>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
   document.getElementById('supportForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const email = document.getElementById('userEmail').value;
    const issueType = document.getElementById('issueType').value;
    const message = document.getElementById('userMessage').value;
    const submitButton = event.target.querySelector('button[type="submit"]');

    // Validar campos
    if (!issueType || !message) {
        alert('Por favor, completa todos los campos.');
        return;
    }

    // Mostrar modal de "Procesando"
    const processingModal = new bootstrap.Modal(document.getElementById('processingModal'));
    processingModal.show();

    submitButton.disabled = true;

    try {
        const response = await fetch('guardar_soporte.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `email=${encodeURIComponent(email)}&issueType=${encodeURIComponent(issueType)}&message=${encodeURIComponent(message)}`
        });

        const data = await response.text();
        console.log("Respuesta del servidor:", data);

        if (data.trim() === 'success') {
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
            document.getElementById('supportForm').reset(); // Limpiar el formulario
        } else {
            alert("Hubo un problema: " + data);
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    } catch (error) {
        console.error('Error al enviar los datos', error);
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    } finally {
        processingModal.hide();
        submitButton.disabled = false;
    }
});
</script>

</body>
</html>