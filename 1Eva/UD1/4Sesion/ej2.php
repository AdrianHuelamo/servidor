<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
        $numero =0;
    ?>

</head>
<body>
    <?php 
        while ($numero <= 10) {
            echo $numero. "x 4 = " . $numero*4 . "<br>";
            $numero++;
        }
    ?>
</body>
</html>