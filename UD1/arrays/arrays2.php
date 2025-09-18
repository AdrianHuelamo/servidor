<!-- Ejercicio 2. Crea un array indexado de 3 elementos. A continuación,

a. Muestra por pantalla el segundo elemento

b. Recorre el array mostrando todos los elementos por pantalla -->

<?php
$pilotos = ["alonso", "sainz", "verstapen"];

echo "El segundo elemento es " .$pilotos[1] ."<br>";

foreach ($pilotos as $piloto) {
    echo $piloto ."<br>";
}
?>