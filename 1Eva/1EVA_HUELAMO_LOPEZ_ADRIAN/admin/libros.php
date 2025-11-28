<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("./includes/sessions.php");
require_once("./includes/crudCategorias.php");
require_once("./includes/crudLibros.php");
require_once("./includes/crudEditoriales.php");

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$categoriaObj = new Categorias();
//listar todas las categorias para cargar en el select
$listaCategorias = $categoriaObj->showCategorias();

$editorialObj = new Editoriales();
//listar todas las categorias para cargar en el select
$listaEditoriales = $editorialObj->showEditoriales();

$libroObj = new Libros();
$listaLibros = $libroObj->getAll(); //para rellenar la tabla

//obtener accion e ID de URL 
$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

//eliminar
if ($accion === "eliminar" && $id) {
    $libroObj->eliminarLibro($id);
    $mensaje = "Eliminado correctamente";
    //redirección a libros.php
    header("location:libros.php");
    exit();
}


//rellenar el value del formulario (vacío o con la categoria si accion es editar)
if ($accion === 'crear' || ($accion === 'editar' && $id)) {
    if ($accion === 'crear') {
        $libros = [
            'titulo' => '',
            'autor' => '',
            'precio' => '',
            'fecha' => date('Y-m-d'),
            'visitas' => '',
            'portada' => '',
            'id_categoria' => '',
            'id_editorial' => ''
        ];
    }
    if ($accion === "editar" && $id) {
        $libros = $libroObj->getLibroById($id);
        $libros['fecha'] = date('Y-m-d', strtotime($libros['fecha']));
    }
}

//procesar form (añadir o editar libro)
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $precio = $_POST['precio'];
    $id_categoria = $_POST['categoria'];
    $id_editorial = $_POST['editorial'];
    $fecha = $_POST['fecha'];
    $portada = $_POST['portada']; //name del formulario

    if($accion === "crear"){
        $libroObj->insertarLibro($titulo,$autor,$id_categoria,$id_editorial,$precio,$fecha,$portada);
    }elseif($accion === "editar" && $id){
        $libroObj->actualizarLibro($id,$titulo,$autor,$id_categoria,$id_editorial,$precio,$fecha,$portada);
    }
    //redirección a libros.php
    header("location:libros.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Libros</title>
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
                            <th>Titulo</th>
                            <th>Autor</th>
                            <th>Categoria</th>
                            <th>Editorial</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                            <th>Portada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaLibros as $libro): ?>
                            <tr>
                                <td><?= $libro['titulo'] ?></td>
                                <td><?= $libro['autor'] ?></td>
                                <td><?= $libro['categoria'] ?></td>
                                <td><?= $libro['nombre_editorial'] ?></td>
                                <td><?= $libro['precio'] ?></td>
                                <td><?= date("d-m-Y", strtotime($libro['fecha'])) ?></td>
                                <td><?= $libro['portada'] ?></td>
                                <td>
                                    <a href="libros.php?accion=editar&id=<?= $libro['id_libro'] ?>"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <a href="libros.php?accion=eliminar&id=<?= $libro['id_libro'] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <!-- Título dependiendo de si se está creando o editando -->
                    <h3><?= $accion === "crear" ? "Nuevo libro" : "Editar libro" ?></h3>

                    <form method="post" class="mb-4" style="max-width: 400px;">
                        <div class="mb-2">
                            <label class="form-label">Titulo:</label>
                            <input type="text" name="titulo" class="form-control"
                                value="<?= htmlspecialchars($libros['titulo']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Autor:</label>
                            <input type="text" name="autor" class="form-control"
                                value="<?= htmlspecialchars($libros['autor']) ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Categoria:</label>
                            <select name="categoria" class="form-select">
                                <?php foreach ($listaCategorias as $cat): ?>
                                    <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $libros['id_categoria'] ? 'selected' : '' ?> >
                                            <?= $cat['categoria'] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Editorial:</label>
                            <select name="editorial" class="form-select">
                                <?php foreach ($listaEditoriales as $edt): ?>
                                    <option value="<?= $edt['id_editorial'] ?>" <?= $edt['id_editorial'] == $libros['id_editorial'] ? 'selected' : '' ?> >
                                            <?= $edt['nombre_editorial'] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Precio:</label>
                            <input type="text" name="precio" class="form-control"
                                value="<?= htmlspecialchars($libros['precio']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control"
                                value="<?= htmlspecialchars($libros['fecha']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Portada:</label>
                            <input type="text" name="portada" class="form-control"
                                value="<?= htmlspecialchars($libros['portada']) ?>" required>
                        </div>
                        <!-- Botones para guardar o cancelar -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="libros.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php endif; ?>

            </main>
        </div>
    </div>

    <?php include("./footer.php"); ?>