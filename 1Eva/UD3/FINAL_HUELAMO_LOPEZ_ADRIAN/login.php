<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/auth.php';
require_once 'admin/includes/sessions.php';

$mensaje_info = '';
$error = '';

$sesion = new Sessions();

if (estaLogueado()) {
    $mensaje_info = "Ya has iniciado sesión como " . getNombreUsuario();
}

if (isset($_GET['error']) && $_GET['error'] == 1) {
    $mensaje_info = "Debes iniciar sesión para poder reservar un coche.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $clave = $_POST['password'];

    $datos = $sesion->comprobarCredenciales($usuario, $clave);

    if ($datos) {
        $sesion->crearSesion($datos);
        $redirect = $_GET['redirect'] ?? 'index.php';
        header("Location: " . $redirect);
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Iniciar Sesión - AlquiLobato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

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
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.1);
            border-radius: 18px;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 56px); padding: 20px; padding-top: 100px;">        <div class="login-wrap p-4 p-md-5" style="width: 100%; max-width: 420px;">
            <?php if ($mensaje_info): ?>
                <div class="alert alert-info"><?= htmlspecialchars($mensaje_info) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <h2 class="text-center mb-4">Iniciar sesión</h2>

            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="username">Usuario</label>
                    <input type="text" name="username" id="username" class="form-control"/>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control"/>
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                ¿No tienes cuenta? <a href="register.php">Crear nueva cuenta</a>
            </div>

            <?php if (estaLogueado()): ?>
                <div class="mt-4 text-center">
                    <a href="index.php" class="btn btn-outline-success btn-sm">Ir al inicio</a>
                    <a href="admin/includes/logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- JS al final como en tus otras páginas -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
