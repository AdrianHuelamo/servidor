<?php
// 1. Cargar el sistema de autenticación
// (auth.php está en el mismo directorio 'includes')
require_once 'auth.php'; 

// 2. Si no está logueado -> A la calle (al login)
if (!estaLogueado()) {
    // Redirige al login de la parte pública con el mensaje de error
    header('Location: ../login.php?error=1'); 
    exit();
}

// 3. Si ES un 'user' normal -> A la calle (al inicio)
// (Solo 'admin' y 'editor' pueden entrar aquí)
if (!puedeEditar()) { // puedeEditar() comprueba si es admin O editor
    // Redirige a la página de inicio pública
    header('Location: ../index.php');
    exit();
}
?>