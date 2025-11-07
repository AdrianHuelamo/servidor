<?php
// admin/includes/auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogueado() {
    return isset($_SESSION['id_usuario']);
}

function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

function esEditor() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'editor';
}

function esUser() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'user';
}

function puedeEditar() {
    return esAdmin() || esEditor();
}

function getNombreUsuario() {
    return $_SESSION['nombre'] ?? 'Invitado';
}

function getUserId() {
    return $_SESSION['id_usuario'] ?? null;
}

function getRol() {
    return $_SESSION['rol'] ?? null;
}

function cerrarSesion() {
    session_destroy();
    header("Location: ../index.php");  // Redirige a la raíz pública
    exit();
}
?>
