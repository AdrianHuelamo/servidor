<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
        $numero = rand(1, 50);
    ?>

</head>
<body>
    <?php
        if ($numero%2 == 0) {
            echo "El número ". $numero. " es par";
        } else{
            echo "El número ". $numero. " es impar y el doble es ". $numero*2;
        }
        
    ?>
    <br>
    <a href="">Volver a probar</a>
</body>
</html>