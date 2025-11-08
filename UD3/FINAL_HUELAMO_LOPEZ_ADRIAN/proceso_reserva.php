<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'admin/includes/auth.php';
require_once 'admin/includes/database.php';
require_once 'admin/includes/crudReservas.php';

if (!estaLogueado() || $_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: login.php?error=1');
    exit();
}

$id_coche = $_POST['id_coche'];
$id_usuario = getUserId();
$reservasObj = new Reservas();

$db = new Connection();
$conn = $db->getConnection();

try {
    $fecha_inicio_obj = DateTime::createFromFormat('d/m/Y H:i', $_POST['fecha_inicio_fecha'] . ' ' . $_POST['fecha_inicio_hora']);
    $fecha_fin_obj = DateTime::createFromFormat('d/m/Y H:i', $_POST['fecha_fin_fecha'] . ' ' . $_POST['fecha_fin_hora']);

    if (!$fecha_inicio_obj || !$fecha_fin_obj) {
        throw new Exception("fechas_formato");
    }

    if ($fecha_fin_obj <= $fecha_inicio_obj) {
        throw new Exception("fechas_orden");
    }

    if ($reservasObj->crearReserva($conn, $id_coche, $id_usuario, $fecha_inicio_obj, $fecha_fin_obj)) {
        $db->closeConnection($conn);
        header('Location: mis-reservas.php?exito=1');
        exit();
    } else {
        throw new Exception("general");
    }

} catch (Exception $e) {
    $db->closeConnection($conn);
    $error_tipo = $e->getMessage();
    
    if ($error_tipo == 'conflicto') {
        header('Location: reservar.php?id=' . $id_coche . '&error=conflicto');
    } elseif ($error_tipo == 'fechas_orden' || $error_tipo == 'fechas_formato') {
        header('Location: reservar.php?id=' . $id_coche . '&error=fechas');
    } else {
        header('Location: reservar.php?id=' . $id_coche . '&error=general');
    }
    exit();
}
?>