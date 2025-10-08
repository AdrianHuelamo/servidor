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
                <h2>Categorías</h2>

                <a href="" class="btn btn-success mb-3">Añadir nueva categoría</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Categoría 1</td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">Editar</a>
                                <a href="" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Categoría 2</td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">Editar</a>
                                <a href="" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Categoría 3</td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">Editar</a>
                                <a href="" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                    
            </main>
        </div>
    </div>

    <?php include("./footer.php"); ?>