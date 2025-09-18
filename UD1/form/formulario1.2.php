<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errores = [];
$mostrar_formulario = TRUE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $contraseña = trim($_POST["contraseña"] ?? '');
    $aficiones = ($_POST['aficiones'] ?? []);
    $genero = ($_POST["genero"] ?? '');
    $pais = ($_POST["pais"] ?? '');

        if ($nombre == "")
            $errores[] = "El campo nombre es obligatorio.";
        if ($email == "")
            $errores[] = "El campo email es obligatorio.";
        if ($contraseña == "")
            $errores[] = "El campo contraseña es obligatorio.";
        if ($genero == "")
            $errores[] = "El campo género es obligatorio.";
        if ($pais == "")
            $errores[] = "El campo pais es obligatorio.";
        if (empty($aficiones))
            $errores[] ="Debes seleccionar al menos una afición";

        if (empty($errores)):
            $mostrar_formulario = FALSE;
        endif;
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario completo</title>
</head>

<body>
<?php 
if ($mostrar_formulario):
?>
<?php 
if (!empty($errores)): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<br><br>
    <form action="<?php echo(htmlentities($_SERVER['PHP_SELF']));?>" method="POST">
        <label for="seletc">Formulario 1</label>
        <br><br>
        <label>Nombre: <input type="text" name="nombre"></label>
        <label>Email: <input type="mail" name="email"></label>
        <label>Contraseña: <input type="password" name="contraseña"></label>

        <br><br>

        <label>Genero:</label><br>
        <input type="radio" name="genero" value="Hombre"> Hombre<br>
        <input type="radio" name="genero" value="Mujer"> Mujer<br><br>

        <label>Aficiones:</label><br>
        <input type="checkbox" name="aficiones[]" value="Leer"> Leer<br>
        <input type="checkbox" name="aficiones[]" value="Viajar"> Viajar<br>
        <input type="checkbox" name="aficiones[]" value="Cine"> Cine<br><br>

        <select name="pais">
            <option value="España">España</option>
            <option value="Italia">Italia</option>
            <option value="Irlanda">Irlanda</option>

        </select>

        <input type="submit" value="Enviar">
    </form>

    <?php else: ?>
        <h2>Datos enviados</h2>

        <ul>
            <li><strong>Nombre: </strong><?= htmlspecialchars($nombre) ?></li>
            <li><strong>Email: </strong><?= htmlspecialchars($email) ?></li>
            <li><strong>Genero: </strong><?= htmlspecialchars($genero) ?></li>
            <li><strong>Pais: </strong><?= htmlspecialchars($pais) ?></li>
            <li><strong>Aficiones: </strong><?= implode(", ", $aficiones) ?></li>

    
        </ul>
    <br>
    <a href="">Volver al formulario</a>
<?php endif; ?>
</body>

</html>