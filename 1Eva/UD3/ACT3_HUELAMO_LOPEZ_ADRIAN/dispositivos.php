<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once "cruddispositivos.php";
$dispositivoObj = new Dispositivos();
$dispositivos = $dispositivoObj->getAll();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

if($accion == "eliminar" && $id){
    $dispositivoObj->eliminarDispositivo($id);
    $mensaje = "Dispositivo eliminado correctamente.";
    header("location:dispositivos.php");
    exit();
}

$datos_dispositivo = ['marca' => '',
                'modelo' => '',
                'num_serie' => ''];
if ($accion === "editar" && $id) {
    $datos_dispositivo = $dispositivoObj->getDispositivoById($id); 
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $num_serie = $_POST['num_serie'] ?? '';
    
    if ($accion === "crear") {
        $dispositivoObj->insertarDispositivo($marca, $modelo, $num_serie);
    } elseif ($accion === "editar" && $id) {
        $dispositivoObj->actualizarDispositivo($id, $marca, $modelo, $num_serie);
    }
    header("Location: dispositivos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestion de Dispositivos</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Dispositivos</h2>

                <a href="dispositivos.php?accion=crear" class="btn btn-success mb-3">Añadir nuevo dispositivo</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>num_serie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dispositivos as $dispositivo) : ?>
                        <tr>
                            <td><?=$dispositivo['marca']?></td>
                            <td><?=$dispositivo['modelo']?></td>
                            <td><?=$dispositivo['num_serie']?></td>
                            <td>
                                <a href="dispositivos.php?accion=editar&id=<?=$dispositivo['id_dispositivo']?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="dispositivos.php?accion=eliminar&id=<?=$dispositivo['id_dispositivo']?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estas seguro?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    
                        <h3><?= $accion === "crear" ? "Nuevo dispositivo" : "Editar dispositivo" ?></h3>
          
                        <form method="post" class="mb-4" style="max-width: 400px;">
                            <div class="mb-2">
                                <label class="form-label">Marca:</label>
                                <input type="text" name="marca" class="form-control"
                                value="<?= htmlspecialchars($datos_dispositivo['marca']) ?>" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Modelo:</label>
                                <input type="text" name="modelo" class="form-control"
                                value="<?= htmlspecialchars($datos_dispositivo['modelo']) ?>" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Número de serie:</label>
                                <input type="text" name="num_serie" class="form-control"
                                value="<?= htmlspecialchars($datos_dispositivo['num_serie']) ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="dispositivos.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    <?php endif; ?>
            </main>
        </div>
    </div>