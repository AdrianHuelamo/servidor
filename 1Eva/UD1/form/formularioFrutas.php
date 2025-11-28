<!DOCTYPE html>
<html lang="en">
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

    function debuguear($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";

    }
    function debuguearExit($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;

    }

    $mostrarFormulario = TRUE;

    $frutasArray = ["--Selecciona--", "Pera", "Melon", "Manzana", "Naranja", "Piña"];
    $fruta ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $fruta = test_input($_POST["frutas"] ?? "");

        if ($fruta == "--Selecciona--" || $fruta == "") {
            $errores[] = "Por favor, selecciona una fruta.";
        }

        if (empty($errores)) {
            $mostrarFormulario = FALSE;
        }
    }
    ?>




</head>
<body>
    <?php if ($mostrarFormulario): ?>
    <?php if (!empty($errores)): ?>
            <div style="color:red;">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >

        <label for="seletc">Selecciona tu fruta favorita </label>
        <select name="frutas" id="frutas">
            <?php foreach($frutasArray as $frutas):?>

            <option >
                <?php echo $frutas?>
                </option>
                <?php endforeach;?>
        </select>


        <input type="submit" value="Enviar">
        


    </form>

    <?php else: ?>

        <p>Tu fruta favorita es <?php echo $fruta?></p>
        <a href="">Volver</a>
        <?php endif; ?>
</body>
</html>