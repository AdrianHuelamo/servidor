<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once "./includes/crudOrganizadores.php";
$organizadorObj = new Organizadores();
$listaOrganizadores = $organizadorObj->showOrganizadores();

/*require_once "./includes/sessions.php";
$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}*/

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

// Eliminar organizador
if($accion == "eliminar" && $id){
    $organizadorObj->eliminarorganizador($id);
    $mensaje = "organizador eliminado correctamente.";
        header("Location: Organizadores.php");
    exit();
}

// Preparar datos del formulario
$organizador = [
    'nombre' => '',
    'email' => '']; // para que el value del formulario salga vacío
if ($accion === "editar" && $id) {
    // guarda los datos de la organizador seleccionada en $organizador
    $organizador = $organizadorObj->getById($id); 
}

// Procesar el formulario de creación o edición de organizador
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if ($accion === "crear") {
        $organizadorObj->insertarorganizador($nombre, $email);
    } elseif ($accion === "editar" && $id) {
        $organizadorObj->actualizarorganizador($id, $nombre, $email);
    }
    // Redirigir a la página de Organizadores después de guardar
    header("Location: Organizadores.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Organizadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Organizadores</h2>

                <a href="Organizadores.php?accion=crear" class="btn btn-success mb-3">Añadir nueva organizador</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del organizador</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listaOrganizadores as $org) : ?>
                        <tr>
                            <td><?= htmlspecialchars($org['nombre']) ?></td>
                            <td><?= htmlspecialchars($org['email']) ?></td>
                            <td>
                                <a href="Organizadores.php?accion=editar&id=<?= $org['id'] ?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="Organizadores.php?accion=eliminar&id=<?= $org['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta organizador?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <!-- Título dependiendo de si se está creando o editando -->
                    <h3><?= $accion === "crear" ? "Nueva organizador" : "Editar organizador" ?></h3>
                    
                    <!-- Formulario para ingresar el nombre del organizador -->
                    <form method="post" class="mb-4" style="max-width: 400px;">
                        <div class="mb-2">
                            <label class="form-label">Nombre del organizador:</label>
                            <input type="text" name="nombre" class="form-control"
                            value="<?= htmlspecialchars($organizador['nombre']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Email del organizador:</label>
                            <input type="text" name="email" class="form-control"
                            value="<?= htmlspecialchars($organizador['email']) ?>" required>
                        </div>

                        <!-- Botones para guardar o cancelar -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="Organizadores.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>
            </main>
        </div>
    </div>
    
</body>
</html>
