<?php
require_once './includes/proteger.php'; //


if (!esAdmin()) { //
    header('Location: index.php');
    exit();
}

require_once './includes/crudReservas.php';
$reservasObj = new Reservas();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";
$error = "";

if ($accion == "eliminar" && $id) {
    if ($reservasObj->eliminarReserva($id)) {
        $mensaje = "Reserva eliminada correctamente.";
    } else {
        $error = "Error al eliminar la reserva.";
    }
    header("Location: reservas.php" . ($error ? "?error=$error" : "?exito=$mensaje"));
    exit();
}

$reservas = $reservasObj->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Reservas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .ftco-section { padding: 3em 0; }
        .table img { width: 100px; height: auto; border-radius: 5px; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>

    <?php include("./includes/menu_admin.php"); // ?>

    <div class="container-fluid ftco-section">
        <div class="row justify-content-center">
            <main class="col-md-11">
                <h2>Todas las Reservas</h2>

                <?php if (isset($_GET['exito'])): ?><div class="alert alert-success"><?php echo htmlspecialchars($_GET['exito']); ?></div><?php endif; ?>
                <?php if (isset($_GET['error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div><?php endif; ?>

                <div class="bg-white p-4 rounded shadow-sm mb-5">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Coche</th>
                                    <th>Imagen</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Coste Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($reservas)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No hay ninguna reserva.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($reservas as $reserva) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($reserva['coche_nombre']); ?></td>
                                        <td><img src="../<?php echo htmlspecialchars($reserva['coche_imagen']); ?>" alt=""></td>
                                        <td><?php echo htmlspecialchars($reserva['usuario_nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($reserva['usuario_correo']); ?></td>
                                        <td><?php echo date("d/m/Y H:i", strtotime($reserva['fecha_inicio'])); ?></td>
                                        <td><?php echo date("d/m/Y H:i", strtotime($reserva['fecha_fin'])); ?></td>
                                        <td><?php echo number_format($reserva['coste_total'], 2, ',', '.'); ?>€</td>
                                        <td>
                                            <a href="reservas.php?accion=eliminar&id=<?php echo $reserva['id_reserva']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres ELIMINAR esta reserva?')">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>