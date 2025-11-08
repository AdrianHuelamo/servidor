<?php

require_once 'auth.php'; 

if (!estaLogueado()) {
    header('Location: ../login.php?error=1'); 
    exit();
}

if (!puedeEditar()) { 
    header('Location: ../index.php');
    exit();
}
?>