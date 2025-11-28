<?php
$file = 'log.txt';

$mensaje = "usuarioha accedido al sistema";

$fecha = date('d/m/Y H:m:s');

$fp = fopen($file, "a");

fwrite($fp, "$fecha - $mensaje\n");

fclose($fp);

echo "Mensaje registrado en el log.";
?>