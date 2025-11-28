<?php
require_once 'auth.php';

$pagina_actual = basename($_SERVER['PHP_SELF']);
?>

<style>
    .navbar-nav .nav-link {
        display: flex;
        align-items: center;
    }
    .navbar-nav .nav-link span.oi {
        margin-right: 8px;
        min-width: 1em; 
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <span class="oi oi-spreadsheet" style="margin-right: 8px;"></span>Panel AlquiLobato
        </a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item <?php echo ($pagina_actual == 'index.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php"><span class="oi oi-home"></span>Inicio</a>
                </li>
                
                <?php if (puedeEditar()): ?>
                    <li class="nav-item <?php echo ($pagina_actual == 'blog.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="blog.php"><span class="oi oi-document"></span>Blog</a>
                    </li>
                <?php endif; ?>

                <?php if (esAdmin()): ?>
                    <li class="nav-item <?php echo ($pagina_actual == 'coches.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="coches.php"><span class="oi oi-dashboard"></span>Coches</a>
                    </li>
                    <li class="nav-item <?php echo ($pagina_actual == 'marcas.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="marcas.php"><span class="oi oi-tags"></span>Marcas</a>
                    </li>
                    <li class="nav-item <?php echo ($pagina_actual == 'reservas.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="reservas.php"><span class="oi oi-calendar"></span>Reservas</a>
                    </li>
                    <li class="nav-item <?php echo ($pagina_actual == 'usuarios.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="usuarios.php"><span class="oi oi-people"></span>Usuarios</a>
                    </li>
                <?php endif; ?>

            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php" target="_blank">
                        <span class="oi oi-external-link"></span>Ver Web
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="includes/logout.php">
                        <span class="oi oi-account-logout"></span>Salir (<?php echo htmlspecialchars(getNombreUsuario()); ?>)
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>