<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 

    function limpiar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    };

    function debuguear($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";

    }
    function debuguearExit($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;

    }

    $mostrarFormulario = TRUE;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        debuguear($_POST);
        $user =  limpiar($_POST["user"] ?? '');

        if (!empty($user)){
            setcookie('user',$user, [
            'expires' => time() + 3*24*60*60,
            'path' => '/',
            'samesite' => 'Lax',
            ]);

            header("location:ejercicio2.php");

        } else {
            echo "Debes introducir un usuario";
        };
    };
    
    ?>
</head>
<body>
    
    <?php
    if (isset($_COOKIE['user'])){
            echo "<h2>Hola este es tu mensaje personalizado " . $_COOKIE['user'] ."</h2>";
        }
    else { ?>
    <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >
        <label for="user">Introduce tu nombre de usuario: </label>
        <input type="text" name="user">
        <input type="submit" value="Enviar">
    </form>
    <?php }?>
</body>
</html>