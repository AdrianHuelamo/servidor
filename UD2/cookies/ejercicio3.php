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
        $idioma =  limpiar($_POST["idioma"] ?? '');

        if (!empty($idioma)){
            setcookie('idioma',$idioma, [
            'expires' => time() + 3600,
            'path' => '/',
            'samesite' => 'Lax',
            ]);

            header("location:ejercicio3.php");

        } else {
            echo "Debes elegir un idioma";
        };
    };

    if (isset($_GET['borrarCookie'])){
        setcookie('idioma', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'samesite' => 'Lax',
            ]);
            header("location:ejercicio3.php");
    }

    
    ?>
</head>
<body>
    
    <?php
    if (isset($_COOKIE['idioma'])){
            $idiomaElegido = $_COOKIE['idioma'];
            if ($idiomaElegido == 'español'){
                echo "<h1>Idioma elegido español</h1>";
            }else if ($idiomaElegido == 'ingles'){
                echo "<h1>English message</h1>";
            }
            else if ($idiomaElegido == 'frances'){
                echo "<h1>Bonjour et bienvenue ! J’espère que ta journée sera remplie de bonheur, de réussite et de belles surprises.</h1>";
            }
        }
    ?>
    <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >
        <label for="user">Elige el idioma: </label>
        <select name="idioma">
            <option value="español">Español</option>
            <option value="ingles">Inglés</option>
            <option value="frances">Francés</option>
        </select>
        <input type="submit" value="Enviar">
    </form>
    <a href="ejercicio3.php?borrarCookie=si">Borrar cookie</a>
    
</body>
</html>