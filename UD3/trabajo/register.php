<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/auth.php';
require_once 'admin/includes/database.php';

$mensaje_info = '';
$error = '';
$success = '';

if (estaLogueado()) {
    $mensaje_info = "Ya tienes una cuenta activa como " . getNombreUsuario();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !estaLogueado()) {
    $nombre = trim($_POST['nombre']);
    $username = trim($_POST['username']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    if (empty($nombre) || empty($username) || empty($correo) || empty($telefono) || empty($password) || empty($password_confirm)) {
        $error = "Todos los campos son obligatorios";
    } elseif ($password !== $password_confirm) {
        $error = "Las contraseñas no coinciden";
    } elseif (strlen($password) < 4) {
        $error = "La contraseña debe tener al menos 4 caracteres";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo no es válido";
    } else {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "SELECT id_usuario FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "El nombre de usuario ya está en uso";
        } else {
            $sql_correo = "SELECT id_usuario FROM usuarios WHERE correo = ?";
            $stmt_correo = $conn->prepare($sql_correo);
            $stmt_correo->bind_param("s", $correo);
            $stmt_correo->execute();
            $result_correo = $stmt_correo->get_result();

            if ($result_correo->num_rows > 0) {
                $error = "El correo ya está registrado";
            } else {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                $sql_insert = "INSERT INTO usuarios (nombre, username, correo, telefono, password, rol) VALUES (?, ?, ?, ?, ?, 'user')";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("sssss", $nombre, $username, $correo, $telefono, $password_hash);

                if ($stmt_insert->execute()) {
                    $success = "¡Registro exitoso! Redirigiendo al login...";
                    header("refresh:2;url=login.php");
                } else {
                    $error = "Error al registrar: " . $conn->error;
                }
                $stmt_insert->close();
            }
            $stmt_correo->close();
        }
        $stmt->close();
        $db->closeConnection($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Crear Cuenta - AlquiLobato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Todos los estilos CSS usados en la web -->
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css" />
    <link rel="stylesheet" href="css/animate.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/aos.css" />
    <link rel="stylesheet" href="css/ionicons.min.css" />
    <link rel="stylesheet" href="css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="css/jquery.timepicker.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/icomoon.css" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
        body {
            background: url('images/login-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
               
        .login-wrap {
            margin-top: 30px; 
            background: rgba(255,255,255,0.95);
            box-shadow: 0 4px 32px rgba(0,0,0,0.1);
            border-radius: 18px;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 56px); padding: 20px; padding-top: 100px;">
        <div class="login-wrap p-4 p-md-5" style="width: 100%; max-width: 480px;">
            <?php if ($mensaje_info): ?>
                <div class="alert alert-info"><?= htmlspecialchars($mensaje_info) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <h2 class="text-center mb-4">Crear Cuenta</h2>

            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required maxlength="25" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" name="username" id="username" class="form-control" required maxlength="25" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" required maxlength="55" value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="telefono">Teléfono</label>
                    <input type="number" name="telefono" id="telefono" class="form-control" required value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mínimo 4 caracteres" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirm">Confirmar Contraseña</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Repite la contraseña" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
            </form>

            <div class="mt-3 text-center">
                <hr />
                <p class="mb-0">¿Ya tienes cuenta?</p>
                <a href="login.php" class="btn btn-outline-secondary mt-2">Inicia sesión aquí</a>
            </div>
        </div>
    </div>

    <!-- Scripts iguales a los de otras páginas -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
