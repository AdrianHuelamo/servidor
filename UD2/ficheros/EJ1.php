<?php
$file = 'contador.txt';

if (!file_exists($file)) {
    $contador = 0;
    $fp = fopen($file, 'w');
    fwrite($fp, $contador);
    fclose($fp);
}

$fp = fopen($file, 'r');
$contador = fread($fp, filesize($file));
fclose($fp);

$contador++;

$fp = fopen($file, 'w');
fwrite($fp, $contador);
fclose($fp);

echo "Esta página ha sido visitada $contador veces.";
?>