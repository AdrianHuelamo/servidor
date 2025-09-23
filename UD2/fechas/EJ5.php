<?php
$fecha = new DateTime("30-09-2025");
$formato = new IntlDateFormatter("es_ES", IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
echo $formato -> format($fecha);
?>