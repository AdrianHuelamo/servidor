<?php
// Incluir sistema de autenticación
if (!function_exists('estaLogueado')) {
    require_once 'admin/includes/auth.php';
}
?>

<nav class="navbar navbar-expand-lg navbar-expand-md navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">Alqui<span>Lobato</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">Nosotros</a></li>
                <li class="nav-item"><a href="services.php" class="nav-link">Servicios</a></li>
                <li class="nav-item"><a href="car.php" class="nav-link">Coches</a></li>
                <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contacto</a></li>
                
                <?php if (estaLogueado()): ?>
                    <!-- Usuario logueado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            👤 <?php echo getNombreUsuario(); ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <?php if (puedeEditar()): ?>
                                <a class="dropdown-item" href="admin/index.php">⚙️ Panel Admin</a>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>
                            <a class="dropdown-item" href="mis-reservas.php">📋 Mis Reservas</a>
                            <a class="dropdown-item" href="perfil.php">👤 Mi Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="admin/includes/logout.php">🚪 Cerrar Sesión</a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Usuario NO logueado -->
                    <li class="nav-item"><a href="login.php" class="nav-link">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
