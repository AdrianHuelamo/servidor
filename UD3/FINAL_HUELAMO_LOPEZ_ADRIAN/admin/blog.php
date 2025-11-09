<?php
require_once './includes/proteger.php';
require_once './includes/crudBlog.php';
require_once './includes/database.php';

$db = new Connection();
$conn = $db->getConnection();
$blogObj = new Blog();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";
$error = "";

if ($accion == "eliminar" && $id) {
    if ($blogObj->eliminarPost($conn, $id)) {
        $mensaje = "Post eliminado correctamente.";
    } else {
        $error = "Error al eliminar el post.";
    }
    header("Location: blog.php" . ($error ? "?error=$error" : "?exito=$mensaje"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $resumen = $_POST['resumen'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $id_autor = getUserId();
    $accion_post = $_POST['accion'] ?? 'crear';
    $id_post = $_POST['id_blog'] ?? null;

    $imagen_path = $_POST['imagen_actual'] ?? '';
    $nueva_imagen_subida = false;
    $ruta_nueva_imagen = '';
    
    try {
        if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] == 0) {
            $target_dir = "../images/";
            $file_name = uniqid() . '-' . basename($_FILES["imagen"]["name"]);
            $target_file = $target_dir . $file_name;
            $db_path = "images/" . $file_name;

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $imagen_path = $db_path;
                $nueva_imagen_subida = true;
                $ruta_nueva_imagen = $target_file;
                
                $ruta_imagen_antigua = "../" . $_POST['imagen_actual'];
                if (!empty($_POST['imagen_actual']) && file_exists($ruta_imagen_antigua)) {
                    unlink($ruta_imagen_antigua);
                }
            } else {
                throw new Exception("Error al mover la imagen subida.");
            }
        } elseif ($accion_post == 'crear' && empty($imagen_path)) {
             throw new Exception("La imagen es obligatoria para un post nuevo.");
        }

        if ($accion_post === "crear") {
            $blogObj->insertarPost($conn, $titulo, $resumen, $contenido, $id_autor, $imagen_path);
            $mensaje = "Post creado con éxito.";
        } elseif ($accion_post === "editar" && $id_post) {
            $blogObj->actualizarPost($conn, $id_post, $titulo, $resumen, $contenido, $imagen_path);
            $mensaje = "Post actualizado con éxito.";
        }
        header("Location: blog.php?exito=$mensaje");
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
        
        if ($nueva_imagen_subida && file_exists($ruta_nueva_imagen)) {
            unlink($ruta_nueva_imagen);
        }
        
        header("Location: blog.php?accion=$accion_post" . ($id_post ? "&id=$id_post" : "") . "&error=" . urlencode($error));
        exit();
    }
}

$posts = $blogObj->getAll($conn);

$datos_post = ['titulo' => '', 'resumen' => '', 'contenido' => '', 'imagen' => ''];
if ($accion === "editar" && $id) {
    $datos_post = $blogObj->getPostById($conn, $id);
}

$db->closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Blog</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .ftco-section { padding: 3em 0; }
        .table img { width: 100px; height: auto; border-radius: 5px; }
        .form-crud { max-width: 800px; margin: 20px auto; }
        .img-preview { max-width: 200px; height: auto; margin-top: 10px; border-radius: 5px; } 
    </style>
</head>
<body>

    <?php include("./includes/menu_admin.php"); ?>

    <div class="container ftco-section">
        <div class="row justify-content-center">
            <main class="col-md-12">
                <h2>Blog</h2>

                <?php if (isset($_GET['exito'])): ?><div class="alert alert-success"><?php echo htmlspecialchars($_GET['exito']); ?></div><?php endif; ?>
                <?php if (isset($_GET['error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div><?php endif; ?>

                <a href="blog.php?accion=crear" class="btn btn-success mb-3">Añadir Nuevo Post</a>

                <div class="bg-white p-4 rounded shadow-sm mb-5">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($posts as $post) : ?>
                            <tr>
                                <td><img src="../<?php echo htmlspecialchars($post['imagen']); ?>" alt=""></td>
                                <td><?php echo htmlspecialchars($post['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($post['nombre_autor'] ?? 'N/A'); ?></td>
                                <td><?php echo date("d/m/Y", strtotime($post['fecha'])); ?></td>
                                <td>
                                    <a href="blog.php?accion=editar&id=<?php echo $post['id_blog']; ?>" class="btn btn-sm btn-primary">
                                        Editar
                                    </a>
                                    <a href="blog.php?accion=eliminar&id=<?php echo $post['id_blog']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($accion === "crear" || ($accion === "editar" && $id)): ?>
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm form-crud">
                        <h3><?php echo $accion === "crear" ? "Nuevo Post" : "Editar Post"; ?></h3>
          
                        <form method="post" action="blog.php" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="<?php echo $accion; ?>">
                            <input type="hidden" name="id_blog" value="<?php echo $id; ?>">
                            <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($datos_post['imagen']); ?>">

                            <div class="mb-3">
                                <label class="form-label">Título:</label>
                                <input type="text" name="titulo" class="form-control"
                                value="<?php echo htmlspecialchars($datos_post['titulo']); ?>" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="imagen">Imagen Destacada</label>
                                <?php if ($accion == 'editar' && !empty($datos_post['imagen'])): ?>
                                    <p class="mb-1">Actual:</p>
                                    <img src="../<?php echo htmlspecialchars($datos_post['imagen']); ?>" alt="" class="img-preview d-block mb-2">
                                    <label for="imagen" class="mt-2">Subir nueva imagen (opcional):</label>
                                <?php endif; ?>
                                
                                <input type="file" name="imagen" class="form-control" 
                                <?php echo ($accion == 'crear') ? 'required' : ''; ?>>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Resumen:</label>
                                <textarea name="resumen" class="form-control" rows="3" required><?php echo htmlspecialchars($datos_post['resumen']); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contenido Completo:</label>
                                <textarea name="contenido" class="form-control" rows="10" required><?php echo htmlspecialchars($datos_post['contenido']); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="blog.php" class="btn btn-secondary">Cancelar</a>
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