<?php
$moda = [
    ["camiseta" , 22, 50 ] ,
    [ "pantalones" , 15, 00 ] ,
    [ "gorra" , 5, 9 ] ,
    [ "chaqueta" , 17, 95 ]
    ] ;

    for ($i=0; $i <= count($moda); $i++) {
        for ($a=0; $a <= count($moda[0]); $a++){
            echo $moda[$i][$a]. "<br>";
        }
    }
?>