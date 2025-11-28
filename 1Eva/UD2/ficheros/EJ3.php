<?php
$file = 'config.txt';

if (file_exists($file)) {
$fp = fopen($file, 'r');

while($linea = fgets($fp)){
    list($clave, $valor) = explode('=', trim($linea));
    echo "Clave: $clave, Valor: $valor<br>";
}
fclose($fp);
} else {
    echo "El archivo de configuración no existe.";
} 
?>