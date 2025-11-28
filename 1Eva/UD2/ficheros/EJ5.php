<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$file = 'tareas.txt';
$tareas = ["Sacar la basura", "Limpiar", "Cocinar"];
$tarea ="";

$fp = fopen($file, 'a');
foreach ($tareas as $tarea){
    fwrite($fp, $tarea . "<br>");}
fclose($fp);


$tareas[] = "Poner la lavadora";
$fp = fopen($file, 'w');
foreach ($tareas as $tarea){
    fwrite($fp, $tarea . "<br>"); }
fclose($fp);

$fp = fopen($file, 'r');
$contenido = fread($fp, filesize($file));
fclose($fp);

echo "Contenido del archivo: <br>$contenido";
?>