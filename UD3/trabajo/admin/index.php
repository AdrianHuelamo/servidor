<?php
// 1. ¡EL GUARDIA PRIMERO!
// Si no tienes permiso, 'proteger.php' te expulsará antes de ver nada.
require_once 'includes/proteger.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - AlquiLobato</title>
    
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/icomoon.css">
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
        .ftco-section {
            padding: 3em 0;
        }
        body {
            background: #f8f9fa;
        }
    </style>
</head>
<body>

    <?php // 2. Cargar el menú de admin ?>
    <?php include 'includes/menu_admin.php'; ?>

    <div class="container ftco-section">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Bienvenido al Panel de Administración</h1>
                <p>Hola, <strong><?php echo htmlspecialchars(getNombreUsuario()); // ?></strong>.</p>
                <p>Tu rol es: <strong><?php echo getRol(); // ?></strong>.</p>
                <p>Usa el menú superior para gestionar el contenido del sitio web.</p>
                
                <hr>
                
                <?php if (esAdmin()): // ?>
                    <div class="alert alert-success">
                        Tienes permisos de <b>Administrador</b>. Tienes acceso a todas las secciones.
                    </div>
                <?php elseif (puedeEditar()): // ?>
                    <div class="alert alert-info">
                        Tienes permisos de <b>Editor</b>. Puedes crear y editar las entradas del Blog.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>