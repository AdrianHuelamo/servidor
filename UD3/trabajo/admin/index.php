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

$sql_opiniones = "SELECT * FROM opiniones ORDER BY id_opinion ASC";
$resultado_opiniones = $conn->query($sql_opiniones);
$opiniones = [];
if ($resultado_opiniones && $resultado_opiniones->num_rows > 0) {
    while($fila = $resultado_opiniones->fetch_assoc()) {
        $opiniones[] = $fila;
    }
}

$sql_destacados = "SELECT c.*, m.nombre AS marca_nombre 
                   FROM coches c 
                   JOIN marcas m ON c.id_categoria = m.id_marca 
                   ORDER BY c.precio_dia DESC 
                   LIMIT 6";
$resultado_destacados = $conn->query($sql_destacados);
$coches_destacados = [];
if ($resultado_destacados && $resultado_destacados->num_rows > 0) {
    while($fila_d = $resultado_destacados->fetch_assoc()) {
        $coches_destacados[] = $fila_d;
    }
}

$sql_servicios = "SELECT * FROM servicios ORDER BY id_servicio ASC";
$resultado_servicios = $conn->query($sql_servicios);
$servicios = [];
if ($resultado_servicios && $resultado_servicios->num_rows > 0) {
    while($fila_s = $resultado_servicios->fetch_assoc()) {
        $servicios[] = $fila_s;
    }
}

$sql_blog = "SELECT b.*, u.username AS nombre_autor 
             FROM blog b
             LEFT JOIN usuarios u ON b.id_autor = u.id_usuario
             ORDER BY b.fecha DESC 
             LIMIT 3";
$resultado_blog = $conn->query($sql_blog);
$posts_blog = [];
if ($resultado_blog && $resultado_blog->num_rows > 0) {
    while($fila_b = $resultado_blog->fetch_assoc()) {
        if(empty($fila_b['nombre_autor'])) {
            $fila_b['nombre_autor'] = 'Admin';
        }
        $posts_blog[] = $fila_b;
    }
}

$db->closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato</title>
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
    
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-8 ftco-animate">
          	<div class="text w-100 text-center mb-md-5 pb-md-5">
	            <h1 class="mb-4">Alquila ya el coche que necesites</h1>
	            <p style="font-size: 22px;">¿Quieres saber cuanto vale alquilar un coche? <br> Busca el coche que mejor se adapte a ti en nuestra web</p>
	            <a href="https://vimeo.com/45830194" class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
	            	<div class="icon d-flex align-items-center justify-content-center">
	            		<span class="ion-ios-play"></span>
	            	</div>
	            	<div class="heading-title ml-5">
		            	<span>Los faciles pasos para alquilar un coche</span>
	            	</div>
	            </a>
            </div>
          </div>
        </div>
      </div>
    </div>

     <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-12	featured-top">
    				<div class="row no-gutters">
	  					<div class="col-md-4 d-flex align-items-center">
	  						<form action="#" class="request-form ftco-animate bg-primary">
		          		<h2>Monta tu viaje</h2>
			    				<div class="form-group">
			    					<label for="" class="label">Pick-up location</label>
			    					<input type="text" class="form-control" placeholder="City, Airport, Station, etc">
			    				</div>
			    				<div class="form-group">
			    					<label for="" class="label">Drop-off location</label>
			    					<input type="text" class="form-control" placeholder="City, Airport, Station, etc">
			    				</div>
			    				<div class="d-flex">
			    					<div class="form-group mr-2">
			                <label for="" class="label">Pick-up date</label>
			                <input type="text" class="form-control" id="book_pick_date" placeholder="Date">
			              </div>
			              <div class="form-group ml-2">
			                <label for="" class="label">Drop-off date</label>
			                <input type="text" class="form-control" id="book_off_date" placeholder="Date">
			              </div>
		              </div>
		              <div class="form-group">
		                <label for="" class="label">Pick-up time</label>
		                <input type="text" class="form-control" id="time_pick" placeholder="Time">
		              </div>
			            <div class="form-group">
			              <input type="submit" value="Rent A Car Now" class="btn btn-secondary py-3 px-4">
			            </div>
			    			</form>
	  					</div>
	  					<div class="col-md-8 d-flex align-items-center">
	  						<div class="services-wrap rounded-right w-100">
	  							<h3 class="heading-section mb-4">Better Way to Rent Your Perfect Cars</h3>
	  							<div class="row d-flex mb-4">
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Choose Your Pickup Location</h3>
				                </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-handshake"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Select the Best Deal</h3>
					              </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-rent"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Reserve Your Rental Car</h3>
					              </div>
					            </div>      
					          </div>
					        </div>
					        <p><a href="car.php" class="btn btn-primary py-3 px-4">Reserve Your Perfect Car</a></p>
	  						</div>
	  					</div>
	  				</div>
				</div>
  		</div>
    </section>


    <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          	<span class="subheading">¿Que ofrecemos?</span>
            <h2 class="mb-2">Coches destacados</h2>
          </div>
        </div>
    		<div class="row">
    			<div class="col-md-12">
    				<div class="carousel-car owl-carousel">
                        
                        <?php if (count($coches_destacados) > 0): ?>
                            <?php foreach ($coches_destacados as $coche_d): ?>
                            <div class="item">
                                <div class="car-wrap rounded ftco-animate">
                                    <a href="car-single.php?id=<?php echo $coche_d['id_coche']; ?>">
                                        <div class="img rounded d-flex align-items-end" style="background-image: url(<?php echo htmlspecialchars($coche_d['imagen']); ?>);">
                                        </div>
                                    </a>
                                    <div class="text">
                                        <h2 class="mb-0"><a href="car-single.php?id=<?php echo $coche_d['id_coche']; ?>"><?php echo htmlspecialchars($coche_d['nombre']); ?></a></h2>
                                        <div class="d-flex mb-3">
                                            <span class="cat"><?php echo htmlspecialchars($coche_d['marca_nombre']); ?></span>
                                            <p class="price ml-auto">$<?php echo htmlspecialchars($coche_d['precio_dia']); ?> <span>/día</span></p>
                                        </div>
                                        <p class="d-flex mb-0 d-block"><a href="login.php" class="btn btn-primary py-2 mr-1">Reserva ya</a> <a href="car-single.php?id=<?php echo $coche_d['id_coche']; ?>" class="btn btn-secondary py-2 ml-1">Detalles</a></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay coches destacados en este momento.</p>
                        <?php endif; ?>

    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-section ftco-about">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/lobato-ok.webp);">
					</div>
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section heading-section-white pl-md-5">
	          	<span class="subheading">Sobre nosotros</span>
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

		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Servicios</span>
            <h2 class="mb-3">Nuestros Servicios</h2>
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

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Blog</span>
            <h2>Blog Reciente</h2>
          </div>
        </div>
        <div class="row d-flex">

            <?php if (count($posts_blog) > 0): ?>
                <?php foreach ($posts_blog as $post_b): ?>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="blog-entry justify-content-end">
                    <a href="blog-single.php?id=<?php echo $post_b['id_blog']; ?>" class="block-20" style="background-image: url('<?php echo htmlspecialchars($post_b['imagen']); ?>');">
                    </a>
                    <div class="text pt-4">
                        <div class="meta mb-3">
                        <div><a href="#"><?php echo date("d M, Y", strtotime($post_b['fecha'])); ?></a></div>
                        <div><a href="#"><?php echo htmlspecialchars($post_b['nombre_autor']); ?></a></div>
                        </div>
                        <h3 class="heading mt-2"><a href="blog-single.php?id=<?php echo $post_b['id_blog']; ?>"><?php echo htmlspecialchars($post_b['titulo']); ?></a></h3>
                        <p><a href="blog-single.php?id=<?php echo $post_b['id_blog']; ?>" class="btn btn-primary">Leer más</a></p>
                    </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12 text-center">
                    <p>No hay entradas de blog recientes.</p>
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