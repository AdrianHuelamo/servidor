<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3</title>
</head>
<body>

<?php
// Procesar formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['genero'])) {
        echo "<p><strong>Género seleccionado:</strong> " . $_POST['genero'] . "</p>";
    }

    if (isset($_POST['color'])) {
        echo "<p><strong>Color elegido:</strong> " . $_POST['color'] . "</p>";
    }

    if (isset($_POST['aficiones'])) {
        echo "<p><strong>Aficiones:</strong> " . implode(", ", $_POST['aficiones']) . "</p>";
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h3>Elige tu género (radio):</h3>
    <input type="radio" name="genero" value="Hombre"> Hombre
    <input type="radio" name="genero" value="Mujer"> Mujer
    <input type="radio" name="genero" value="Otro"> Otro

    <h3>Selecciona un color (select):</h3>
    <select name="color">
        <option value="Rojo">Rojo</option>
        <option value="Azul">Azul</option>
        <option value="Verde">Verde</option>
    </select>

    <h3>Marca tus aficiones (checkbox):</h3>
    <input type="checkbox" name="aficiones[]" value="Deporte"> Deporte
    <input type="checkbox" name="aficiones[]" value="Música"> Música
    <input type="checkbox" name="aficiones[]" value="Viajar"> Viajar

    <br><br>
    <input type="submit" value="Enviar">
</form>

</body>
</html>
