<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
    $comida = $_GET['comida'];
    ?>
</head>
<body>
    <?php 
    echo "Mi comida favorita es: ". $comida;
    ?>
    <a href="ej2nuevo.php">volver</a>
</body>
</html>