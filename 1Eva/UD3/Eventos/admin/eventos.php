<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once "./includes/crudEventos.php";
require_once "./includes/crudCiudades.php";

$eventoObj = new Eventos();
$ciudadObj = new Ciudades();

$listaEventos = $eventoObj->showEventos();
$listaCiudades = $ciudadObj->showCiudades();

/*require_once "./includes/sessions.php";
$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}*/

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

// Eliminar evento
if ($accion === "eliminar" && $id) {
    $eventoObj->eliminarEvento($id);
    $mensaje = "Evento eliminado correctamente.";
        header("Location: eventos.php");
    exit();
}

// Preparar datos del formulario
$evento = [
    'evento' => '',
    'fecha' => '',
    'aforo' => '',
    'id_ciudad' => ''
];

if ($accion === "editar" && $id) {
    $evento = $eventoObj->getById($id);
}

// Procesar el formulario de creación o edición
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['evento'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $aforo = $_POST['aforo'] ?? '';
    $id_ciudad = $_POST['id_ciudad'] ?? '';

    if ($accion === "crear") {
        $eventoObj->insertarEvento($nombre, $fecha, $aforo, $id_ciudad);
    } elseif ($accion === "editar" && $id) {
        $eventoObj->actualizarEvento($id, $nombre, $fecha, $aforo, $id_ciudad);
    }
    header("Location: eventos.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Eventos</h2>

                <a href="eventos.php?accion=crear" class="btn btn-success mb-3">Añadir nuevo evento</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Fecha</th>
                            <th>Aforo</th>
                            <th>Ciudad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaEventos as $ev) : ?>
                        <tr>
                            <td><?= htmlspecialchars($ev['evento']) ?></td>
                            <td><?= htmlspecialchars($ev['fecha']) ?></td>
                            <td><?= htmlspecialchars($ev['aforo']) ?></td>
                            <td><?= htmlspecialchars($ev['ciudad']) ?></td>
                            <td>
                                <a href="eventos.php?accion=editar&id=<?= $ev['id'] ?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="eventos.php?accion=eliminar&id=<?= $ev['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este evento?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <h3><?= $accion === "crear" ? "Nuevo evento" : "Editar evento" ?></h3>

                    <form method="post" class="mb-4" style="max-width: 500px;">
                        <div class="mb-2">
                            <label class="form-label">Nombre del evento:</label>
                            <input type="text" name="evento" class="form-control"
                                value="<?= htmlspecialchars($evento['evento']) ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control"
                                value="<?= htmlspecialchars($evento['fecha']) ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Aforo:</label>
                            <input type="number" name="aforo" class="form-control"
                                value="<?= htmlspecialchars($evento['aforo']) ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Ciudad:</label>
                            <select name="id_ciudad" class="form-select" required>
                                <option value="">-- Selecciona una ciudad --</option>
                                <?php foreach ($listaCiudades as $ciu): ?>
                                    <option value="<?= $ciu['id'] ?>" 
                                        <?= ($ciu['id'] == $evento['id_ciudad']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ciu['ciudad']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="eventos.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>
            </main>
        </div>
    </div>

</body>
</html>
