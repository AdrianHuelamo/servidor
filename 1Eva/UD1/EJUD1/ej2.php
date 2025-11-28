<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eleccion = ($_POST["eleccion"] ?? '');
    header ("location:enviado.php?eleccion=$eleccion"); 
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Elección</title>
</head>
<body>
    <form action="<?php echo(htmlentities($_SERVER['PHP_SELF']));?>" method="POST">
        <select name="eleccion">
            <option value="si">Si</option>
            <option value="no">No</option>
        </select>

        <input type="submit" value="Enviar">
    </form>
    <br>
</body>

</html>