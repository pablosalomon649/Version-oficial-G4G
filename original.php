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

    <!-- Carrusel de imágenes -->
    <section class="banner">
        <div id="newCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#newCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#newCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#newCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex align-items-center justify-content-center" style="height: 500px; background: linear-gradient(to right, #1e3c72, #2a5298);">
                        <div class="text-center text-light">
                            <h2 class="fw-bold">Bienvenido a Nuestra Tienda</h2>
                            <p class="lead">Descubre ofertas exclusivas y productos increíbles.</p>
                            <a href="#" class="btn btn-light">Explorar Ahora</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-center" style="height: 500px; background: linear-gradient(to right, #ff7e5f, #feb47b);">
                        <div class="text-center text-dark">
                            <h2 class="fw-bold">Ofertas de Temporada</h2>
                            <p class="lead">Aprovecha descuentos de hasta el 50%.</p>
                            <a href="#" class="btn btn-dark">Ver Ofertas</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-center" style="height: 500px; background: linear-gradient(to right, #36d1dc, #5b86e5);">
                        <div class="text-center text-light">
                            <h2 class="fw-bold">Nuevos Lanzamientos</h2>
                            <p class="lead">Descubre lo más nuevo en tecnología y entretenimiento.</p>
                            <a href="#" class="btn btn-primary">Saber Más</a>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#newCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#newCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>

<!-- Sección de Categorías -->
<section class="categorie" id="imagenesxd">
    <div class="container text-center mb-4">
        <h2 class="fw-bold">Categorías</h2>
        <p>Explora nuestras categorías para encontrar lo que buscas</p>
    </div>
    
   <!-- Categorías -->
<section class="categories" id="imagenesxd">
    <?php
    $categorias = [
        "Nintendo" => "img_products/nitendos.png",
        "PlayStation" => "img_products/playstation.png",
        "Xbox" => "img_products/xboxs.png",
        "Accesorios" => "img_products/accesorios.png",
        "Videojuegos" => "img_products/videojuego.png"
    ];
    $activeCategory = isset($_GET['search']) ? $_GET['search'] : '';
    foreach ($categorias as $categoria => $imagen) {
        $isActive = ($categoria === $activeCategory) ? "active" : "";
        echo "
        <div class='category'>
            <a href='index.php?search=$categoria' class='$isActive'>
                <img src='$imagen' alt='$categoria'>
            </a>
        </div>";
    }
    ?>
</section>


    <!-- Productos -->
   <?php include "procesos/mostrar_productos.php"; ?>

    <p style="margin-top: 100px;"></p>

  
 <!-- Botón de Soporte Técnico en la parte móvil -->
<div class="position-fixed bottom-0 end-0 m-4">
    <button class="btn rounded-circle shadow-lg p-3" style="background-color: #5955DD; width: 70px; height: 70px; font-size: 1.7rem;" data-bs-toggle="modal" data-bs-target="#soporteModal">
        <i class="fas fa-headset" style="font-size: 2rem;"></i>
    </button>
</div>

<!-- Modal de Soporte Técnico (Responsivo) -->
<div class="modal fade" id="soporteModal" tabindex="-1" aria-labelledby="soporteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="soporteModalLabel" style="color: #5955DD;"><i class="fas fa-headset"></i> Soporte Técnico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Cuéntanos tu problema, ¡estamos aquí para ayudarte!</p>
                <form id="supportForm">
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="userEmail" value="<?php echo $_SESSION['Correo']; ?>" readonly>
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
    @media (max-width: 768px) {
        .modal-dialog.modal-lg {
            max-width: 100%;
            margin: 0;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
        }

        .btn {
            font-size: 1rem;
        }

        .btn-close {
            font-size: 1.5rem;
        }
    }

    .btn {
        background-color: #5955DD;
        border-color: #5955DD;
    }

    .btn:hover {
        background-color: #4d4ab7;
        border-color: #4d4ab7;
    }

    .modal-header .modal-title {
        color: #5955DD;
    }

    .modal-body p {
        color: #5955DD;
    }
</style>

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
