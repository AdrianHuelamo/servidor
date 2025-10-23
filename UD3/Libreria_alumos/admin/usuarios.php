<?php
require_once "./includes/sessions.php";
require_once './includes/crudUsuarios.php';

$usuariosObj = new Usuarios();
$listaUsuarios = $usuariosObj->getAll();

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}


$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";
//eliminar categoria
if($accion == "eliminar" && $id){
    $usuariosObj->eliminarUsuario($id);
    $mensaje = "usuario eliminado correctamente.";
    $_SESSION['mensaje'] = $mensaje;
}

//Preparar datos del formulario
$usuario = ['nombre' => '','apellidos' => '', 'email' => '', 'username' => '', 'password' => '','repeatpassword' => ''];
if ($accion === "editar" && $id) {
    //guarda los datos de la usuario seleccionada en $usuario
    $usuario = $usuariosObj->getById($id); 
}

// Procesar el formulario de creacion o edicion de usuario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $repeatpassword = $_POST['repeatpassword'] ?? '';
    
    if ($accion === "crear") {
        $usuariosObj->insertarUsuario($nombre, $apellidos, $email, $username, $password);
    } elseif ($accion === "editar" && $id) {
        $usuariosObj->actualizarUsuario($id, $nombre, $apellidos, $email, $username);
    } elseif ($accion === 'edit_password' && $id) {
        if($password === $repeatpassword) {
            $usuariosObj->actualizarPassword($id, $password);
        }
    }
    // Redirigir a la pagina de usuarios despues de guardar
    header("Location: usuarios.php");
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
                <h2>Usuarios</h2>

                <a href="usuarios.php?accion=crear" class="btn btn-success mb-3">Añadir Nuevo Usuario</a>

                <div class="alerta">
                    <?php if(!empty($_SESSION['mensaje'])): ?>
                        <p><?php echo $_SESSION['mensaje'];
                        $_SESSION['mensaje']="";?></p>
                    <?php endif; ?>
                </div>
                

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre completo</th>
                            <th>E-mail</th>
                            <th>Username</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listaUsuarios as $user) : ?>
                        <tr>
                            <td><?=$user['nombre'] . " " . $user['apellidos']?></td>
                            <td><?=$user['email']?></td>
                            <td><?=$user['username']?></td>
                            <td>
                                <a href="usuarios.php?accion=editar&id=<?=$user['id']?>" class="btn btn-sm btn-primary">
                                    Editar
                                </a>
                                <a href="usuarios.php?accion=edit_password&id=<?=$user['id']?>" class="btn btn-sm btn-secondary">
                                    Editar Password
                                </a>
                                <?php if($_SESSION['usuario']['id'] !== (int)$user['id']):?>
                                <a href="usuarios.php?accion=eliminar&id=<?=$user['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Estás seguro?')">
                                    Eliminar
                                </a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    
                        <!-- TÃ­tulo dependiendo de si se estÃ¡ creando o editando -->
                        <h3><?= $accion === "crear" ? "Crear Usuario" : "Editar Usuario" ?></h3>
                        
                        <!-- Formulario para ingresar el nombre de la categorÃ­a -->
                        <form method="post" class="mb-4" style="max-width: 400px;">
                            <div class="mb-2">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="nombre" class="form-control"
                                value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
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
                            <?php if ($accion === "crear"): ?>
                                <div class="mb-2">
                                    <label class="form-label">Password:</label>
                                    <input type="text" name="password" class="form-control"
                                    value="<?= htmlspecialchars($usuario['password']) ?>" required>
                                </div>
                            <?php endif; ?>
                            <!-- Botones para guardar o cancelar -->
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    <?php elseif($accion==='edit_password'): ?>
                        <form method="post" class="mb-4" style="max-width: 400px;">
                                <div class="mb-2">
                                    <label class="form-label">Password:</label>
                                    <input type="text" name="password" class="form-control"
                                    value="<?= htmlspecialchars($usuario['password']) ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Repetir Password:</label>
                                    <input type="text" name="repeatpassword" class="form-control"
                                    value="<?= htmlspecialchars($usuario['repeatpassword']) ?>" required>
                                </div>
                            <!-- Botones para guardar o cancelar -->
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    <?php endif; ?>
            </main>
        </div>
    </div>
    
    <?php include("./footer.php"); ?>