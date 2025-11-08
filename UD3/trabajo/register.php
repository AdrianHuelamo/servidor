<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin/includes/auth.php'; 
require_once 'admin/includes/database.php';

if (estaLogueado()) {
    $mensaje_info = "Ya tienes una cuenta activa como " . getNombreUsuario();
}

$error = '';
$success = '';

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
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="login-container">
        <div class="login-box shadow-lg">
            <h2 class="text-center mb-4">Crear Cuenta</h2>
            
            <?php if (estaLogueado()): ?>
                <div class="alert alert-info">
                    <?php echo $mensaje_info; ?>
                    <br><a href="index.php" class="btn btn-sm btn-primary mt-2">Ir al inicio</a>
                </div>
            <?php else: ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" 
                               placeholder="Ej: Adahi" required maxlength="25"
                               value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" name="username" id="username" class="form-control" 
                               placeholder="Ej: joselu24" required maxlength="25"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control" 
                               placeholder="Ej: borja@gmail.com" required maxlength="55"
                               value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="number" name="telefono" id="telefono" class="form-control" 
                               placeholder="Ej: 612345678" required
                               value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" 
                               placeholder="Mínimo 4 caracteres" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirm" id="password_confirm" 
                               class="form-control" placeholder="Repite la contraseña" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
                </form>
                
                <div class="text-center mt-3">
                    <hr>
                    <p class="mb-0">¿Ya tienes cuenta?</p>
                    <a href="login.php" class="btn btn-outline-secondary mt-2">Inicia sesión aquí</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
