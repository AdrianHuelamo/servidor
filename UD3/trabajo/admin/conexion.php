<?php

$conexion=new mysqli("localhost","root","","nintendo");

if ($conexion->connect_error)
die('No se ha podido conectar a la base de datos');