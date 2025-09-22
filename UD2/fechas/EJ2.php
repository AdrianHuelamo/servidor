<?php
$fecha = new DateTime("2025-09-22");
$formato = new IntDateFormatter("es_ES", IntDateFormatter::FULL, IntDateFormatter::NONE);
echo $formato -> format($fecha);
?>