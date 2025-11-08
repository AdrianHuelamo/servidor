<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/database.php'; 
$db = new Connection();
$conn = $db->getConnection(); 

$sql_opiniones = "SELECT * FROM opiniones ORDER BY id_opinion ASC";
$resultado_opiniones = $conn->query($sql_opiniones);

$opiniones = [];
if ($resultado_opiniones && $resultado_opiniones->num_rows > 0) {
    while($fila = $resultado_opiniones->fetch_assoc()) {
        $opiniones[] = $fila;
    }
}

$db->closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato - Sobre Nosotros</title>
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
    
    <?php include("menu.php"); ?>
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/about.webp'); background-position: center bottom;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Sobre Nosotros <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Sobre Nosotros</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-about">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/lobato-ok.webp); background-position: center bottom;">
          </div>
          <div class="col-md-6 wrap-about ftco-animate">
            <div class="heading-section heading-section-white pl-md-5">
              <span class="subheading">Sobre Nosotros</span>
              <h2 class="mb-4">Bienvenido a AlquiLobato</h2>

              <p>¿Quieres saber cuanto vale alquilar un coche?</p>
              <p>En AlquiLobato, entendemos que cada viaje es una nueva aventura. Nacimos de la pasión por la carretera y el servicio, con la misión de ofrecerte la libertad de moverte a tu ritmo, con el coche perfecto para cada ocasión.</p>
              <p>Nuestra flota está cuidadosamente seleccionada para garantizar tu seguridad y confort. Desde coches compactos ideales para la ciudad hasta SUVs espaciosos y vehículos de lujo para momentos especiales. Con un proceso de reserva sencillo y precios transparentes, estamos aquí para hacer que tu alquiler sea tan fácil y agradable como el propio viaje.</p>
              <p><a href="car.php" class="btn btn-primary py-3 px-4">Busca tu coche</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <span class="subheading">Opiniones</span>
            <h2 class="mb-3">Clientes Satisfechos</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              
              <?php if (count($opiniones) > 0): ?>
                  <?php foreach ($opiniones as $opinion): ?>
                  <div class="item">
                    <div class="testimony-wrap rounded text-center py-4 pb-5">
                      <div class="user-img mb-2" style="background-image: url(<?php echo htmlspecialchars($opinion['imagen']); ?>)">
                      </div>
                      <div class="text pt-4">
                        <p class="mb-4"><?php echo htmlspecialchars($opinion['comentario']); ?></p>
                        <p class="name"><?php echo htmlspecialchars($opinion['nombre_cliente']); ?></p>
                        <span class="position"><?php echo htmlspecialchars($opinion['trabajo']); ?></span>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
              <?php else: ?>
                  <div class="item">
                    <div class="testimony-wrap rounded text-center py-4 pb-5">
                      <p>No hay opiniones disponibles en este momento.</p>
                    </div>
                  </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include("footer.php"); ?>
    
  

  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>