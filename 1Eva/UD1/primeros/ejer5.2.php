<?Php

function sumar() {
global $numero1;
global $numero2;
$numero1 = $numero1 + 1;
$numero2 = $numero2 - 2;
return $resultado = $numero1 + $numero2;
}

$numero1 = 5;
$numero2 = 7;


echo"la suma de $numero1 + $numero2 es ". sumar();
?>