<?Php

// Crea la función que sume 2 números y devuelva el resultado
function sumar($a, $b) {
return $a + $b;
}

// Define las variables para los dos números y asígnales un valor
$numero1 = 1;
$numero2 = 2;

// Define una variable que llame a la función
$resultado = sumar($numero1,$numero2);

/* Muestra por pantalla un mensaje tipo " La suma de 3 + 6 es : 9"

Los 3 números del ejemplo anterior tienen que ser variables */

echo "La suma de $numero1 + $numero2 es $resultado";

?>