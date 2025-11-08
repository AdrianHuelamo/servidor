<?php
// 1. Cargar auth.php primero para manejar la sesión
require_once 'admin/includes/auth.php';
require_once 'admin/includes/database.php';

// 2. PROTEGER LA PÁGINA
// Si no está logueado, lo expulsamos al login con un mensaje
if (!estaLogueado()) { //
    header('Location: login.php?error=1'); //
    exit();
}

// 3. Variables para mensajes
$error_datos = '';
$success_datos = '';
$error_pass = '';
$success_pass = '';

// 4. Obtener el ID del usuario de la sesión
$id_usuario = getUserId(); //

// 5. Manejar el envío de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Connection();
    $conn = $db->getConnection();

    // --- FORMULARIO 1: ACTUALIZAR DATOS PERSONALES ---
    if (isset($_POST['guardar_datos'])) {
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $telefono = trim($_POST['telefono']);

        // Validación simple
        if (empty($nombre) || empty($correo) || empty($telefono)) {
            $error_datos = "Todos los campos son obligatorios.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) { //
            $error_datos = "El formato de correo no es válido.";
        } else {
            // Actualizar en la base de datos
            $sql = "UPDATE usuarios SET nombre = ?, correo = ?, telefono = ? WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nombre, $correo, $telefono, $id_usuario);
            
            if ($stmt->execute()) {
                $success_datos = "¡Datos actualizados correctamente!";
                
                // MUY IMPORTANTE: Actualizar la sesión también
                $_SESSION['nombre'] = $nombre;
                $_SESSION['correo'] = $correo;
                $_SESSION['telefono'] = $telefono;
            } else {
                $error_datos = "Error al actualizar. Inténtalo de nuevo.";
            }
            $stmt->close();
        }
    }

    // --- FORMULARIO 2: CAMBIAR CONTRASEÑA ---
    if (isset($_POST['guardar_password'])) {
        $pass_actual = $_POST['pass_actual'];
        $pass_nueva = $_POST['pass_nueva'];
        $pass_confirm = $_POST['pass_confirm'];

        // Validaciones
        if (empty($pass_actual) || empty($pass_nueva) || empty($pass_confirm)) {
            $error_pass = "Todos los campos de contraseña son obligatorios.";
        } elseif ($pass_nueva !== $pass_confirm) {
            $error_pass = "Las contraseñas nuevas no coinciden.";
        } elseif (strlen($pass_nueva) < 4) { //
            $error_pass = "La contraseña nueva debe tener al menos 4 caracteres.";
        } else {
            // 1. Obtener la contraseña actual de la BD
            $sql_pass = "SELECT password FROM usuarios WHERE id_usuario = ?";
            $stmt_pass = $conn->prepare($sql_pass);
            $stmt_pass->bind_param("i", $id_usuario);
            $stmt_pass->execute();
            $resultado = $stmt_pass->get_result();
            $usuario = $resultado->fetch_assoc();
            $stmt_pass->close();

            // 2. Verificar si la contraseña actual es correcta
            if (password_verify($pass_actual, $usuario['password'])) {
                // 3. Hashear la nueva contraseña
                $password_hash = password_hash($pass_nueva, PASSWORD_BCRYPT); //

                // 4. Actualizar en la BD
                $sql_update_pass = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";
                $stmt_update = $conn->prepare($sql_update_pass);
                $stmt_update->bind_param("si", $password_hash, $id_usuario);
                
                if ($stmt_update->execute()) {
                    $success_pass = "¡Contraseña actualizada correctamente!";
                } else {
                    $error_pass = "Error al actualizar la contraseña.";
                }
                $stmt_update->close();
            } else {
                $error_pass = "La contraseña actual es incorrecta.";
            }
        }
    }
    
    $db->closeConnection($conn);
} // Fin de la gestión POST

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mi Perfil - AlquiLobato</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php include("menu.php"); // ?>
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/login-bg.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Inicio <i class="ion-ios-arrow-forward"></i></a></span> <span>Mi Perfil <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Gestionar Mi Perfil</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 ftco-animate">
                    
                    <div class="bg-light p-4 p-md-5 rounded">
                        <h3 class="mb-4">Mis Datos Personales</h3>
                        
                        <?php if ($error_datos): ?><div class="alert alert-danger"><?php echo $error_datos; ?></div><?php endif; ?>
                        <?php if ($success_datos): ?><div class="alert alert-success"><?php echo $success_datos; ?></div><?php endif; ?>

                        <form method="POST" action="perfil.php">
                            <div class="form-group">
                                <label for="username">Usuario (No se puede cambiar)</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly disabled>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($_SESSION['correo']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($_SESSION['telefono']); ?>" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="guardar_datos" class="btn btn-primary py-3 px-4">Guardar Datos</button>
                            </div>
                        </form>
                    </div>

                    <hr class="my-5">

                    <div class="bg-light p-4 p-md-5 rounded">
                        <h3 class="mb-4">Cambiar Contraseña</h3>

                        <?php if ($error_pass): ?><div class="alert alert-danger"><?php echo $error_pass; ?></div><?php endif; ?>
                        <?php if ($success_pass): ?><div class="alert alert-success"><?php echo $success_pass; ?></div><?php endif; ?>

                        <form method="POST" action="perfil.php">
                            <div class="form-group">
                                <label for="pass_actual">Contraseña Actual</label>
                                <input type="password" name="pass_actual" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="pass_nueva">Nueva Contraseña</label>
                                <input type="password" name="pass_nueva" class="form-control" placeholder="Mínimo 4 caracteres" required>
                            </div>
                            <div class="form-group">
                                <label for="pass_confirm">Confirmar Nueva Contraseña</label>
                                <input type="password" name="pass_confirm" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="guardar_password" class="btn btn-primary py-3 px-4">Actualizar Contraseña</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); // ?>
    
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/main.js"></script>
    
</body>
</html>