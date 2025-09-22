<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


function tiempoTarea(){
$tiempo = 15;
echo "Tarda $tiempo minutos<br>";
}

function acumularTiempo(){
global $tiempoTotal;
$tiempoTotal += 15;
echo "Tarda un tiempo total de $tiempoTotal minutos<br>";
}

function contarTareas(){
static $contarTareas = 0;
$contarTareas++;
echo "Hace un total de $contarTareas taras<br><br>";
}

$tiempoTotal = 0;

tiempoTarea();
acumularTiempo();
contarTareas();

tiempoTarea();
acumularTiempo();
contarTareas();

tiempoTarea();
acumularTiempo();
contarTareas();
?>