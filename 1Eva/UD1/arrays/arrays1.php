<!-- Ejercicio 1. Crea un array asociativo de 3 elementos. A continuación,

a. Muestra por pantalla el segundo elemento

b. Recorre el array mostrando todos los elementos por pantalla -->

<?php

$peso = ["borja" => "50", "adrian" => "72", "joselu" => "68"];

echo "El peso del segundo elemento es ".$peso["adrian"] ."<br>";

foreach ($peso as $clave => $valor) {
    echo $clave ." " .$valor ."<br>";
}


?>