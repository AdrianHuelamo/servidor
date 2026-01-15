<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymFit - Tu Entrenador Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        /* Un poco de CSS extra para que quede bonito */
        .card-ejercicio { transition: transform 0.3s; }
        .card-ejercicio:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .hero-section { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://source.unsplash.com/random/1200x400/?gym'); background-size: cover; color: white; padding: 100px 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">🏋️‍♂️ GymFit</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Ejercicios</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Mis Rutinas</a></li>
      </ul>
      
      <div class="d-flex">
        <a href="#" class="btn btn-outline-light me-2">Iniciar Sesión</a>
        <a href="#" class="btn btn-warning">Registrarse</a>
        
        </div>
    </div>
  </div>
</nav>