<?php
require_once 'admin/includes/database.php'; 

$db = new Connection();
$conn = $db->getConnection(); 

$sql = "SELECT c.id_coche, c.nombre AS car_name, c.precio_dia, c.imagen, m.nombre AS brand_name 
        FROM coches c 
        JOIN marcas m ON c.id_categoria = m.id_marca
        ORDER BY m.nombre, c.nombre"; // Opcional: ordenar los resultados

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Carbook - Elige tu Coche</title>
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
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Coches <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Elige tu coche</h1>
          </div>
        </div>
      </div>
    </section>
		

	<section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">

				<?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>

    			<div class="col-md-4">
    				<div class="car-wrap rounded ftco-animate">
						<div class="img rounded d-flex align-items-end" style="background-image: url(<?php echo htmlspecialchars($row['imagen']); ?>);">
    					</div>
    					<div class="text">
							<h2 class="mb-0"><a href="car-single.php?id=<?php echo $row['id_coche']; ?>"><?php echo htmlspecialchars($row['car_name']); ?></a></h2>
    						<div class="d-flex mb-3">
	    						<span class="cat"><?php echo htmlspecialchars($row['brand_name']); ?></span>
	    						<p class="price ml-auto">$<?php echo htmlspecialchars($row['precio_dia']); ?> <span>/día</span></p>
    						</div>
							<p class="d-flex mb-0 d-block"><a href="#" class="btn btn-primary py-2 mr-1">Reserva ya</a> <a href="car-single.php?id=<?php echo $row['id_coche']; ?>" class="btn btn-secondary py-2 ml-1">Detalles</a></p>
    					</div>
    				</div>
    			</div>

				<?php
                    } // Fin del while
                } else {
                    echo "<p>No hay coches disponibles en este momento.</p>";
                }
                // Cerramos la conexión
                $db->closeConnection($conn);
                ?>

    		</div>
    		<div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
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