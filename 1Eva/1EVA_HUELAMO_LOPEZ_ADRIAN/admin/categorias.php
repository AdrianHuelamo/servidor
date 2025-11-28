<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("./includes/sessions.php"); 
require_once("./includes/crudCategorias.php"); 

$sesion = new Sessions(); 
if (!$sesion->comprobarSesion()) { 
    header("Location: ../login.php"); 
    exit(); 
} 

$categoriaObj = new Categorias();
//listar todas las categorias para cargar en la tabla
$listaCategorias = $categoriaObj->showCategorias();

//obtener accion e ID de URL 
$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

//eliminar
if ($accion === "eliminar" && $id){
    $categoriaObj->eliminarCategoria($id);
    $mensaje = "Eliminada correctamente";
    //redirección a categorias.php
    header("location:categorias.php");
    exit();
}

//rellenar el value del formulario (vacío o con la categoria si accion es editar)
$categoria = ['categoria' => '']; //si pulsamos en crear

if ($accion === "editar" && $id){
    $categoria = $categoriaObj->getById($id);
}

//procesar form (añadir o editar categoria)
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['categoria']; //name del formulario del campo categoria
    if($accion === "crear"){
        $categoriaObj->insertarCategoria($nombre);
    }elseif($accion === "editar" && $id){
        $categoriaObj->actualizarCategoria($id,$nombre);
    }
    //redirección a categorias.php
    header("location:categorias.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Categorías</h2>

                <a href="categorias.php?accion=crear" class="btn btn-success mb-3">Añadir nueva categoría</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaCategorias as $cat) : ?>
                        <tr>
                            <td><?=$cat['categoria']?></td>
                            <td>
                                <a href="categorias.php?accion=editar&id=<?=$cat['id_categoria']?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="categorias.php?accion=eliminar&id=<?=$cat['id_categoria']?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?> 
                    <!-- Título dependiendo de si se está creando o editando --> 
                    <h3><?= $accion === "crear" ? "Nueva categoría" : "Editar categoría" ?></h3> 
                    <!-- Formulario para ingresar el nombre de la categoría --> 
                    <form method="post" class="mb-4" style="max-width: 400px;"> 
                        <div class="mb-2"> 
                            <label class="form-label">Nombre de la categoría:</label> 
                            <input type="text" name="categoria" class="form-control" value="<?= htmlspecialchars($categoria['categoria']) ?>" required> 
                        </div> 
                        <!-- Botones para guardar o cancelar --> 
                        <button type="submit" class="btn btn-primary">Guardar</button> 
                        <a href="categorias.php" class="btn btn-secondary">Cancelar</a> 
                    </form> 
                <?php endif; ?> 
                    
            </main>
        </div>
    </div>

    <?php include("./footer.php"); ?>