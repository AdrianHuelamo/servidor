<?php
$moda = [
    ["camiseta" , 22, 50 ] ,
    [ "pantalones" , 15, 00 ] ,
    [ "gorra" , 5, 9 ] ,
    [ "chaqueta" , 17, 95 ]
    ] ;

    foreach ($moda as $elemento) {
        foreach ($elemento as $valor){
            echo ($valor . "<br>");
        }
    }
?>
