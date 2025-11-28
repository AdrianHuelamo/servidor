<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    };
    $mostrarFormulario = TRUE;
    $numero="";


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $numero = intval(test_input($_POST["numero"] ?? ""));

        if ($numero == "")  {
            $errores[] = "Escribe algo ";
        }

        if (empty($errores)) {
            $mostrarFormulario = FALSE;
        }

    }
    ?>

</head>
<body>
    <?php if (!empty($errores)): ?>
                <div style="color:red;">
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
    <?php if ($mostrarFormulario): ?>
        <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >
        <label>Di un número <input type="number" name="numero"></label><br><br>

        <input type="submit" value="Enviar">
    <?php else: 
        if ($numero >10) {
        echo "Tu número es: ". $numero;
    } else {
        while ($numero <= 10 && $numero >=0) {
            echo $numero. "\n";
            $numero--;
        }
    } ?>
        <a href="">volver</a>
    <?php endif;
    ?>

</body>
</html>