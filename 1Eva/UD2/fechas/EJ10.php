<?php
$inicio = new DateTime('2024-10-01');
$fin = new DateTime('2024-12-31');

$intervalo = new DateInterval('P2W');
$periodo = new DatePeriod($inicio, $intervalo, $fin);

foreach ($periodo as $fecha) {
    echo $fecha->format('d-F-Y') . "<br>";
}
?> 