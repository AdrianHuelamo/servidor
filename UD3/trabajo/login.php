<?php
require_once 'admin/includes/auth.php';  // ← Ruta correcta
require_once 'admin/includes/sessions.php';

$sesion = new Sessions();
$error = '';
$mensaje_info = '';

// NO redirigir si ya hay sesión, solo mostrar mensaje
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
        // Redirigir a la página anterior o al index
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
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="login-container">
        <div class="login-box shadow-lg">
            <h2 class="text-center mb-4">Iniciar sesión</h2>
            
            <?php if ($mensaje_info): ?>
                <div class="alert alert-info">
                    <?php echo $mensaje_info; ?>
                    <?php if (estaLogueado()): ?>
                        <br><a href="index.php" class="btn btn-sm btn-primary mt-2">Ir al inicio</a>
                        <a href="logout.php" class="btn btn-sm btn-secondary mt-2">Cerrar sesión</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!estaLogueado()): ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
                
                <div class="text-center mt-3">
                    <hr>
                    <p class="mb-2">¿No tienes cuenta?</p>
                    <a href="register.php" class="btn btn-outline-primary w-100">Crear nueva cuenta</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
