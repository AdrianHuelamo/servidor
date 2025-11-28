<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/database.php'; 

$db = new Connection();
$conn = $db->getConnection(); 

$marcas = [];
$sql_marcas = "SELECT id_marca, nombre FROM marcas ORDER BY nombre ASC";
$resultado_marcas = $conn->query($sql_marcas);
if ($resultado_marcas->num_rows > 0) {
    while($fila = $resultado_marcas->fetch_assoc()) {
        $marcas[] = $fila;
    }
}

$filtro_marca = $_GET['marca'] ?? null;
$filtro_asientos = $_GET['asientos'] ?? null;
$filtro_precio_min = $_GET['precio_min'] ?? null;
$filtro_precio_max = $_GET['precio_max'] ?? null;
$filtro_orden = $_GET['orden'] ?? 'default';

$where_clauses = [];
$params_where = [];
$types_where = "";

if (!empty($filtro_marca) && is_numeric($filtro_marca)) {
    $where_clauses[] = "coches.id_categoria = ?";
    $params_where[] = $filtro_marca;
    $types_where .= "i";
}
if (!empty($filtro_asientos) && is_numeric($filtro_asientos)) {
    $where_clauses[] = "coches.asientos = ?";
    $params_where[] = $filtro_asientos;
    $types_where .= "i";
}
if (!empty($filtro_precio_min) && is_numeric($filtro_precio_min)) {
    $where_clauses[] = "coches.precio_dia >= ?";
    $params_where[] = $filtro_precio_min;
    $types_where .= "i";
}
if (!empty($filtro_precio_max) && is_numeric($filtro_precio_max)) {
    $where_clauses[] = "coches.precio_dia <= ?";
    $params_where[] = $filtro_precio_max;
    $types_where .= "i";
}

$where_sql = empty($where_clauses) ? "" : " WHERE " . implode(" AND ", $where_clauses);

switch ($filtro_orden) {
    case 'precio_asc':
        $order_by_sql = "ORDER BY coches.precio_dia ASC";
        break;
    case 'precio_desc':
        $order_by_sql = "ORDER BY coches.precio_dia DESC";
        break;
    default:
        $order_by_sql = "ORDER BY coches.id_coche DESC";
}

$sql_base = "SELECT coches.*, marcas.nombre AS marca_nombre 
        FROM coches 
        JOIN marcas ON coches.id_categoria = marcas.id_marca 
        $where_sql 
        $order_by_sql";

$perPage = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$count_sql = "SELECT COUNT(*) AS total FROM coches JOIN marcas ON coches.id_categoria = marcas.id_marca $where_sql";
$count_stmt = $conn->prepare($count_sql);
if ($count_stmt === false) {
    die("Error al preparar la consulta de conteo: " . $conn->error);
}
if (!empty($types_where)) {
    $bind_args = array($types_where);
    foreach ($params_where as &$param_ref) {
        $bind_args[] = &$param_ref;
    }
    call_user_func_array(array($count_stmt, 'bind_param'), $bind_args);
    unset($param_ref);
}
$count_stmt->execute();
$count_res = $count_stmt->get_result();
$totalRows = 0;
if ($count_res && $count_res->num_rows > 0) {
    $r = $count_res->fetch_assoc();
    $totalRows = (int)$r['total'];
}
$count_stmt->close();

$totalPages = ($totalRows > 0) ? (int)ceil($totalRows / $perPage) : 1;
if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;

$sql = $sql_base . " LIMIT " . ((int)$offset) . "," . ((int)$perPage);

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

if (!empty($types_where)) {
    $bind_args = array($types_where);
    foreach ($params_where as &$param_ref) {
        $bind_args[] = &$param_ref;
    }
    call_user_func_array(array($stmt, 'bind_param'), $bind_args);
    unset($param_ref);
}

$stmt->execute();
$resultado = $stmt->get_result();

$coches = [];
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $coches[] = $fila;
    }
}

$stmt->close();
$db->closeConnection($conn);

$baseParams = $_GET;
unset($baseParams['page']);

function buildPageUrl($p, $baseParams) {
    $params = $baseParams;
    $params['page'] = $p;
    return 'car.php?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>AlquiLobato - Elige tu Coche</title>
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

    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/sobre-nosotros.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Coches <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Elige tu Coche</h1>
          </div>
        </div>
      </div>
    </section>
		

	<section class="ftco-section bg-light">
    	<div class="container">

            <div class="row mb-5">
                <div class="col-md-12">
                    <form method="GET" action="car.php" class="bg-white p-4 shadow-sm rounded">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="marca">Marca</label>
                                <select name="marca" id="marca" class="form-control">
                                    <option value="">Todas</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?php echo $marca['id_marca']; ?>" <?php if ($filtro_marca == $marca['id_marca']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($marca['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="asientos">Asientos</label>
                                <select name="asientos" id="asientos" class="form-control">
                                    <option value="">Cualquiera</option>
                                    <option value="2" <?php if ($filtro_asientos == '2') echo 'selected'; ?>>2</option>
                                    <option value="4" <?php if ($filtro_asientos == '4') echo 'selected'; ?>>4</option>
                                    <option value="5" <?php if ($filtro_asientos == '5') echo 'selected'; ?>>5</option>
                                    <option value="7" <?php if ($filtro_asientos == '7') echo 'selected'; ?>>7+</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="orden">Ordenar por</label>
                                <select name="orden" id="orden" class="form-control">
                                    <option value="default" <?php if ($filtro_orden == 'default') echo 'selected'; ?>>Defecto (Nuevos)</option>
                                    <option value="precio_asc" <?php if ($filtro_orden == 'precio_asc') echo 'selected'; ?>>Precio: Más barato primero</option>
                                    <option value="precio_desc" <?php if ($filtro_orden == 'precio_desc') echo 'selected'; ?>>Precio: Más caro primero</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="precio_min">Precio Mín.</label>
                                <input type="number" name="precio_min" id="precio_min" class="form-control" placeholder="Min" value="<?php echo htmlspecialchars($filtro_precio_min ?? ''); ?>">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="precio_max">Precio Máx.</label>
                                <input type="number" name="precio_max" id="precio_max" class="form-control" placeholder="Max" value="<?php echo htmlspecialchars($filtro_precio_max ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <button type="submit" class="btn btn-primary py-2 px-4">Filtrar</button>
                                <a href="car.php" class="btn btn-secondary py-2 px-4">Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

    		<div class="row">
                <?php if (count($coches) > 0): ?>
                    <?php foreach ($coches as $coche): ?>
        			<div class="col-md-4">
        				<div class="car-wrap rounded ftco-animate">
                            <a href="car-single.php?id=<?php echo $coche['id_coche']; ?>">
        					    <div class="img rounded d-flex align-items-end" style="background-image: url(<?php echo htmlspecialchars($coche['imagen']); ?>);">
        					    </div>
                            </a>
        					<div class="text">
        						<h2 class="mb-0"><a href="car-single.php?id=<?php echo $coche['id_coche']; ?>"><?php echo htmlspecialchars($coche['nombre']); ?></a></h2>
        						<div class="d-flex mb-3">
    	    						<span class="cat"><?php echo htmlspecialchars($coche['marca_nombre']); ?></span>
    	    						<p class="price ml-auto"><?php echo htmlspecialchars($coche['precio_dia']); ?> €<span>/día</span></p>
        						</div>
                                    <p class="d-flex mb-0 d-block">
                                        <?php if (estaLogueado()): ?>
                                            <a href="reservar.php?id=<?php echo $coche['id_coche']; ?>" class="btn btn-primary py-2 mr-1">Reservar</a>
                                        <?php else: ?>
                                            <a href="login.php?error=1" class="btn btn-primary py-2 mr-1">Reservar</a> 
                                        <?php endif; ?>
                                        <a href="car-single.php?id=<?php echo $coche['id_coche']; ?>" class="btn btn-secondary py-2 ml-1">Detalles</a>
                                    </p>
        					</div>
        				</div>
        			</div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12 text-center">
                            <p>No se encontraron coches con esos filtros.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="row mt-5">
                  <div class="col text-center">
                    <div class="block-27">
                      <ul>
                        <?php
                        if ($page > 1) {
                            $prev = $page - 1;
                            echo '<li><a href="' . htmlspecialchars(buildPageUrl($prev, $baseParams)) . '">&lt;</a></li>';
                        } else {
                            echo '<li class="disabled"><span>&lt;</span></li>';
                        }

                        for ($p = 1; $p <= $totalPages; $p++) {
                            if ($p == $page) {
                                echo "<li class=\"active\"><span>$p</span></li>";
                            } else {
                                echo '<li><a href="' . htmlspecialchars(buildPageUrl($p, $baseParams)) . '">' . $p . '</a></li>';
                            }
                        }

                        // siguiente
                        if ($page < $totalPages) {
                            $next = $page + 1;
                            echo '<li><a href="' . htmlspecialchars(buildPageUrl($next, $baseParams)) . '">&gt;</a></li>';
                        } else {
                            echo '<li class="disabled"><span>&gt;</span></li>';
                        }
                        ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
            
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