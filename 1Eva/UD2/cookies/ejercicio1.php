<?php
$visitas= $_COOKIE['visitas'] ?? 0;

$visitas++;

setcookie('visitas',$visitas, [
    'expires' => time() + 3600,
    'path ' => '/',
    'samesite' => 'Lax',
]);

echo "<h2>Has visitado esta página $visitas veces</h2>";
?>