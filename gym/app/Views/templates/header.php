<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymFit - Tu Entrenador Virtual</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link href="<?= base_url('css/style.css?v=2') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow py-3">
  
  <div class="container">
    
    <a class="navbar-brand fw-bold fs-2 text-warning fst-italic" href="<?= base_url('/') ?>">
        GYMFIT
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      
      <ul class="navbar-nav me-auto ms-auto gap-4">
        <li class="nav-item">
            <a class="nav-link fs-5 text-white" href="<?= base_url('home') ?>">Inicio</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link fs-5 text-white" href="<?= base_url('grupos') ?>">Grupos Musculares</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 text-white" href="<?= base_url('ejercicios') ?>">Ejercicios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 text-white" href="<?= base_url('noticias') ?>">Noticias</a>
        </li>
      </ul>
      
      <div class="d-flex gap-2 mt-3 mt-lg-0 align-items-center">
        
        <?php if (session()->has('isLoggedIn')): ?>
            
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-4 me-2 text-warning"></i>
                    <span class="fw-bold"><?= esc(session()->get('username')) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    
                    <?php if(session()->get('rol') == 1): ?>
                        <li><h6 class="dropdown-header">Administración</h6></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin') ?>">Gestión de Ejercicios</a></li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>
                    
                    <li><a class="dropdown-item" href="#">Mis Favoritos</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
                </ul>
            </div>

        <?php else: ?>
            
            <a href="<?= base_url('login') ?>" class="btn btn-outline-light px-4 rounded-pill">Iniciar Sesión</a>
            <a href="<?= base_url('registro') ?>" class="btn btn-warning px-4 rounded-pill fw-bold">Registrarse</a>

        <?php endif; ?>
      </div>

    </div>
  </div>
</nav>