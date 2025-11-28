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
    $numero1="";
    $numero2="";
    $numero3="";


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $numero1 = intval(test_input($_POST["numero1"] ?? ""));
        $numero2 = intval(test_input($_POST["numero2"] ?? ""));
        $numero3 = intval(test_input($_POST["numero3"] ?? ""));

        if ($numero1 == "" || $numero2 == "" || $numero3 == "")  {
            $errores[] = "Escribe algo valido";
        }

        if (empty($errores)) {
            $mostrarFormulario = FALSE;
        }

    }
    function multiplicar($a,$b,$c) {
        return $a*$b*$c;
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
        <label>Di un número <input type="number" name="numero1"></label><br><br>
        <label>Di un número <input type="number" name="numero2"></label><br><br>
        <label>Di un número <input type="number" name="numero3"></label>

        <input type="submit" value="Enviar">
    <?php else: 
        echo "La multiplicación de ". $numero1. " x ". $numero2 . " x ". $numero3 . " = ". multiplicar($numero1, $numero2, $numero3) . "<br>"; ?>
        <a href="">volver</a>
    <?php endif;
    ?>

</body>
</html>