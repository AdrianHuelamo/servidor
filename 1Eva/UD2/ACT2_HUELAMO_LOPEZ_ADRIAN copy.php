<?php 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$mostrarFormulario = TRUE;
$usuario ="";
$adminfile = "log_admin.txt";
$comentarios = "comentarios.txt";
$registro = "Registro fecha: " . date ("d-m-Y H:i:s") . "\n";
$array = [];
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario =  test_input($_POST["usuario"] ?? []);
    $mostrarFormulario = FALSE;
    if ($usuario == "admin") {
        if (!file_exists($adminfile)) {
        $fp = fopen($adminfile, 'w');
        fwrite($fp, $registro);
        fclose($fp);
        } else {
            $fp = fopen($adminfile, 'a');
            fwrite($fp, $registro);
            fclose($fp);
        }
    }
    if (file_exists($comentarios)){
        $fp = fopen($comentarios, "r");
        while($linea = fgets($fp)){
            $array[] = list($usuario, $fecha, $comentario) = explode(" | ", trim($linea));
        }
        fclose($fp);
    } else {
        $fp = fopen($comentarios, 'w');
        fclose($fp);
    }
    if ($usuario !== "admin") {
        $com = test_input($_POST["com"] ?? []);
        $contenido = $usuario . " | " . date ("d-m-Y H:i:s") . " | " . $com . "\n";
        $fp = fopen($comentarios, "a");
        fwrite($fp, $contenido);
        fclose($fp);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACT2_HUELAMO_LOPEZ_ADRIAN</title>
</head>
<body>
    <?php if ($mostrarFormulario){ ?>
    <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >
        <label>Introduce tu usuario: <input type="text" name="usuario" value="nombre_del_usuario"></label><br>
        <input type="submit" value="Enviar">
    </form>
    <?php } else { ?>
        <p>Bienvenido usuario: <?php echo $usuario ?></p>
        <p>La fecha actual es: <?php echo date ("d-m-Y H:i:s") ?></p>
        <?php } ?>
        <?php foreach ($array as $comentario):?>
        <tr>
            <th>Comentarios: </th><br>
            <td>Usuario: <?php echo $comentario[0]?></td><br>
            <td>Fecha: <?php echo $comentario[1]?></td><br>
            <td>Comentario: <?php echo $comentario[2]?></td>
        </tr>
        <?php endforeach;
    if ($usuario !=="") {
        if ($usuario !== "admin") { ?>
             <form action="<?php echo (htmlentities($_SERVER["PHP_SELF"]))?>" method="post" >
             <label>Introduce un comentario: <input type="text" name="com" value="Introduce un comentario"></label><br>
             <input type="submit" value="Enviar">
             </form>
    <?php }} ?>
    
</body>
</html>