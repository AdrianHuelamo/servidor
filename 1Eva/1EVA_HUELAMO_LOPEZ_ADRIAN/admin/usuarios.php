<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./includes/crudUsuarios.php";
require_once "./includes/sessions.php";

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$usuarioObj = new Usuarios();
//listar todos los usuarios para cargar la tabla principal
$listaUsuarios = $usuarioObj->showUsuarios();

//obtener accion e ID de URL 
$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";
$mostrar_form = true;
$mensaje_error = "";

//eliminar
if ($accion === "eliminar" && $id) {
    $usuarioObj->eliminarUsuario($id);
    $mensaje = "Eliminado correctamente";
    //redirección a usurios.php
    header("location:usuarios.php");
    exit();
}

//rellenar el value del formulario (vacío o con el dato del usuario si accion es editar)
if ($accion === 'crear' || ($accion === 'editar' && $id)) {
    if ($accion === 'crear') {
        $usuario = [
            'nombre' => '',
            'apellidos' => '',
            'email' => '',
            'username' => ''
        ];
    }
    if ($accion === "editar" && $id) {
        $usuario = $usuarioObj->getById($id);
    }
    //procesar form (añadir o editar libro)
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        if($accion === "crear"){
            $password_nueva = $_POST['password_nueva'];
            $password_repetida = $_POST['password_repetida'];
            if($password_nueva === $password_repetida){
                $password = password_hash($password_nueva,PASSWORD_DEFAULT);
                $usuarioObj->insertarUsuario($nombre,$apellidos,$email,$username,$password);
            }else{
                $mensaje_error = "Las contraseñas no coinciden";
            }


        //redirección a usuarios.php
        header("location:usuarios.php");
        exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./menu.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <h2>Usuarios</h2>

                <?php if ($mensaje) : ?>
                    <div class="alert alert-success"><?= $mensaje?></div>
                <?php endif?>

                <?php if ($mensaje_error) : ?>
                    <div class="alert alert-danger"><?= $mensaje_error?></div>
                <?php endif?>

                <a href="usuarios.php?accion=crear" class="btn btn-success mb-3">Añadir nuevo usuario</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaUsuarios as $user): ?>
                            <tr>
                                <td><?= $user['nombre'] ?></td>
                                <td><?= $user['apellidos'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td>
                                    <a href="usuarios.php?accion=editar&id=<?= $user['id'] ?>"
                                        class="btn btn-sm btn-primary">Editar</a>

                                    <a href="usuarios.php?accion=editarPass&id=<?= $user['id'] ?>"
                                        class="btn btn-sm btn-success">Editar Password</a>

                                    <?php if($_SESSION['usuario']['id'] !== (int)$user['id']):?>
                                    <a href="usuarios.php?accion=eliminar&id=<?= $user['id'] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <!-- Título dependiendo de si se está creando o editando -->
                    <h3><?= $accion === "crear" ? "Nuevo Usuario" : "Editar usuario" ?></h3>

                    <form method="post" class="mb-4" style="max-width: 400px;">
                        <div class="mb-2">
                            <label class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control"
                                value="<?= htmlspecialchars( $usuario['nombre']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Apellidos:</label>
                            <input type="text" name="apellidos" class="form-control"
                                value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Email:</label>
                            <input type="text" name="email" class="form-control"
                                value="<?= htmlspecialchars($usuario['email']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Username:</label>
                            <input type="text" name="username" class="form-control"
                                value="<?= htmlspecialchars($usuario['username']) ?>" required>
                        </div>

                        <?php if($accion === "crear") : ?>
                            <div class="mb-2">
                                <label class="form-label">Password nueva:</label>
                                <input type="text" name="password_nueva" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Repetir Password:</label>
                                <input type="text" name="password_repetida" class="form-control">
                            </div>
                        <?php endif?>

                        <!-- Botones para guardar o cancelar -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                    <?php endif; //cerrar if del formulario de crear o editar?>


                    <?php if($accion === "editarPass" && $id && $mostrar_form) : ?>
                        <h3>Editar Password</h3>
                        <form method="post" class="mb-4" style="max-width: 400px;">
                            <div class="mb-2">
                                <label class="form-label">Password nueva:</label>
                                <input type="text" name="password_nueva" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Repetir Password:</label>
                                <input type="text" name="password_repetida" class="form-control">
                            </div>
                            
                            <!-- Botones para guardar o cancelar -->
                            <button type="submit" class="btn btn-primary" name="editar_password">Guardar</button>
                            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    <?php endif?>


                

            </main>
        </div>
    </div>

    <?php include("./footer.php"); ?>