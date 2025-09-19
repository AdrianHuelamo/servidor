<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php

    if (isset($_GET['libro'])){
        echo "Mi libro favorito es: ". $_GET['libro'];
    } else if (isset($_GET['peli'])){
        echo "Mi peli favorita es: ". $_GET['peli'];
    } else if (isset($_GET['comida'])){
        echo "Mi comida favorita es: {$_GET['comida']}";
    }

    $peli = "Ted";
    $libro = "Harry Potter";
    $comida = "Pasta";
    ?>

</head>
<body>
    <?php if (!isset($_GET['libro']) && !isset($_GET['peli']) && !isset($_GET['comida'])): ?>
    <a href="index.php?libro=<?= $libro ?>">Mi libro favorito</a><br>
    <a href="index.php?comida=<?= $comida ?>">Mi comida favorita</a><br>
    <a href="index.php?peli=<?= $peli ?>">Mi pelicula favorita</a>

    <?php else:?>
    <a href="index.php">volver</a>
    <?php endif; ?>
</body>
</html>