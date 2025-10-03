<?php
$array = [];

$file = "productos.txt";
if (file_exists($file)){
    $fp = fopen($file, "r");
    while($linea = fgets($fp)){

        $array[] = list($clave, $precio, $cantidad) = explode(":", trim($linea));
    }
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
    fclose($fp);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border:1px solid black;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
        </tr>
        <?php foreach ($array as $producto):?>
        <tr>
            <td><?php echo $producto[0]?></td>
            <td><?php echo $producto[1]?></td>
            <td><?php echo $producto[2]?></td>
        </tr>
        <?php endforeach;?>
        
             <!-- 
                 $file = "productos.txt";
                 if (file_exists($file)){
                     $fp = fopen($file, "r");
                     while($linea = fgets($fp)){
                         list($clave, $precio, $cantidad) = explode(":", trim($linea));
                         echo "<tr>";
                         echo ("<td>$clave</td><td>$precio</td><td>$cantidad</td>");
                         echo "</tr>";
                     }
                     fclose($fp);
                 }
    -->

    </table>
</body>
</html>