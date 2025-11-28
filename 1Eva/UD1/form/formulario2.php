<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$frutas = ["manzanas", "peras", "limones", "naranjas", "platanos"]

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario completo</title>
</head>

<body>
    <h1>Tu fruta favorita</h1>
    <form action="<?php echo(htmlentities($_SERVER['PHP_SELF']));?>" method="POST">

        <select name="frutas">
            <option value="1">Uno</option>
        </select>

        <input type="submit" value="Enviar">
    </form>

    <br>
    <a href="">Volver al formulario</a>

</body>
</html>