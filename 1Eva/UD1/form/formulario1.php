<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$nombre="";
$email="";
$contraseña="";

function sanitizar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = test_input($_POST["nombre"] ?? '');
    $email = test_input($_POST["email"] ?? '');
    $contraseña = test_input($_POST["contraseña"] ?? '');
    $aficiones = $_POST['aficiones'];
        foreach ($aficiones as $aficiones_item):
            test_input($aficiones_item);
            $aficiones_test[] = $aficiones_item;
        endforeach;

        if ($nombre == "")
            $errores[] = "El campo nombre es obligatorio.";
        if ($email == "")
            $errores[] = "El campo email es obligatorio.";
        if ($contraseña == "")
            $errores[] = "El campo contraseña es obligatorio.";
        if (empty($aficiones))
            $errores[] ="Debes seleccionar al menos una afición";

        if (!empty($errores)):
            foreach ($errores as $error):
                echo $error;
            endforeach;
        else: echo "Usuario $nombre e email $email";

        // echo "Nombre: $nombre<br>";
        // echo "Nombre: ".$nombre."<br>";
        // echo "Aficiones:". implode(", ", $aficiones);
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
    if (!empty($errores)):
            foreach ($errores as $error):
                echo $error;
            endforeach;
        else: echo "Usuario $nombre e email $email";
    ?>
<br><br>
    <form action="<?php echo(htmlentities($_SERVER['PHP_SELF']));?>" method="POST">
        <label>Nombre: <input type="text" name="nombre"></label>
        <label>Email: <input type="mail" name="email"></label>
        <label>Contraseña: <input type="password" name="contraseña"></label>

        <br><br>

        <label>Genero:</label><br>
        <input type="radio" name="genero" value="Hombre"> Hombre<br>
        <input type="radio" name="genero" value="Mujer"> Mujer<br><br>

        <br><br>

        <label>Aficiones:</label><br>
        <input type="checkbox" name="aficiones[]" value="Leer"> Leer<br>
        <input type="checkbox" name="aficiones[]" value="Viajar"> Viajar<br>
        <input type="checkbox" name="aficiones[]" value="Cine"> Cine<br><br>

        <select name="grupo_opciones">
            <option value="1">Uno</option>
            <option value="3">Tres</option>
            <option value="7">Siete</option>

        </select>

        <input type="submit" value="Enviar">
    </form>

    <br>
    <a href="">Volver al formulario</a>

</body>

</html>