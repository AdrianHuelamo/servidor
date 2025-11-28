<?php
$fecha = new DateTime("2024-09-30");
$formato = new IntlDateFormatter("es_ES", IntlDateFormatter::FULL, IntlDateFormatter::NONE);
echo $formato -> format($fecha);
?>