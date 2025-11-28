<?php
require_once './includes/proteger.php';

if (!esAdmin()) {
    header('Location: index.php');
    exit();
}

require_once './includes/crudMarcas.php';
require_once './includes/database.php';

$db = new Connection();
$conn = $db->getConnection();
$marcasObj = new Marcas();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";
$error = "";

if ($accion == "eliminar" && $id) {
    try {
        if ($marcasObj->eliminarMarca($conn, $id)) {
            $mensaje = "Marca eliminada correctamente.";
        } else {
            $error = "Error al eliminar la marca.";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    header("Location: marcas.php" . ($error ? "?error=" . urlencode($error) : "?exito=" . urlencode($mensaje)));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $accion_post = $_POST['accion'] ?? 'crear';
    $id_marca = $_POST['id_marca'] ?? null;

    if (empty($nombre)) {
        $error = "El nombre no puede estar vacío.";
        header("Location: marcas.php?accion=$accion_post" . ($id_marca ? "&id=$id_marca" : "") . "&error=" . urlencode($error));
        exit();
    }

    if ($accion_post === "crear") {
        if ($marcasObj->insertarMarca($conn, $nombre)) {
            $mensaje = "Marca creada con éxito.";
        } else {
            $error = "Error al crear la marca.";
        }
    } elseif ($accion_post === "editar" && $id_marca) {
        if ($marcasObj->actualizarMarca($conn, $id_marca, $nombre)) {
            $mensaje = "Marca actualizada con éxito.";
        } else {
            $error = "Error al actualizar la marca.";
        }
    }
    
    header("Location: marcas.php" . ($error ? "?error=" . urlencode($error) : "?exito=" . urlencode($mensaje)));
    exit();
}

$marcas = $marcasObj->getAll($conn);

$datos_marca = ['id_marca' => '', 'nombre' => ''];
if ($accion === "editar" && $id) {
    $datos_marca = $marcasObj->getMarcaById($conn, $id);
    if (!$datos_marca) {
        header("Location: marcas.php?error=Marca no encontrada");
        exit();
    }
} elseif ($accion === "crear") {
    $datos_marca = ['id_marca' => '', 'nombre' => ''];
}

$db->closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Marcas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .ftco-section { padding: 3em 0; }
        .table-responsive { overflow-x: auto; }
        .form-crud { max-width: 600px; margin: 20px auto; }
    </style>
</head>
<body>

    <?php include("./includes/menu_admin.php"); ?>

    <div class="container ftco-section">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Gestión de Marcas</h2>

                <?php if (isset($_GET['exito'])): ?><div class="alert alert-success"><?php echo htmlspecialchars($_GET['exito']); ?></div><?php endif; ?>
                <?php if (isset($_GET['error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div><?php endif; ?>

                <a href="marcas.php?accion=crear" class="btn btn-success mb-3">Añadir Nueva Marca</a>

                <div class="bg-white p-4 p-md-5 rounded shadow-sm mb-5">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($marcas)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay marcas registradas.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach($marcas as $marca) : ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo $marca['id_marca']; ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($marca['nombre']); ?></td>
                                        <td class="text-center align-middle">
                                            <a href="marcas.php?accion=editar&id=<?php echo $marca['id_marca']; ?>" class="btn btn-sm btn-primary">
                                                Editar
                                            </a>
                                            <a href="marcas.php?accion=eliminar&id=<?php echo $marca['id_marca']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro? No podrás eliminarla si hay coches usándola.')">
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

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm form-crud">
                        <h3><?php echo $accion === "crear" ? "Añadir Marca" : "Editar Marca"; ?></h3>
                        <form method="post" action="marcas.php">
                            <input type="hidden" name="accion" value="<?php echo $accion; ?>">
                            <input type="hidden" name="id_marca" value="<?php echo htmlspecialchars($datos_marca['id_marca']); ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Marca</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($datos_marca['nombre']); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <?php echo $accion === "crear" ? "Guardar Marca" : "Actualizar Marca"; ?>
                            </button>
                            <a href="marcas.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                <?php endif; ?>

            </main>
        </div>
    </div>
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/admin-scroll.js"></script>

</body>
</html>