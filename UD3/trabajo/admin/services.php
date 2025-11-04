<?php
require_once("./includes/sessions.php");
$sesion = new Sessions();

if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}
require_once 'includes/database.php'; 
$db = new Connection();
$conn = $db->getConnection(); 

$sql_servicios = "SELECT * FROM servicios ORDER BY id_servicio ASC";
$resultado_servicios = $conn->query($sql_servicios);

$servicios = [];
if ($resultado_servicios && $resultado_servicios->num_rows > 0) {
    while($fila = $resultado_servicios->fetch_assoc()) {
        $servicios[] = $fila;
    }
}

$db->closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato - Nuestros Servicios</title>
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
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/servicios.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Servicios <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Nuestros Servicios</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Servicios</span>
            <h2 class="mb-3">Nuestros Últimos Servicios</h2>
          </div>
        </div>
				<div class="row">

                <?php if (count($servicios) > 0): ?>
                    <?php foreach ($servicios as $servicio): ?>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	            <div class="icon d-flex align-items-center justify-content-center"><span class="<?php echo htmlspecialchars($servicio['icono_flaticon']); ?>"></span></div>
            	            <div class="text w-100">
                                <h3 class="heading mb-2"><?php echo htmlspecialchars($servicio['titulo']); ?></h3>
                                <p><?php echo htmlspecialchars($servicio['descripcion']); ?></p>
                            </div>
                        </div>
					</div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-md-12 text-center">
                        <p>No hay servicios disponibles en este momento.</p>
                    </div>
                <?php endif; ?>

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