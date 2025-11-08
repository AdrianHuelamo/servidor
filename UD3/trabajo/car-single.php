<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/auth.php';
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

// Coches relacionados
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
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($coche['marca_nombre'] . ' ' . $coche['modelo']); ?> - AlquiLobato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tus otros CSS -->
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($coche['imagen']); ?>" 
                     alt="<?php echo htmlspecialchars($coche['marca_nombre'] . ' ' . $coche['modelo']); ?>" 
                     class="img-fluid">
            </div>
            
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($coche['marca_nombre'] . ' ' . $coche['modelo']); ?></h1>
                <p class="lead"><?php echo htmlspecialchars($coche['descripcion']); ?></p>
                
                <div class="my-4">
                    <h3>€<?php echo number_format($coche['precio_dia'], 2); ?> / día</h3>
                </div>
                
                <div class="mb-3">
                    <strong>Año:</strong> <?php echo htmlspecialchars($coche['year']); ?><br>
                    <strong>Transmisión:</strong> <?php echo htmlspecialchars($coche['transmision']); ?><br>
                    <strong>Plazas:</strong> <?php echo htmlspecialchars($coche['plazas']); ?>
                </div>
                
                <?php if (estaLogueado()): ?>
                    <!-- Usuario logueado: puede reservar -->
                    <a href="reservar.php?id=<?php echo $id_coche; ?>" class="btn btn-success btn-lg w-100">
                        ✅ Reservar Ahora
                    </a>
                    <p class="text-muted mt-2 text-center">
                        <small>Reservando como: <strong><?php echo getNombreUsuario(); ?></strong></small>
                    </p>
                <?php else: ?>
                    <!-- Usuario NO logueado: redirigir al login -->
                    <a href="login.php?error=1&redirect=car-single.php?id=<?php echo $id_coche; ?>" 
                       class="btn btn-warning btn-lg w-100">
                        🔒 Inicia sesión para reservar
                    </a>
                    <p class="text-muted mt-2 text-center">
                        <small>Necesitas una cuenta para reservar coches</small>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Coches relacionados -->
        <?php if (count($coches_relacionados) > 0): ?>
        <div class="row mt-5">
            <div class="col-12">
                <h3>Coches similares</h3>
            </div>
            <?php foreach ($coches_relacionados as $coche_rel): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($coche_rel['imagen']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($coche_rel['marca_nombre'] . ' ' . $coche_rel['modelo']); ?>">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($coche_rel['marca_nombre'] . ' ' . $coche_rel['modelo']); ?>
                        </h5>
                        <p class="card-text">€<?php echo number_format($coche_rel['precio_dia'], 2); ?> / día</p>
                        <a href="car-single.php?id=<?php echo $coche_rel['id_coche']; ?>" 
                           class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
