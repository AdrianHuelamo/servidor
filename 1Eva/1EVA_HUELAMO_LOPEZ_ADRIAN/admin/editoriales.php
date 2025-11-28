<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("./includes/sessions.php"); 
require_once("./includes/crudEditoriales.php"); 

$sesion = new Sessions(); 
if (!$sesion->comprobarSesion()) { 
    header("Location: ../login.php"); 
    exit(); 
} 

$editorialObj = new Editoriales();
//listar todas las categorias para cargar en la tabla
$listaEditoriales = $editorialObj->showEditoriales();

//obtener accion e ID de URL 
$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

//eliminar
if ($accion === "eliminar" && $id){
    $editorialObj->eliminarEditorial($id);
    $mensaje = "Eliminada correctamente";
    //redirección a categorias.php
    header("location:editoriales.php");
    exit();
}

//rellenar el value del formulario (vacío o con la categoria si accion es editar)
if ($accion === 'crear' || ($accion === 'editar' && $id)) {
    if ($accion === 'crear') {
        $editoriales = [
            'nombre_editorial' => '',
            'telefono' => '',
            'email' => '',
        ];
    }
    if ($accion === "editar" && $id) {
        $editoriales = $editorialObj->getById($id);
    }
}

//procesar form (añadir o editar categoria)
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre_editorial'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    if($accion === "crear"){
        $editorialObj->insertarEditorial($nombre,$telefono,$email);
    }elseif($accion === "editar" && $id){
        $editorialObj->actualizarEditorial($id,$nombre,$telefono,$email);
    }
    //redirección a categorias.php
    header("location:editoriales.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Editoriales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Editoriales</h2>

                <a href="editoriales.php?accion=crear" class="btn btn-success mb-3">Añadir nueva editorial</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la editorial</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaEditoriales as $edt) : ?>
                        <tr>
                            <td><?=$edt['nombre_editorial']?></td>
                            <td><?=$edt['telefono']?></td>
                            <td><?=$edt['email']?></td>
                            <td>
                                <a href="editoriales.php?accion=editar&id=<?=$edt['id_editorial']?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="editoriales.php?accion=eliminar&id=<?=$edt['id_editorial']?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?> 
                    <!-- Título dependiendo de si se está creando o editando --> 
                    <h3><?= $accion === "crear" ? "Nueva editorial" : "Editar editorial" ?></h3> 
                    <!-- Formulario para ingresar el nombre de la categoría --> 
                    <form method="post" class="mb-4" style="max-width: 400px;"> 
                        <div class="mb-2"> 
                            <label class="form-label">Nombre de la editorial:</label> 
                            <input type="text" name="nombre_editorial" class="form-control" value="<?= htmlspecialchars($editoriales['nombre_editorial']) ?>" required> 
                        </div>
                        <div class="mb-2"> 
                            <label class="form-label">Teléfono:</label> 
                            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($editoriales['telefono']) ?>" required> 
                        </div> 
                        <div class="mb-2"> 
                            <label class="form-label">Email:</label> 
                            <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($editoriales['email']) ?>" required> 
                        </div> 
                        <!-- Botones para guardar o cancelar --> 
                        <button type="submit" class="btn btn-primary">Guardar</button> 
                        <a href="editoriales.php" class="btn btn-secondary">Cancelar</a> 
                    </form> 
                <?php endif; ?> 
                    
            </main>
        </div>
    </div>

    <?php include("./footer.php"); ?>