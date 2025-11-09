<?php
require_once 'admin/includes/auth.php'; 
require_once 'admin/includes/database.php'; 

if (!estaLogueado()) { 
    header('Location: login.php?error=1'); 
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: car.php'); 
    exit;
}
$id_coche = $_GET['id'];

$db = new Connection();
$conn = $db->getConnection();

$sql = "SELECT c.*, m.nombre AS marca_nombre 
        FROM coches c 
        JOIN marcas m ON c.id_categoria = m.id_marca 
        WHERE c.id_coche = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_coche);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    header('Location: car.php'); 
    exit;
}
$coche = $resultado->fetch_assoc();
$stmt->close();
$db->closeConnection($conn);

$error_msg = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'conflicto') {
        $error_msg = "¡Ocupado! Ese coche ya está reservado en las fechas seleccionadas. Por favor, elige otras.";
    } elseif ($_GET['error'] == 'campos_vacios') {
        $error_msg = "Error: Debes rellenar todos los campos de fecha y hora.";
    } elseif ($_GET['error'] == 'fechas') {
        $error_msg = "Error: Las fechas no son válidas. La fecha de fin debe ser posterior a la de inicio o el formato (dd/mm/aaaa) es incorrecto.";
    } elseif ($_GET['error'] == 'general') {
        $error_msg = "Error al procesar la reserva. Inténtalo de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Confirmar Reserva - AlquiLobato</title>
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
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Reservar <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Confirmar Reserva</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-car-details">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ftco-animate">
                    <div class="car-details">
                        <div class="img rounded" style="background-image: url(<?php echo htmlspecialchars($coche['imagen']); ?>);"></div>
                        <div class="text text-center">
                            <span class="subheading"><?php echo htmlspecialchars($coche['marca_nombre']); ?></span>
                            <h2><?php echo htmlspecialchars($coche['nombre']); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pills">
                            <div class="bd-example bd-example-tabs">
                                <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Precios</a>
                                    </li>
                                </ul>
                                </div>
                                <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Precio por Hora
                                            <span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($coche['precio_hora']); ?>€</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Precio por Día
                                            <span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($coche['precio_dia']); ?>€</span>
                                        </li>
         
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Precio por Mes
                                            <span class="badge badge-primary badge-pill"><?php echo htmlspecialchars($coche['precio_mes']); ?>€</span>
                                        </li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 ftco-animate">
                    <div class="bg-light p-4 p-md-5 rounded">
                        <h3 class="mb-4">Elige las fechas</h3>
                        
                        <?php if ($error_msg): ?>
                            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="proceso_reserva.php">
                            <input type="hidden" name="id_coche" value="<?php echo $coche['id_coche']; ?>">
                            
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Recogida</label>
                                <input type="text" name="fecha_inicio_fecha" class="form-control" id="reserva_fecha_inicio" placeholder="Fecha">
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio_hora">Hora de Recogida</label>
                                <input type="text" name="fecha_inicio_hora" class="form-control" id="reserva_hora_inicio" placeholder="Hora">
                            </div>

                            <hr class="my-4">

                            <div class="form-group">
                                <label for="fecha_fin_fecha">Fecha de Entrega</label>
                                <input type="text" name="fecha_fin_fecha" class="form-control" id="reserva_fecha_fin" placeholder="Fecha">
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin_hora">Hora de Entrega</label>
                                <input type="text" name="fecha_fin_hora" class="form-control" id="reserva_hora_fin" placeholder="Hora">
                            </div>
                            
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Confirmar y Reservar</button>
                            </div>
                        </form>
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
    <script src="js/main.js"></script>
    
</body>
</html>