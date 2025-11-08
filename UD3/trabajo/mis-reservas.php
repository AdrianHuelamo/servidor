<?php
// 1. Cargar auth y database
require_once 'admin/includes/auth.php'; //
require_once 'admin/includes/database.php'; //

// 2. PROTEGER LA PÁGINA
if (!estaLogueado()) { //
    header('Location: login.php?error=1'); //
    exit();
}

// 3. Obtener el ID del usuario
$id_usuario = getUserId(); //

// 4. Variables para mensajes
$success_msg = '';
if (isset($_GET['exito']) && $_GET['exito'] == '1') {
    $success_msg = "¡Reserva confirmada con éxito!";
}

// 5. Obtener todas las reservas del usuario
$db = new Connection();
$conn = $db->getConnection();

$reservas = [];
$sql = "SELECT r.*, c.nombre AS coche_nombre, c.imagen AS coche_imagen, m.nombre AS marca_nombre
        FROM reservas r
        JOIN coches c ON r.id_coche = c.id_coche
        JOIN marcas m ON c.id_categoria = m.id_marca
        WHERE r.id_usuario = ?
        ORDER BY r.fecha_inicio DESC"; // Mostrar las más nuevas primero

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $reservas[] = $fila;
    }
}
$stmt->close();
$db->closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mis Reservas - AlquiLobato</title>
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
    
    <?php include("menu.php"); // ?>
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/mis-reservas.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Mis Reservas <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Mis Reservas</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    
                    <?php if ($success_msg): ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                    <?php endif; ?>

                    <?php if (empty($reservas)): ?>
                        <div class="text-center p-5 bg-light rounded">
                            <h2 class="mb-3">No tienes reservas</h2>
                            <p>Aún no has hecho ninguna reserva. ¡Explora nuestra flota!</p>
                            <p><a href="car.php" class="btn btn-primary">Ver Coches</a></p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($reservas as $reserva): ?>
                        <div class="card mb-4 shadow-sm">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="<?php echo htmlspecialchars($reserva['coche_imagen']); ?>" class="card-img" alt="<?php echo htmlspecialchars($reserva['coche_nombre']); ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($reserva['marca_nombre'] . ' ' . $reserva['coche_nombre']); ?></h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <strong>Desde:</strong> <?php echo date("d/m/Y \a \l\a\s H:i", strtotime($reserva['fecha_inicio'])); ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Hasta:</strong> <?php echo date("d/m/Y \a \l\a\s H:i", strtotime($reserva['fecha_fin'])); ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Coste Total:</strong> <?php echo number_format($reserva['coste_total'], 2, ',', '.'); ?>€
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Reservado el:</strong> <?php echo date("d/m/Y", strtotime($reserva['fecha_creacion'])); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); // ?>
    
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
    <script src="js/main.js"></script> </body>
</html>