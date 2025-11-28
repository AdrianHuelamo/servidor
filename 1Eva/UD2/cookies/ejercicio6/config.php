<?php
function limpiar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**Aqui recogemos los datos del formuario mediante el método post */
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = limpiar($_POST['nombre']) ?? '';
    $color = limpiar($_POST['color']) ?? '';

    /**Si las variables no están vacias crea las respectivas cookies */
    if (!empty($nombre) || !empty($nombre)){

        setcookie('nombre',$nombre, [
            'expires' => time() + 3600,
            'path' => '/',
            'samesite' => 'Lax',
            ]);

        setcookie('color',$color, [
            'expires' => time() + 3600,
            'path' => '/',
            'samesite' => 'Lax',
            ]);

            /**Una vez creadas nos redirige a index.php donde nos mostrara el mensaje personalizado y el texto del color de la preferencia del usuario */
            header("location:index.php");
    } else {
        echo "<h2>Debes rellenar tus preferencias</h2>";
    }
}

/**Esta parte de aqui sirve por si en index.php alguien quiere borrar sus preferencias entonces redirige a config.php con la variable borrar=si. Seteamos la variable mediante $GET y si existe borramos las cookies respectivamente. Redirigimos a index.php que al haber borrado las visitas nos volverá a mandar a config.php para que elijamos nuestras preferencias de nuevo */
if (isset($_GET['borrar'])){
    setcookie('nombre','', [
    'expires' => time() - 3600,
    'path' => '/',
    'samesite' => 'Lax',
    ]);

    setcookie('color','', [
    'expires' => time() - 3600,
    'path' => '/',
    'samesite' => 'Lax',
    ]);

    header("location:index.php");


}?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJERCICIO 6</title>
</head>
<body>
    <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >
        <label for="user">Introduce tu nombre: </label><br><br>
        <input type="text" name="nombre"><br><br>
        <input type="color" name="color" id=""><br><br>
        <input type="submit" value="Guardar preferencias">
    </form>
</body>
</html>