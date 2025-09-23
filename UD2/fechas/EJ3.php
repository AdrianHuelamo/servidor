<?php
$fecha = new DateTime("2024-09-30");
$formato = new IntlDateFormatter("es_ES", IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
echo $formato -> format($fecha);
?>