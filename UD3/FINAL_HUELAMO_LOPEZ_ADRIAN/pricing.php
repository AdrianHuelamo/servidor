<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/database.php'; 

$db = new Connection();
$conn = $db->getConnection(); 

$coches = [];

$perPage = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$countSql = "SELECT COUNT(*) AS total FROM coches";
$countRes = $conn->query($countSql);
$totalRows = 0;
if ($countRes) {
  $r = $countRes->fetch_assoc();
  $totalRows = (int)$r['total'];
}

$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;
if ($page > $totalPages) $page = $totalPages;

$offset = ($page - 1) * $perPage;

$sql = "SELECT c.id_coche, c.nombre AS coche_nombre, m.nombre AS marca_nombre, c.imagen, 
    c.precio_hora, c.precio_dia, c.precio_mes FROM coches c JOIN  marcas m ON c.id_categoria = m.id_marca
    ORDER BY c.precio_hora LIMIT " . ((int)$offset) . "," . ((int)$perPage);

$result = $conn->query($sql);

if ($result === FALSE) {
} else if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $coches[] = $row;
  }
  $result->free();
} else {
}

$db->closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Precios</title>
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

    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/precios.webp');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Precios <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Nuestros Precios</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="car-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>Vehículo</th>
						        <th class="bg-primary heading">Precio Por Hora</th>
						        <th class="bg-dark heading">Precio Por Día</th>
						        <th class="bg-black heading">Precio Por Mes</th>
						      </tr>
						    </thead>
						    
						    <tbody>
                              <?php if (empty($coches)): ?>
                                <tr class="text-center">
                                    <td colspan="5">No hay coches disponibles en este momento.</td>
                                </tr>
                              <?php else: ?>
                                <?php foreach ($coches as $coche): ?>
                                  <tr class="">
                                    
                                    <td class="car-image">
                                        <a href="car-single.php?id=<?php echo $coche['id_coche']; ?>">
                                            <div class="img" style="background-image:url(<?php echo htmlspecialchars($coche['imagen']); ?>);"></div>
                                        </a>
                                    </td>
                                    
                                    <td class="product-name">
                                        <h3>
                                            <a href="car-single.php?id=<?php echo $coche['id_coche']; ?>">
                                                <?php echo htmlspecialchars($coche['marca_nombre'] . ' ' . $coche['coche_nombre']); ?>
                                            </a>
                                        </h3>
                                    </td>
                                    
                                    <td class="price">
                                        <p class="btn-custom">
                                            <?php if (estaLogueado()): ?>
                                                <a href="reservar.php?id=<?php echo $coche['id_coche']; ?>">Alquilar ahora</a>
                                            <?php else: ?>
                                                <a href="login.php?error=1">Alquilar ahora</a>
                                            <?php endif; ?>
                                        </p>
                                        <div class="price-rate">
                                            <h3>
                                                <span class="num"><?php echo htmlspecialchars($coche['precio_hora']); ?>€</span>
                                                <span class="per">/por hora</span>
                                            </h3>
                                        </div>
                                    </td>
                                    
                                    <td class="price">
                                        <p class="btn-custom">
                                            <?php if (estaLogueado()): ?>
                                                <a href="reservar.php?id=<?php echo $coche['id_coche']; ?>">Alquilar ahora</a>
                                            <?php else: ?>
                                                <a href="login.php?error=1">Alquilar ahora</a>
                                            <?php endif; ?>
                                        </p>
                                        <div class="price-rate">
                                            <h3>
                                                <span class="num"> <?php echo htmlspecialchars($coche['precio_dia']); ?>€</span>
                                                <span class="per">/por día</span>
                                            </h3>
                                    </div>
                                    </td>

                                    <td class="price">
                                        <p class="btn-custom">
                                            <?php if (estaLogueado()): ?>
                                                <a href="reservar.php?id=<?php echo $coche['id_coche']; ?>">Alquilar ahora</a>
                                            <?php else: ?>
                                                <a href="login.php?error=1">Alquilar ahora</a>
                                            <?php endif; ?>
                                        </p>
                                        <div class="price-rate">
                                            <h3>
                                                <span class="num"> <?php echo htmlspecialchars($coche['precio_mes']); ?>€</span>
                                                <span class="per">/por mes</span>
                                            </h3>
                                        </div>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              <?php endif; ?>
						    </tbody>

						  </table>
					  </div>
    			</div>
    		</div>
        </div>

        <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="row mt-5">
          <div class="col text-center">
          <div class="block-27">
            <ul>
            <?php
            if ($page > 1) {
              $prev = $page - 1;
              echo '<li><a href="' . htmlspecialchars('pricing.php?page=' . $prev) . '">&lt;</a></li>';
            } else {
              echo '<li class="disabled"><span>&lt;</span></li>';
            }
            for ($p = 1; $p <= $totalPages; $p++) {
              if ($p == $page) {
                echo "<li class=\"active\"><span>$p</span></li>";
              } else {
                echo '<li><a href="' . htmlspecialchars('pricing.php?page=' . $p) . '">' . $p . '</a></li>';
              }
            }
            if ($page < $totalPages) {
              $next = $page + 1;
              echo '<li><a href="' . htmlspecialchars('pricing.php?page=' . $next) . '">&gt;</a></li>';
            } else {
              echo '<li class="disabled"><span>&gt;</span></li>';
            }
            ?>
            </ul>
          </div>
          </div>
        </div>
        <?php endif; ?>
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