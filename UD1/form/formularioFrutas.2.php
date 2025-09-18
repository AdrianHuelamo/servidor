<?php 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$mostrarFormulario = TRUE;
$errores = []; // inicializamos array de errores

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
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

        <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="POST">
            <label for="frutas">Selecciona tu fruta favorita</label>
            <select name="frutas" id="frutas">
                <?php foreach($frutasArray as $opcion): ?>
                    <option value="<?= $opcion ?>" <?= ($fruta == $opcion) ? "selected" : "" ?>>
                        <?= $opcion ?>
                    </option>
                <?php endforeach;?>
            </select>
            <br><br>
            <input type="submit" value="Enviar">
        </form>

    <?php else: ?>
        <p>Tu fruta favorita es <strong><?php echo $fruta ?></strong></p>
        <a href="">Volver</a>
    <?php endif; ?>
</body>
</html>
