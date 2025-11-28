<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJ6</title>

    <?php 
    $numero = rand(1,10);
    ?>

</head>
<body>
    <?php if ($numero <5) { ?>
        <h2>Suspendido</h2>
    <?php } else if ($numero >= 5 && $numero < 6) {?>
        <h2>Suficiente</h2>
    <?php } else if ($numero >= 6 && $numero < 7) {?>
        <h2>Bien</h2>
    <?php } else if ($numero >= 7 && $numero < 9) {?>
        <h2>Notable</h2>
    <?php } else if ($numero >= 9 && $numero <= 10) {?>
        <h2>Sobresaliente</h2>
    <?php } else { ?>
        <h2>Error</h2>
    <?php } ?>

</body>
</html>