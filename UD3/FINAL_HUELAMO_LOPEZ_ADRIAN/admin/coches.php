<?php
require_once './includes/proteger.php';

if (!esAdmin()) {
    header('Location: index.php');
    exit();
}

require_once './includes/crudCoches.php';
require_once './includes/database.php';

$db = new Connection();
$conn = $db->getConnection();
$cocheObj = new Coches();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";
$error = "";

$datos_coche = [
    'id_coche' => $id, 'nombre' => '', 'id_categoria' => '', 'año' => date('Y'), 'precio_hora' => '', 
    'precio_dia' => '', 'precio_mes' => '', 'imagen' => '', 'kilometros' => 0, 
    'transmision' => 'Manual', 'asientos' => 5, 'maletero' => 300, 'combustible' => 'Gasolina'
];

if ($accion == "eliminar" && $id) {
    try {
        if ($cocheObj->eliminarCoche($conn, $id)) {
            $mensaje = "Coche eliminado correctamente.";
        } else {
            $error = "Error al eliminar el coche.";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    
    header("Location: coches.php" . ($error ? "?error=" . urlencode($error) : "?exito=" . urlencode($mensaje)));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion_post = $_POST['accion'] ?? 'crear';
    $id_coche = $_POST['id_coche'] ?? null;
    
    $datos_coche = [
        'id_coche' => $id_coche,
        'nombre' => $_POST['nombre'] ?? '',
        'id_categoria' => $_POST['id_categoria'] ?? null,
        'año' => $_POST['año'] ?? 0,
        'precio_hora' => $_POST['precio_hora'] ?? -1,
        'precio_dia' => $_POST['precio_dia'] ?? -1,
        'precio_mes' => $_POST['precio_mes'] ?? -1,
        'kilometros' => $_POST['kilometros'] ?? -1,
        'transmision' => $_POST['transmision'] ?? 'Manual',
        'asientos' => $_POST['asientos'] ?? 0,
        'maletero' => $_POST['maletero'] ?? 0,
        'combustible' => $_POST['combustible'] ?? 'Gasolina',
        'imagen' => $_POST['imagen_actual'] ?? ''
    ];
    
    $imagen_path = $_POST['imagen_actual'] ?? '';
    $nueva_imagen_subida = false;
    $ruta_nueva_imagen = '';

    try {
        if (
            empty($datos_coche['nombre']) || empty($datos_coche['id_categoria']) ||
            !is_numeric($datos_coche['precio_hora']) || $datos_coche['precio_hora'] < 0 ||
            !is_numeric($datos_coche['precio_dia']) || $datos_coche['precio_dia'] < 0 ||
            !is_numeric($datos_coche['precio_mes']) || $datos_coche['precio_mes'] < 0 ||
            !is_numeric($datos_coche['kilometros']) || $datos_coche['kilometros'] < 0 ||
            !is_numeric($datos_coche['año']) || $datos_coche['año'] < 1900 || $datos_coche['año'] > (date('Y') + 1) ||
            !is_numeric($datos_coche['asientos']) || $datos_coche['asientos'] < 1 ||
            !is_numeric($datos_coche['maletero']) || $datos_coche['maletero'] < 1
        ) {
            throw new Exception("Todos los campos son obligatorios y los valores numéricos no pueden ser negativos o irreales.");
        }

        if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] == 0) {
            
            $file_tmp_name = $_FILES['imagen']['tmp_name'];
            $file_name_original = $_FILES['imagen']['name'];
            
            $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
            $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];

            $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));
            if (!in_array($file_ext, $allowed_exts)) {
                throw new Exception("Error: Solo se permiten archivos .jpg, .jpeg, .png, .webp o .avif.");
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_mime = finfo_file($finfo, $file_tmp_name);
            finfo_close($finfo);
            
            if (!in_array($file_mime, $allowed_mimes)) {
                throw new Exception("Error: El tipo de archivo no es una imagen válida (MIME detectado: $file_mime).");
            }

            $target_dir = "../images/";
            $file_name = uniqid() . '-' . basename($file_name_original);
            $target_file = $target_dir . $file_name;
            $db_path = "images/" . $file_name; 

            if (move_uploaded_file($file_tmp_name, $target_file)) {
                $imagen_path = $db_path;
                $nueva_imagen_subida = true;
                $ruta_nueva_imagen = $target_file;
                
                if (!empty($_POST['imagen_actual']) && file_exists("../" . $_POST['imagen_actual'])) {
                    unlink("../" . $_POST['imagen_actual']);
                }
            } else {
                throw new Exception("Error al mover la imagen subida.");
            }
        } elseif ($accion_post == 'crear' && empty($imagen_path)) {
             throw new Exception("La imagen es obligatoria para un coche nuevo.");
        }

        if ($accion_post === "crear") {
            $cocheObj->insertarCoche($conn, $datos_coche, $imagen_path);
            $mensaje = "Coche creado con éxito.";
        } elseif ($accion_post === "editar" && $id_coche) {
            $cocheObj->actualizarCoche($conn, $id_coche, $datos_coche, $imagen_path);
            $mensaje = "Coche actualizado con éxito.";
        }
        header("Location: coches.php?exito=$mensaje");
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
        if ($nueva_imagen_subida && file_exists($ruta_nueva_imagen)) {
            unlink($ruta_nueva_imagen);
        }
    }
}

$coches = $cocheObj->getAll($conn);
$marcas = $cocheObj->getMarcas($conn);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    if ($accion === "editar" && $id) {
        $datos_coche = $cocheObj->getById($conn, $id);
    } elseif ($accion === "crear") {
        $datos_coche = [
            'nombre' => '', 'id_categoria' => '', 'año' => date('Y'), 'precio_hora' => '', 
            'precio_dia' => '', 'precio_mes' => '', 'imagen' => '', 'kilometros' => 0, 
            'transmision' => 'Manual', 'asientos' => 5, 'maletero' => 300, 'combustible' => 'Gasolina'
        ];
    }
}

$db->closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Coches</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .ftco-section { padding: 3em 0; }
        .table img { width: 120px; height: auto; border-radius: 5px; }
        .form-crud { max-width: 900px; margin: 20px auto; }
        .img-preview { max-width: 200px; height: auto; margin-top: 10px; border-radius: 5px; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>

    <?php include("./includes/menu_admin.php"); ?>

    <div class="container-fluid ftco-section">
        <div class="row justify-content-center">
            <main class="col-md-11">
                <h2>Gestión de Coches</h2>

                <?php if ($mensaje): ?><div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div><?php endif; ?>
                <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
                <?php if (isset($_GET['exito'])): ?><div class="alert alert-success"><?php echo htmlspecialchars($_GET['exito']); ?></div><?php endif; ?>
                <?php if (isset($_GET['error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div><?php endif; ?>

                <a href="coches.php?accion=crear" class="btn btn-success mb-3">Añadir Nuevo Coche</a>

                <div class="bg-white p-4 rounded shadow-sm mb-5">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Marca</th>
                                    <th class="text-center">Precio Día</th>
                                    <th class="text-center">Asientos</th>
                                    <th class="text-center">Transmisión</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($coches as $coche) : ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo $coche['id_coche']; ?></td>
                                    <td class="text-center align-middle"><img src="../<?php echo htmlspecialchars($coche['imagen']); ?>" alt=""></td>
                                    <td class="text-center align-middle"><?php echo htmlspecialchars($coche['nombre']); ?></td>
                                    <td class="text-center align-middle"><?php echo htmlspecialchars($coche['marca_nombre']); ?></td>
                                    <td class="text-center align-middle"><?php echo htmlspecialchars($coche['precio_dia']); ?>€</td>
                                    <td class="text-center align-middle"><?php echo htmlspecialchars($coche['asientos']); ?></td>
                                    <td class="text-center align-middle"><?php echo htmlspecialchars($coche['transmision']); ?></td>
                                    <td class="text-center align-middle">
                                        <a href="coches.php?accion=editar&id=<?php echo $coche['id_coche']; ?>" class="btn btn-sm btn-primary mb-1">
                                            Editar
                                        </a>
                                        <a href="coches.php?accion=eliminar&id=<?php echo $coche['id_coche']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Estás seguro?')">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm form-crud">
                        <h3><?php echo $accion === "crear" ? "Nuevo Coche" : "Editar Coche"; ?></h3>
          
                        <form method="post" action="coches.php?accion=<?php echo $accion; ?><?php if ($id) echo '&id='.$id; ?>" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="<?php echo $accion; ?>">
                            <input type="hidden" name="id_coche" value="<?php echo $id; ?>">
                            <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($datos_coche['imagen']); ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre del Modelo</label>
                                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($datos_coche['nombre']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Marca</label>
                                    <select name="id_categoria" class="form-control">
                                        <option value="">-- Selecciona Marca --</option>
                                        <?php foreach ($marcas as $marca): ?>
                                            <option value="<?php echo $marca['id_marca']; ?>" <?php if ($datos_coche['id_categoria'] == $marca['id_marca']) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($marca['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precio por Hora</label>
                                    <input type="number" name="precio_hora" class="form-control" min="0" step="0.01" value="<?php echo htmlspecialchars($datos_coche['precio_hora']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precio por Día</label>
                                    <input type="number" name="precio_dia" class="form-control" min="0" step="0.01" value="<?php echo htmlspecialchars($datos_coche['precio_dia']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precio por Mes</label>
                                    <input type="number" name="precio_mes" class="form-control" min="0" step="0.01" value="<?php echo htmlspecialchars($datos_coche['precio_mes']); ?>">
                                </div>
                            </div>
                            
                            <hr>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Año</label>
                                    <input type="number" name="año" class="form-control" min="1900" max="<?php echo date('Y') + 1; ?>" value="<?php echo htmlspecialchars($datos_coche['año']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kilómetros</label>
                                    <input type="number" name="kilometros" class="form-control" min="0" value="<?php echo htmlspecialchars($datos_coche['kilometros']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Asientos</label>
                                    <input type="number" name="asientos" class="form-control" min="1" value="<?php echo htmlspecialchars($datos_coche['asientos']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Maletero (Litros)</label>
                                    <input type="number" name="maletero" class="form-control" min="1" value="<?php echo htmlspecialchars($datos_coche['maletero']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Transmisión</label>
                                    <select name="transmision" class="form-control">
                                        <option value="Manual" <?php if ($datos_coche['transmision'] == 'Manual') echo 'selected'; ?>>Manual</option>
                                        <option value="Automático" <?php if ($datos_coche['transmision'] == 'Automático') echo 'selected'; ?>>Automático</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Combustible</label>
                                    <select name="combustible" class="form-control">
                                        <option value="Gasolina" <?php if ($datos_coche['combustible'] == 'Gasolina') echo 'selected'; ?>>Gasolina</option>
                                        <option value="Diesel" <?php if ($datos_coche['combustible'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
                                        <option value="Híbrido" <?php if ($datos_coche['combustible'] == 'Híbrido') echo 'selected'; ?>>Híbrido</option>
                                        <option value="Eléctrico" <?php if ($datos_coche['combustible'] == 'Eléctrico') echo 'selected'; ?>>Eléctrico</option>
                                    </select>
                                </div>
                            </div>
                            
                            <hr>

                            <div class="form-group mb-3">
                                <label for="imagen">Imagen del Coche</label>
                                <?php if ($accion == 'editar' && !empty($datos_coche['imagen'])): ?>
                                    <p class="mb-1">Actual:</p>
                                    <img src="../<?php echo htmlspecialchars($datos_coche['imagen']); ?>" alt="" class="img-preview d-block mb-2">
                                    <label for="imagen" class="mt-2">Subir nueva imagen (opcional):</label>
                                <?php endif; ?>
                                
                                <input type="file" name="imagen" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Coche</button>
                            <a href="coches.php" class="btn btn-secondary">Cancelar</a>
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