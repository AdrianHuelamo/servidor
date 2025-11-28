<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
    $libro = $_GET['libro'];
    ?>
</head>
<body>
    <?php 
    echo "Mi libro favorita es: ". $libro;
    ?>
    <a href="ej2nuevo.php">volver</a>
</body>
</html>