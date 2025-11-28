<?php
$fecha = new DateTime("30-09-2025");
$fecha2 = clone $fecha;
$fecha2->modify('+2 days');
echo $fecha2->format('d-m-Y');
?>