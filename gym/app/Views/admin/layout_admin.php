<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - GymFit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="<?= base_url('css/admin.css') ?>" rel="stylesheet">
</head>
<body>

<div class="d-flex" id="wrapper">
    
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3 class="fw-bold m-0">GYM<span class="text-warning">FIT</span></h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="<?= base_url('admin') ?>" class="<?= uri_string() == 'admin' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/ejercicios') ?>" class="<?= str_contains(uri_string(), 'ejercicios') ? 'active' : '' ?>">
                    <i class="bi bi-dumbbell"></i> Ejercicios
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/grupos') ?>" class="<?= str_contains(uri_string(), 'grupos') ? 'active' : '' ?>">
                    <i class="bi bi-layers"></i> Grupos Musculares
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/noticias') ?>" class="<?= str_contains(uri_string(), 'noticias') ? 'active' : '' ?>">
                    <i class="bi bi-newspaper"></i> Noticias
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/usuarios') ?>" class="<?= str_contains(uri_string(), 'usuarios') ? 'active' : '' ?>">
                    <i class="bi bi-people"></i> Usuarios
                </a>
            </li>
            
            <li class="mt-5 border-top border-secondary pt-3">
                <a href="<?= base_url('/') ?>" target="_blank">
                    <i class="bi bi-eye"></i> Ver Web Pública
                </a>
            </li>
            <li>
                <a href="<?= base_url('logout') ?>" class="text-danger">
                    <i class="bi bi-box-arrow-left"></i> Cerrar Sesión
                </a>
            </li>
        </ul>
    </nav>

    <div id="content">
        <nav class="navbar-admin">
            <h5 class="m-0 text-secondary">Panel de Control</h5>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold small"><?= session('username') ?></span>
                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                    <?= substr(session('username') ?? 'A', 0, 1) ?>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <?php if(session()->getFlashdata('mensaje')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('mensaje') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('contenido') ?>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>