<?php
require_once './includes/proteger.php';

if (!esAdmin()) {
    header('Location: index.php');
    exit();
}

require_once './includes/crudUsuarios.php';
require_once './includes/database.php';

$db = new Connection();
$conn = $db->getConnection();
$userObj = new Usuarios();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$id_admin_actual = getUserId();

$mensaje = "";
$error = "";

if ($accion == "eliminar" && $id) {
    if ($userObj->eliminarUsuario($conn, $id, $id_admin_actual)) {
        $mensaje = "Usuario eliminado correctamente.";
    } else {
        $error = "Error al eliminar el usuario (no se puede eliminar a usted mismo o a un super-admin).";
    }
    header("Location: usuarios.php" . ($error ? "?error=$error" : "?exito=$mensaje"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['accion'] === "editar_rol") {
    $id_usuario_post = $_POST['id_usuario'];
    $nuevo_rol = $_POST['nuevo_rol'];
    
    if ($userObj->cambiarRol($conn, $id_usuario_post, $nuevo_rol, $id_admin_actual)) {
        $mensaje = "Rol actualizado con éxito.";
    } else {
        $error = "Error al actualizar el rol.";
    }
    header("Location: usuarios.php?exito=$mensaje");
    exit();
}

$usuarios = $userObj->getAll($conn, $id_admin_actual);

$datos_usuario = null;
if ($accion === "editar" && $id) {
    $datos_usuario = $userObj->getUserById($conn, $id);
    if (!$datos_usuario || $datos_usuario['id_usuario'] == $id_admin_actual || $datos_usuario['rol'] == 'super') {
        header("Location: usuarios.php?error=No puede editar a este usuario.");
        exit();
    }
}

$db->closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .ftco-section { padding: 3em 0; }
        .form-crud { max-width: 600px; margin: 20px auto; }
        .table-responsive { overflow-x: auto; }
        .badge.bg-warning { color: #000 !important; }
        .badge.bg-info { color: #fff !important; }
    </style>
</head>
<body>

    <?php include("./includes/menu_admin.php"); ?>

    <div class="container ftco-section">
        <div class="row justify-content-center">
            <main class="col-md-11">
                <h2>Gestión de Usuarios</h2>
                <p>Aquí puedes cambiar el rol o eliminar a los usuarios. Los 'super-admin' y tu propia cuenta no aparecen en esta lista por seguridad.</p>

                <?php if (isset($_GET['exito'])): ?><div class="alert alert-success"><?php echo htmlspecialchars($_GET['exito']); ?></div><?php endif; ?>
                <?php if (isset($_GET['error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div><?php endif; ?>

                <div class="bg-white p-4 p-md-5 rounded shadow-sm mb-5">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Rol Actual</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay otros usuarios para gestionar.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach($usuarios as $usuario) : ?>
                                    <?php
                                        $rol_clase = 'bg-primary';
                                        if ($usuario['rol'] == 'admin') {
                                            $rol_clase = 'bg-info';
                                        } elseif ($usuario['rol'] == 'editor') {
                                            $rol_clase = 'bg-warning text-dark';
                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($usuario['username']); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                        <td class="text-center align-middle"><span class="badge <?php echo $rol_clase; ?> p-2"><?php echo htmlspecialchars(ucfirst($usuario['rol'])); ?></span></td>
                                        <td class="text-center align-middle">
                                            <a href="usuarios.php?accion=editar&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-primary">
                                                Editar Rol
                                            </a>
                                            <a href="usuarios.php?accion=eliminar&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro? Se borrarán todos los datos y reservas de este usuario.')">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($accion === "editar" && $datos_usuario): ?>
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm form-crud">
                        <h3>Editar Rol de: <?php echo htmlspecialchars($datos_usuario['nombre']); ?></h3>
          
                        <form method="post" action="usuarios.php">
                            <input type="hidden" name="accion" value="editar_rol">
                            <input type="hidden" name="id_usuario" value="<?php echo $datos_usuario['id_usuario']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Nuevo Rol:</label>
                                <select name="nuevo_rol" class="form-control" required>
                                    <option value="user" <?php if($datos_usuario['rol'] == 'user') echo 'selected'; ?>>User</option>
                                    <option value="editor" <?php if($datos_usuario['rol'] == 'editor') echo 'selected'; ?>>Editor</option>
                                    <option value="admin" <?php if($datos_usuario['rol'] == 'admin') echo 'selected'; ?>>Admin</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Rol</button>
                            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                <?php endif; ?>

            </main>
        </div>
    </div>
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/admin-scroll.js"></script>

</body>
</html>