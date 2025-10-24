<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once "./includes/sessions.php";
$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

require_once "./includes/crudCategorias.php";
$categoriaObj = new Categorias();
$listaCategorias = $categoriaObj->showCategorias();

require_once "./includes/crudLibros.php";
$libroObj = new Libros();
$libros = $libroObj->getAll();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

if($accion == "eliminar" && $id){
    $libroObj->eliminarLibro($id);
    $mensaje = "Libro eliminada correctamente.";
    header("location:libros.php");
    exit();
}


$datos_libro = ['titulo' => '',
                'autor' => '',
                'id_categoria' => '',
                'precio' => '',
                'fecha' => date("Y-m-d"),
                'portada' => ''];
if ($accion === "editar" && $id) {
    $datos_libro = $libroObj->getLibroById($id); 
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $id_categoria = $_POST['id_categoria'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $portada = $_POST['portada'] ?? '';
    
    if ($accion === "crear") {
        $libroObj->insertarLibro($titulo, $autor, $id_categoria, $precio, $fecha,$portada);
    } elseif ($accion === "editar" && $id) {
        $libroObj->actualizarLibro($id, $titulo, $autor, $id_categoria, $precio, $fecha, $portada);
    }
    header("Location: libros.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestion de Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Libros</h2>

                <a href="libros.php?accion=crear" class="btn btn-success mb-3">Añadir nuevo libro</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                            <th>Portada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($libros as $libro) : ?>
                        <tr>
                            <td><?=$libro['titulo']?></td>
                            <td><?=$libro['autor']?></td>
                            <td><?=$libro['categoria']?></td>
                            <td><?=$libro['precio']?></td>
                            <td><?= date("d-m-Y", strtotime($libro['fecha']))?></td>
                            <td>
                                <img src="../portadas/<?=$libro['portada']?>" width="50">
                            </td>
                            <td>
                                <a href="libros.php?accion=editar&id=<?=$libro['id_libro']?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="libros.php?accion=eliminar&id=<?=$libro['id_libro']?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estas seguro?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    
                        <h3><?= $accion === "crear" ? "Nuevo libro" : "Editar libro" ?></h3>
          
                        <form method="post" class="mb-4" style="max-width: 400px;">
                            <div class="mb-2">
                                <label class="form-label">Título:</label>
                                <input type="text" name="titulo" class="form-control"
                                value="<?= htmlspecialchars($datos_libro['titulo']) ?>" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">autor:</label>
                                <input type="text" name="autor" class="form-control"
                                value="<?= htmlspecialchars($datos_libro['autor']) ?>" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Categoria:</label>
                                <select name="id_categoria" class="form-control" required>
                                    <option value="">-- Selecciona una categoría --</option>
                                    <?php foreach ($listaCategorias as $cat): ?>
                                        <option value="<?= $cat['id_categoria'] ?>" <?= ($datos_libro['id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['categoria']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Precio:</label>
                                <input type="text" name="precio" class="form-control"
                                value="<?= htmlspecialchars($datos_libro['precio']) ?>" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Fecha:</label>
                                <input type="date" name="fecha" class="form-control"
                                value="<?= date("Y-m-d", strtotime(($datos_libro['fecha']))) ?>" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Portada:</label>
                                <input type="file" name="portada" class="form-control"
                                value="<?= htmlspecialchars($datos_libro['portada']) ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="libros.php" class="btn btn-secondary">Cancelar</a>

                            <?php if($accion==="editar") {?>
                                <div class="mb-2">
                                    <img src="../portadas/<?php echo $datos_libro['portada']?>" width="100" alt="Imagen portada">
                                </div>
                                <?php } ?>
                        </form>
                    <?php endif; ?>
            </main>
        </div>
    </div>
    
    <?php include("./footer.php"); ?>