<?php 
function limpiar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*generamos las cookies de las visitas */
$visitas= $_COOKIE['visitas'] ?? 0;
$visitas++;
setcookie('visitas',$visitas, [
    'expires' => time() + 3600,
    'path' => '/',
    'samesite' => 'Lax',
]);
/*Si es la primera vez que abrimos index.php nos redirige a config.php para guardar nuestras preferencias */
if ($visitas == 1){
    header("location:config.php");
}else {

    /*Sino nos recoge las cookies del archivo config.php mediante $cookie */
    $nombre = limpiar($_COOKIE['nombre']);
    $color = limpiar($_COOKIE['color']);
    
}

/**Si le damos al enlace de borrar nos redirige a index.php?borrar=si donde borramos la cookie de visitas y redirigimos a config.php?borrar=si */
if (isset($_GET['borrar'])){
    setcookie('visitas','', [
    'expires' => time() - 3600,
    'path' => '/',
    'samesite' => 'Lax',
]);
header("location:config.php?borrar=si");

/**Ahora ir a ver que pasa en el archivo de config.php */
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indice del ejercicio numero 6</title>
    <style>
        * {
            color: <?= $color?>;
        }
    </style>
</head>
<body>
    <h1>Bienvenido <?php echo $nombre?></h1>
    <h2>Esta página está personalizada con tu color <?php echo $color?></h2><br>
    <a href="index.php?borrar=si">Borrar</a>

</body>
</html>