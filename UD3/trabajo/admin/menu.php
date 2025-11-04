<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alquilobato</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">Alqui<span>Lobato</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item <?php echo ($pagina_actual == 'index.php') ? 'active' : ''; ?>"><a href="index.php" class="nav-link">Inicio</a></li>
	          <li class="nav-item <?php echo ($pagina_actual == 'about.php') ? 'active' : ''; ?>"><a href="about.php" class="nav-link">Sobre Nosotros</a></li>
	          <li class="nav-item <?php echo ($pagina_actual == 'services.php') ? 'active' : ''; ?>"><a href="services.php" class="nav-link">Servicios</a></li>
	          <li class="nav-item <?php echo ($pagina_actual == 'pricing.php') ? 'active' : ''; ?>"><a href="pricing.php" class="nav-link">Precios</a></li>
	          <li class="nav-item <?php echo ($pagina_actual == 'car.php' || $pagina_actual == 'car-single.php') ? 'active' : ''; ?>"><a href="car.php" class="nav-link">Coches</a></li>
	          <li class="nav-item <?php echo ($pagina_actual == 'blog.php' || $pagina_actual == 'blog-single.php') ? 'active' : ''; ?>"><a href="blog.php" class="nav-link">Blog</a></li>
	          <li class="nav-item <?php echo ($pagina_actual == 'logout.php') ? 'active' : ''; ?>"><a href="includes/logout.php" class="nav-link">Cerrar Sesion</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
</body>
</html>