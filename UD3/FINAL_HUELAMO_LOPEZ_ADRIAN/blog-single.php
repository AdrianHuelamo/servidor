<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: blog.php');
    exit;
}
$id_blog = $_GET['id'];

$db = new Connection();
$conn = $db->getConnection(); 

$sql = "SELECT b.*, u.nombre AS nombre_autor, u.imagen AS autor_imagen, u.bio AS autor_bio 
        FROM blog b
        LEFT JOIN usuarios u ON b.id_autor = u.id_usuario
        WHERE b.id_blog = ?";
        
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_blog);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $post = $resultado->fetch_assoc();
    
    if(empty($post['nombre_autor'])) {
        $post['nombre_autor'] = 'Admin';
    }
    if(empty($post['autor_imagen'])) {
        $post['autor_imagen'] = 'images/autores/default.png';
    }
    if(empty($post['autor_bio'])) {
        $post['autor_bio'] = 'Este autor todavía no ha escrito su biografía.';
    }

} else {
    header('Location: blog.php');
    exit;
}
$stmt->close();

$sql_recent = "SELECT b.*, u.nombre AS nombre_autor 
               FROM blog b
               LEFT JOIN usuarios u ON b.id_autor = u.id_usuario
               WHERE b.id_blog != ? 
               ORDER BY b.fecha DESC 
               LIMIT 3";
               
$stmt_recent = $conn->prepare($sql_recent);
if ($stmt_recent === false) {
    die("Error al preparar la consulta reciente: " . $conn->error);
}

$stmt_recent->bind_param("i", $id_blog);
$stmt_recent->execute();
$resultado_recent = $stmt_recent->get_result();

$recent_posts = [];
if ($resultado_recent->num_rows > 0) {
    while($fila = $resultado_recent->fetch_assoc()) {
        if(empty($fila['nombre_autor'])) {
            $fila['nombre_autor'] = 'Admin';
        }
        $recent_posts[] = $fila;
    }
}
$stmt_recent->close();

$db->closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato - <?php echo htmlspecialchars($post['titulo']); ?></title>
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

    <style>
        .hero-wrap .slider-text h1.bread {
            line-height: 1.4; 
        }
    </style>
    </head>
  <body>
    
    <?php include("menu.php"); ?>
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="blog.php">Blog <i class="ion-ios-arrow-forward"></i></a></span> <span>Entrada <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread"><?php echo htmlspecialchars($post['titulo']); ?></h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-degree-bg">
      <div class="container">
        <div class="row">
          <div class="col-md-8 ftco-animate">
            <h2 class="mb-3"><?php echo htmlspecialchars($post['titulo']); ?></h2>
            <p>
              <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>" class="img-fluid">
            </p>
            
            <?php 
                $contenido_con_br = nl2br(htmlspecialchars($post['contenido']));
                echo "<p>" . str_replace("<br />\r\n<br />\r\n", "</p><p>", $contenido_con_br) . "</p>";
            ?>
            
            <div class="about-author d-flex p-4 bg-light mt-5">
              <div class="bio mr-5">
                <img src="<?php echo htmlspecialchars($post['autor_imagen']); ?>" alt="Foto de <?php echo htmlspecialchars($post['nombre_autor']); ?>" class="img-fluid mb-4" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
              </div>
              <div class="desc">
                <h3><?php echo htmlspecialchars($post['nombre_autor']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['autor_bio'])); ?></p>
              </div>
            </div>

          </div> <div class="col-md-4 sidebar ftco-animate">
            
            <div class="sidebar-box ftco-animate">
              <h3>Blog Reciente</h3>
              <?php if (count($recent_posts) > 0): ?>
                  <?php foreach ($recent_posts as $recent): ?>
                  <div class="block-21 mb-4 d-flex">
                    <a class="blog-img mr-4" style="background-image: url(<?php echo htmlspecialchars($recent['imagen']); ?>);"></a>
                    <div class="text">
                      <h3 class="heading"><a href="blog-single.php?id=<?php echo $recent['id_blog']; ?>"><?php echo htmlspecialchars($recent['titulo']); ?></a></h3>
                      <div class="meta">
                        <div><a href="#"><span class="icon-calendar"></span> <?php echo date("d M, Y", strtotime($recent['fecha'])); ?></a></div>
                        <div><a href="#"><span class="icon-person"></span> <?php echo htmlspecialchars($recent['nombre_autor']); ?></a></div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
              <?php else: ?>
                  <p>No hay posts recientes.</p>
              <?php endif; ?>
            </div>

          </div>

        </div>
      </div>
    </section> <?php include("footer.php"); ?>
    
  

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