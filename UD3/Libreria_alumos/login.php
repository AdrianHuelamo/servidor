<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso privado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("menu.php"); ?>

<main class="col-md-9">
    <h2>Iniciar sesión</h2>

    <form method="POST" class="mt-3" style="max-width: 400px;">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</main>


<?php include("footer.php"); ?>
