<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJ5</title>
    <?php 
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    };

    $mostrarFormulario = TRUE;
    $profesores = ["JOSE", "LOLA", "LORENZO", "ISABEL", "MARILUZ", "MARIA JOSE"];
    $ultimo = count($profesores);
    $nombre = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = (test_input($_POST["nombre"] ?? ""));

        if ($nombre == "")  {
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
        <label>Di el nombre de un profesor <input type="text" name="nombre"></label><br><br>
        <input type="submit" value="Enviar">
    <?php else:
        for ($buscar="";$buscar=TRUE;){
            $buscar = array_search(strtoupper($nombre), $profesores);
            if ($buscar !== false) {
                echo "Nombre encontrado";
                break;
            } else{
                echo $nombre. " no es profesor";
                break;
            }
        }
    ?>
    <a href="">volver</a>
    <?php endif;
    ?>
</body>
</html>