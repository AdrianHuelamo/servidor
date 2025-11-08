<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/database.php'; 
$db = new Connection();
$conn = $db->getConnection(); 


$sql = "SELECT b.id_blog, b.titulo, b.resumen, b.fecha, b.imagen, u.nombre AS nombre_autor 
        FROM blog b 
        LEFT JOIN usuarios u ON b.id_autor = u.id_usuario
        ORDER BY b.fecha DESC";

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato - Nuestro Blog</title>
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
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/blog.webp');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Blog <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Nuestro Blog</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row d-flex justify-content-center">

            <?php
            if ($result && $result->num_rows > 0) {
                while($post = $result->fetch_assoc()) {
                    
                    $autor = !empty($post['nombre_autor']) ? $post['nombre_autor'] : 'Admin';
                    
                    $fecha_formateada = date("M d, Y", strtotime($post['fecha']));
            ?>

            <div class="col-md-12 text-center d-flex ftco-animate">
                <div class="blog-entry justify-content-end mb-md-5">
                <a href="blog-single.php?id=<?php echo $post['id_blog']; ?>" class="block-20 img" style="background-image: url('<?php echo htmlspecialchars($post['imagen']); ?>');">
                </a>
                <div class="text px-md-5 pt-4">
                    <div class="meta mb-3">
                    <div><a href="#"><?php echo $fecha_formateada; ?></a></div>
                    <div><a href="#"><?php echo htmlspecialchars($autor); ?></a></div>
                    </div>
                    <h3 class="heading mt-2"><a href="blog-single.php?id=<?php echo $post['id_blog']; ?>"><?php echo htmlspecialchars($post['titulo']); ?></a></h3>
                    <p><?php echo htmlspecialchars($post['resumen']); ?></p>
                    <p><a href="blog-single.php?id=<?php echo $post['id_blog']; ?>" class="btn btn-primary">Continuar Leyendo <span class="icon-long-arrow-right"></span></a></p>
                </div>
                </div>
            </div>

            <?php
                } 
            } else {
                echo "<div class='col-md-12 text-center'><p>No hay entradas en el blog por el momento.</p></div>";
            }
            
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
  <script src="httpsias.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>