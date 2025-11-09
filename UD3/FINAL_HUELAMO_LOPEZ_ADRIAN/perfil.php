<?php
require_once 'admin/includes/auth.php';
require_once 'admin/includes/database.php';
require_once 'admin/includes/crudUsuarios.php';

if (!estaLogueado()) {
    header('Location: login.php?error=1');
    exit();
}

$error_datos = '';
$success_datos = '';
$error_pass = '';
$success_pass = '';

$id_usuario = getUserId();
$userObj = new Usuarios();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Connection();
    $conn = $db->getConnection();

    if (isset($_POST['guardar_datos'])) {
        $imagen_path = $_POST['imagen_actual'];
        $nueva_imagen_subida = false;
        $ruta_nueva_imagen = '';
        
        try {
            $nombre = trim($_POST['nombre']);
            $correo = trim($_POST['correo']);
            $telefono = trim($_POST['telefono']);
            $bio = trim($_POST['bio']);

            if (empty($nombre) || empty($correo) || empty($telefono)) {
                throw new Exception("Los campos nombre, correo y teléfono son obligatorios.");
            }
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("El formato de correo no es válido.");
            }

            if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] == 0) {
                
                $file_tmp_name = $_FILES['imagen']['tmp_name'];
                $file_name_original = $_FILES['imagen']['name'];
                
                $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
                $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];

                $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));
                if (!in_array($file_ext, $allowed_exts)) {
                    throw new Exception("Error: Solo se permiten archivos .jpg, .jpeg, .png o .webp.");
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_mime = finfo_file($finfo, $file_tmp_name);
                finfo_close($finfo);
                
                if (!in_array($file_mime, $allowed_mimes)) {
                    throw new Exception("Error: El tipo de archivo no es una imagen válida (MIME detectado: $file_mime).");
                }
                
                $target_dir = "images/autores/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0755, true); 
                }
                
                $file_name = "user-" . $id_usuario . '-' . basename($file_name_original);
                $target_file = $target_dir . $file_name;
                $db_path = "images/autores/" . $file_name; 

                if (move_uploaded_file($file_tmp_name, $target_file)) {
                    $imagen_path = $db_path;
                    $nueva_imagen_subida = true;
                    $ruta_nueva_imagen = $target_file;
                    
                    $ruta_imagen_antigua = $_POST['imagen_actual'];
                    if (!empty($ruta_imagen_antigua) && $ruta_imagen_antigua != 'images/autores/default.png' && file_exists($ruta_imagen_antigua)) {
                        unlink($ruta_imagen_antigua);
                    }
                } else {
                    throw new Exception("Error al mover la imagen subida.");
                }
            }

            if ($userObj->actualizarPerfil($conn, $id_usuario, $nombre, $correo, $telefono, $bio, $imagen_path)) {
                $_SESSION['nombre'] = $nombre;
                $_SESSION['correo'] = $correo;
                $_SESSION['telefono'] = $telefono;
                $_SESSION['bio'] = $bio;
                $_SESSION['imagen'] = $imagen_path;
                header("Location: perfil.php?exito_datos=1");
                exit();
            } else {
                throw new Exception("Error al actualizar. Inténtalo de nuevo.");
            }

        } catch (Exception $e) {
            $error_datos = $e->getMessage();
            
            if ($nueva_imagen_subida && file_exists($ruta_nueva_imagen)) {
                unlink($ruta_nueva_imagen);
            }
        }
    }

    if (isset($_POST['guardar_password'])) {
        try {
            $pass_actual = $_POST['pass_actual'];
            $pass_nueva = $_POST['pass_nueva'];
            $pass_confirm = $_POST['pass_confirm'];

            if (empty($pass_actual) || empty($pass_nueva) || empty($pass_confirm)) {
                throw new Exception("Todos los campos de contraseña son obligatorios.");
            }
            if ($pass_nueva !== $pass_confirm) {
                throw new Exception("Las contraseñas nuevas no coinciden.");
            }
            if (strlen($pass_nueva) < 4) {
                throw new Exception("La contraseña nueva debe tener al menos 4 caracteres.");
            }

            if ($userObj->actualizarPassword($conn, $id_usuario, $pass_actual, $pass_nueva)) {
                $success_pass = "¡Contraseña actualizada correctamente!";
            }
        } catch (Exception $e) {
            $error_pass = $e->getMessage();
        }
    }
    
    $db->closeConnection($conn);
}

if(isset($_GET['exito_datos'])) $success_datos = "¡Datos actualizados correctamente!";
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
    
    <?php include("menu.php"); ?>
    
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

                        <form method="POST" action="perfil.php" enctype="multipart/form-data">
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
                                <label for="bio">Biografía</label>
                                <textarea name="bio" class="form-control" rows="4" placeholder="Escribe algo sobre ti..."><?php echo htmlspecialchars($_SESSION['bio'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="imagen">Foto de Perfil</label>
                                <p class="mb-1">Actual:</p>
                                <img src="<?php echo htmlspecialchars($_SESSION['imagen'] ?? 'images/autores/default.png'); ?>" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($_SESSION['imagen'] ?? 'images/autores/default.png'); ?>">
                                <hr>
                                <label>Subir nueva foto (opcional)</label>
                                <input type="file" name="imagen" class="form-control-file">
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

    <?php include("footer.php"); ?>
    
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