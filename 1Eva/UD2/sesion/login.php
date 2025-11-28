<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_valido = "admin";
$clave_valida = "1234";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"] ?? "";
    $clave = $_POST["clave"] ?? "";

    if ($usuario === $usuario_valido && $clave === $clave_valida) {
        $_SESSION["usuario"] = $usuario;
        session_regenerate_id(); // Previene fijaciÃ³n de sesiÃ³n 
        header("Location: admin/index.php");
        exit;
    } else {
        echo "Credenciales incorrectas.";
    }
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
    <?php include "menu.php"; ?>
    <hr>
    <?php
    if(isset($_GET['cerrar_sesion'])){
    echo "Sesión cerrado correctamente";
    }?>
    <h1>Bienvenidos a DAWAZON</h1>
<form method="post">
    Usuario: <input type="text" name="usuario"><br><br>
    Clave: <input type="password" name="clave"><br><br>
    <input type="submit" value="Entrar">
</form>
</body>
</html>