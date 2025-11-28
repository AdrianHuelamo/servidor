<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJ7</title>
    <?php
    if (isset($_GET['numero1']) && isset($_GET['numero2'])){
        $numero1 = $_GET['numero1'];
        $numero2 = $_GET['numero2'];
    }

    if ($numero1 > $numero2){
        echo "El número 1: ". $numero1. " es mayor que el número 2: ". $numero2;
    } else if ($numero1 < $numero2) {
        echo "El número 2: ". $numero2. " es mayor que el número 1: ". $numero1;
    } 
    ?>
</head>
<body>
    <?php if (!isset($_GET['numero1']) && !isset($_GET['numero2'])): ?>
    <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>">
    <label>Número 1 <input type="number" name="numero1"></label><br><br>
    <label>Número 2 <input type="number" name="numero2"></label><br><br>
    <input type="submit" value="Enviar">

    <?php else:?>
    <?php
    if ($numero1 == $numero2){
        echo "Error: los números son iguales";
    } else if (($numero1="") || ($numero2="")){
        echo "Error: no has introducido los números bien";
    } ?>
    <a href="ej7.php">volver</a>
    <?php endif; ?>

</body>
</html>