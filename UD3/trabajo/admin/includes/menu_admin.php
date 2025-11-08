<?php
// auth.php ya está cargado gracias a 'proteger.php',
// así que podemos usar las funciones como esAdmin() y getNombreUsuario()
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Panel AlquiLobato</a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio Admin</a>
                </li>
                
                <?php // --- LINKS PARA EDITORES Y ADMINS --- ?>
                <?php if (puedeEditar()): // ?>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Gestionar Blog</a>
                    </li>
                <?php endif; ?>

                <?php // --- LINKS SOLO PARA ADMINS --- ?>
                <?php if (esAdmin()): // ?>
                    <li class="nav-item">
                        <a class="nav-link" href="coches.php">Gestionar Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Gestionar Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservas.php">Gestionar Reservas</a>
                    </li>
                    <?php endif; ?>

            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php" target="_blank">Ver Web Pública</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="includes/logout.php">Cerrar Sesión (<?php echo htmlspecialchars(getNombreUsuario()); // ?>)</a>
                </li>
            </ul>

        </div>
    </div>
</nav>