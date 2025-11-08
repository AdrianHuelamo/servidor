<?php
// ¡IMPORTANTE! Iniciamos la sesión y cargamos las funciones ANTES de cualquier HTML.
require_once 'admin/includes/auth.php';

// Detectamos la página actual para el 'active'
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-expand-md navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">Alqui<span>Lobato</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($pagina_actual == 'index.php') ? 'active' : ''; ?>"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item <?php echo ($pagina_actual == 'about.php') ? 'active' : ''; ?>"><a href="about.php" class="nav-link">Sobre Nosotros</a></li>
                <li class="nav-item <?php echo ($pagina_actual == 'pricing.php') ? 'active' : ''; ?>"><a href="pricing.php" class="nav-link">Precios</a></li>
                <li class="nav-item <?php echo ($pagina_actual == 'car.php' || $pagina_actual == 'car-single.php') ? 'active' : ''; ?>"><a href="car.php" class="nav-link">Coches</a></li>
                <li class="nav-item <?php echo ($pagina_actual == 'blog.php' || $pagina_actual == 'blog-single.php') ? 'active' : ''; ?>"><a href="blog.php" class="nav-link">Blog</a></li>
                
                <?php if (estaLogueado()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            👤 <?php echo htmlspecialchars(getNombreUsuario()); ?>
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
                    <li class="nav-item <?php echo ($pagina_actual == 'login.php' || $pagina_actual == 'register.php') ? 'active' : ''; ?>"><a href="login.php" class="nav-link">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>