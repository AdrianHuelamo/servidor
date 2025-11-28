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
    $nombre="";
    $edad="";


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = test_input($_POST["nombre"] ?? "");
        $edad = test_input($_POST["edad"] ?? "");

        if ($nombre == "" || $edad == "")  {
            $errores[] = "Escribe algo valido";
        }

        if (empty($errores)) {
            $mostrarFormulario = FALSE;
        }

    }
    $alumnos = [$nombre => $edad];
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
        <label>Cual es tu nombre: <input type="text" name="nombre"></label><br><br>
        <label>Cual es tu edad: <input type="number" name="edad"></label>

        <input type="submit" value="Enviar">
    <?php else: 
        foreach ($alumnos as $clave => $valor) {
            echo $clave ." " .$valor ."<br>";
        }?>
        <a href="">volver</a>
    <?php endif;
    ?>

</body>
</html>