<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once "./includes/crudCiudades.php";
$ciudadObj = new Ciudades();
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

// Eliminar ciudad
if($accion == "eliminar" && $id){
    $ciudadObj->eliminarCiudad($id);
    $mensaje = "Ciudad eliminada correctamente.";
        header("Location: ciudades.php");
    exit();
}

// Preparar datos del formulario
$ciudad = ['ciudad' => '']; // para que el value del formulario salga vacío
if ($accion === "editar" && $id) {
    // guarda los datos de la ciudad seleccionada en $ciudad
    $ciudad = $ciudadObj->getById($id); 
}

// Procesar el formulario de creación o edición de ciudad
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['ciudad'] ?? '';
    
    if ($accion === "crear") {
        $ciudadObj->insertarCiudad($nombre);
    } elseif ($accion === "editar" && $id) {
        $ciudadObj->actualizarCiudad($id, $nombre);
    }
    // Redirigir a la página de ciudades después de guardar
    header("Location: ciudades.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Ciudades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Ciudades</h2>

                <a href="ciudades.php?accion=crear" class="btn btn-success mb-3">Añadir nueva ciudad</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la ciudad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listaCiudades as $ciu) : ?>
                        <tr>
                            <td><?= htmlspecialchars($ciu['ciudad']) ?></td>
                            <td>
                                <a href="ciudades.php?accion=editar&id=<?= $ciu['id'] ?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="ciudades.php?accion=eliminar&id=<?= $ciu['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta ciudad?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <!-- Título dependiendo de si se está creando o editando -->
                    <h3><?= $accion === "crear" ? "Nueva ciudad" : "Editar ciudad" ?></h3>
                    
                    <!-- Formulario para ingresar el nombre de la ciudad -->
                    <form method="post" class="mb-4" style="max-width: 400px;">
                        <div class="mb-2">
                            <label class="form-label">Nombre de la ciudad:</label>
                            <input type="text" name="ciudad" class="form-control"
                            value="<?= htmlspecialchars($ciudad['ciudad']) ?>" required>
                        </div>

                        <!-- Botones para guardar o cancelar -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="ciudades.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>
            </main>
        </div>
    </div>
    
</body>
</html>
