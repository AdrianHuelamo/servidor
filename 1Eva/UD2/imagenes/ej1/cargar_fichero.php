<?php

if(isset($_GET['imagen'])) {
    $imagen = $_GET['imagen'];
    if(unlink("upload/".$imagen)){
        header("location:index.php");
    }
}

if ($_FILES["foto"]["error"] > 0) {
    echo "Error: " . $_FILES["foto"]["error"] . "<br>";
} else {
    echo "Nombre de la imagen: " . $_FILES["foto"]["name"] . "<br>";
    echo "Tipo: " . $_FILES["foto"]["type"] . "<br>";
    echo "Medida: " . ($_FILES["foto"]["size"] / 1024) . " kB<br>";
    echo "Imagen almacenada en: " . $_FILES["foto"]["tmp_name"];
}

if (file_exists("upload/" . $_FILES["foto"]["name"])) {
    echo $_FILES["foto"]["name"] . "ya existe";
} else {
    move_uploaded_file($_FILES["foto"]["tmp_name"],"upload/" . $_FILES["foto"]["name"]);
    echo "<br>Imagen almacenada en: " . "upload/" . $_FILES["foto"]["name"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br>
    <img src="<?= "upload/" . $_FILES["foto"]["name"] ?>" width=150>
    <br>
    <a href="<?= "upload/" . $_FILES["foto"]["name"] ?>" download>Descargar</a>
    <br>
    <a href="cargar_fichero.php?imagen=<?=$_FILES["foto"]["name"] ?>">Eliminar</a>
    <br>
</body>
</html>