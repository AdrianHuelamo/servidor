<?php
$visitas= $_COOKIE['visitas'] ?? 0;

$visitas++;

setcookie('visitas',$visitas, [
    'expires' => time() + 3600,
    'path' => '/',
    'samesite' => 'Lax',
]);

if ($visitas == 1){
    echo "<h2>Primera vez que visitas la página</h2>";
}else {
    echo "Ya has visitado la página más de una vez";
}

?>