<?php 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$mostrarFormulario = TRUE;
$comarar = FALSE;
$errores = [];

$productosArray = ["Monitor" => "120", "Teclado" => "45", "Altavoces" => "30"];
$productoP ="";
$producto1 ="";
$producto2 ="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $productoP = test_input($_POST["productoP"] ?? "");
    $producto1 = test_input($_POST["producto1"] ?? "");
    $producto2 = test_input($_POST["producto2"] ?? "");


    if ($productoP == "" || $producto1 == "" || $producto2 == "") {
        $errores[] = "Por favor, selecciona un producto.";
    } else if ($productoP == $producto1 || $productoP == $producto2 || $producto1 == $producto2){
        $errores[] = "No repitas productos.";
        $comarar = FALSE;
    }

    if (empty($errores)) {
        $mostrarFormulario = FALSE;
    }

    if ($comparar == TRUE) {
        if ($productoP > $producto1){
            $mascaro = $productoP;
        } else {
            $mascaro = $producto1;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
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
            <label for="Productos">Selecciona los productos</label><br>
            <select name="productoP" id="productoP">
                <?php foreach($productosArray as $clave => $valor): ?>
                    <option value="<?= $clave . " " . $valor ?>" <?= ($productoP == $clave . " " . $valor) ? "selected" : "" ?>>
                        <?= $clave ?>
                    </option>
                <?php endforeach;?>
            </select>
            <select name="producto1" id="producto1">
                <?php foreach($productosArray as $clave => $valor): ?>
                    <option value="<?= $clave . " " . $valor ?>" <?= ($producto1 == $clave . " " . $valor) ? "selected" : "" ?>>
                        <?= $clave ?>
                    </option>
                <?php endforeach;?>
            </select>
            <select name="producto2" id="producto2">
                <?php foreach($productosArray as $clave => $valor): ?>
                    <option value="<?= $clave . " " . $valor?>" <?= ($producto2 == $clave . " " . $valor) ? "selected" : "" ?>>
                        <?= $clave ?>
                    </option>
                <?php endforeach;?>
            </select>
            <br><br>
            <input type="submit" value="Enviar">
        </form>

    <?php else: ?>
        <p>Resultados de la comparación:</p>
        <p>Has comparado: <?php echo $productoP ?> y <?php echo $producto1 ?></p>
        <p>El producto más caro es: <?php $mascaro ?></p>
        <p>Diferencia: </p>
        <p>Comparaciones realizadas: </p><br>

        <p>Has comparado: <?php echo $productoP ?> y <?php echo $producto2 ?></p>
        <p>El producto más caro es: </p>
        <p>Diferencia: </p>
        <p>Comparaciones realizadas: </p><br>

        <p>El producto más caro de los tres seleccionados es: </p>

        <a href="">Volver a comprar</a>
    <?php endif; ?>
</body>
</html>
