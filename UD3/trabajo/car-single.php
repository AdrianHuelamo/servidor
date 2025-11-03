<?php
require_once 'admin/includes/database.php'; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: car.php');
    exit;
}
$id_coche = $_GET['id'];

$db = new Connection();
$conn = $db->getConnection(); 

$sql = "SELECT coches.*, marcas.nombre AS marca_nombre 
        FROM coches 
        JOIN marcas ON coches.id_categoria = marcas.id_marca 
        WHERE coches.id_coche = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_coche);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $coche = $resultado->fetch_assoc();
} else {
    $coche = null;
    header('Location: car.php');
    exit;
}

$stmt->close();

$coches_relacionados = [];
if ($coche) {
    $precio_actual = $coche['precio_dia'];
    $id_coche_actual = $coche['id_coche'];
    $rango_precio = 75;
    $precio_min = $precio_actual - $rango_precio;
    $precio_max = $precio_actual + $rango_precio;

    $sql_relacionados = "SELECT c.*, m.nombre AS marca_nombre 
                         FROM coches c
                         JOIN marcas m ON c.id_categoria = m.id_marca
                         WHERE c.precio_dia BETWEEN ? AND ?
                         AND c.id_coche != ?
                         ORDER BY RAND()
                         LIMIT 3";
    
    $stmt_rel = $conn->prepare($sql_relacionados);
    
    if ($stmt_rel) {
        $stmt_rel->bind_param("iii", $precio_min, $precio_max, $id_coche_actual);
        $stmt_rel->execute();
        $resultado_rel = $stmt_rel->get_result();
        
        while($fila_rel = $resultado_rel->fetch_assoc()) {
            $coches_relacionados[] = $fila_rel;
        }
        $stmt_rel->close();
    }
}

$db->closeConnection($conn);

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato - Detalles del Coche</title>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="car.php">Coches <i class="ion-ios-arrow-forward"></i></a></span> <span>Detalles Coche <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Detalles del Coche</h1>
          </div>
        </div>
      </div>
    </section>
		

	<section class="ftco-section ftco-car-details">
      <div class="container">
      	<div class="row justify-content-center">
      		<div class="col-md-12">
      			<div class="car-details">
      				<div class="img rounded" style="background-image: url(<?php echo htmlspecialchars($coche['imagen']); ?>);"></div>
      				<div class="text text-center">
      					<span class="subheading"><?php echo htmlspecialchars($coche['marca_nombre']); ?></span>
      					<h2><?php echo htmlspecialchars($coche['nombre']); ?></h2>
      				</div>
      			</div>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-dashboard"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Kilómetros
		                	<span><?php echo number_format($coche['kilometros'], 0, ',', '.'); ?> km</span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-pistons"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Transmisión
		                	<span><?php echo htmlspecialchars($coche['transmision']); ?></span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car-seat"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Asientos
		                	<span><?php echo htmlspecialchars($coche['asientos']); ?> Plazas</span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-backpack"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Maletero
		                	<span><?php echo htmlspecialchars($coche['maletero']); ?> L</span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-diesel"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Combustible
		                	<span><?php echo htmlspecialchars($coche['combustible']); ?></span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
      	</div>
      	<div class="row">
      		<div class="col-md-12 pills">
						<div class="bd-example bd-example-tabs">
							<div class="d-flex justify-content-center">
							  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							    <li class="nav-item">
							      <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Descripción</a>
							    </li>
							    <li class="nav-item">
							      <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Reseñas</a>
							    </li>
							  </ul>
							</div>
						  <div class="tab-content" id="pills-tabContent">
						    <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
						    	<p>Este <?php echo htmlspecialchars($coche['marca_nombre']) . " " . htmlspecialchars($coche['nombre']); ?> del año <?php echo htmlspecialchars($coche['año']); ?> es una opción fantástica para tu viaje. Cuenta con transmisión <?php echo htmlspecialchars($coche['transmision']); ?> y espacio para <?php echo htmlspecialchars($coche['asientos']); ?> personas. Perfecto para cualquier aventura.</p>
						    </div>
						    <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
						    </div>
						  </div>
						</div>
		      </div>
				</div>
      </div>
    </section>

    <section class="ftco-section ftco-no-pt">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          	<span class="subheading">Otros coches</span>
            <h2 class="mb-2">Coches Relacionados</h2>
          </div>
        </div>
        <div class="row">
            
            <?php if (count($coches_relacionados) > 0): ?>
                <?php foreach ($coches_relacionados as $coche_rel): ?>
                <div class="col-md-4">
                    <div class="car-wrap rounded ftco-animate">
                        <a href="car-single.php?id=<?php echo $coche_rel['id_coche']; ?>">
                            <div class="img rounded d-flex align-items-end" style="background-image: url(<?php echo htmlspecialchars($coche_rel['imagen']); ?>);">
                            </div>
                        </a>
                        <div class="text">
                            <h2 class="mb-0"><a href="car-single.php?id=<?php echo $coche_rel['id_coche']; ?>"><?php echo htmlspecialchars($coche_rel['nombre']); ?></a></h2>
                            <div class="d-flex mb-3">
                                <span class="cat"><?php echo htmlspecialchars($coche_rel['marca_nombre']); ?></span>
                                <p class="price ml-auto">$<?php echo htmlspecialchars($coche_rel['precio_dia']); ?> <span>/día</span></p>
                            </div>
                            <p class="d-flex mb-0 d-block">
                                <a href="#" class="btn btn-primary py-2 mr-1">Reservar</a> 
                                <a href="car-single.php?id=<?php echo $coche_rel['id_coche']; ?>" class="btn btn-secondary py-2 ml-1">Detalles</a>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12 text-center">
                    <p>No hay más coches con un precio similar disponibles.</p>
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