<?php
// 1. Cargar auth y database
require_once 'admin/includes/auth.php'; //
require_once 'admin/includes/database.php'; //

// 2. PROTEGER
if (!estaLogueado() || $_SERVER["REQUEST_METHOD"] != "POST") { //
    header('Location: login.php?error=1'); //
    exit();
}

// 3. Recoger datos del formulario
$id_coche = $_POST['id_coche'];
$id_usuario = getUserId(); //
$precio_hora = (float)$_POST['precio_hora'];

// 4. Combinar fecha y hora en formato MySQL (DATETIME 'Y-m-d H:i:s')
// Las fechas del datepicker vienen como 'dd/mm/yyyy' y las horas como 'H:i'
try {
    // Fecha Inicio
    $fecha_inicio_obj = DateTime::createFromFormat('d/m/Y H:i', $_POST['fecha_inicio_fecha'] . ' ' . $_POST['fecha_inicio_hora']);
    $fecha_inicio_sql = $fecha_inicio_obj->format('Y-m-d H:i:00');
    $timestamp_inicio = $fecha_inicio_obj->getTimestamp();

    // Fecha Fin
    $fecha_fin_obj = DateTime::createFromFormat('d/m/Y H:i', $_POST['fecha_fin_fecha'] . ' ' . $_POST['fecha_fin_hora']);
    $fecha_fin_sql = $fecha_fin_obj->format('Y-m-d H:i:00');
    $timestamp_fin = $fecha_fin_obj->getTimestamp();
} catch (Exception $e) {
    // Error si el formato de fecha es incorrecto
    header('Location: reservar.php?id=' . $id_coche . '&error=fechas');
    exit();
}

// 5. Validar que la fecha de fin sea posterior a la de inicio
if ($timestamp_fin <= $timestamp_inicio) {
    header('Location: reservar.php?id=' . $id_coche . '&error=fechas');
    exit();
}

// 6. Conectar a la BD
$db = new Connection();
$conn = $db->getConnection();

// 7. CONSULTA DE CONFLICTO
// Comprueba si hay alguna reserva para ESE coche que se solape con mis fechas
$sql_check = "SELECT id_reserva FROM reservas
              WHERE id_coche = ?
              AND (
                  ? < fecha_fin AND ? > fecha_inicio
              )";

$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("iss", $id_coche, $fecha_inicio_sql, $fecha_fin_sql);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // ¡CONFLICTO! Hay una reserva que se solapa.
    $stmt_check->close();
    $db->closeConnection($conn);
    header('Location: reservar.php?id=' . $id_coche . '&error=conflicto');
    exit();

} else {
    // ¡LIBRE! Calcular coste e INSERTAR
    $stmt_check->close();
    
    // Calcular coste (simple, basado en horas)
    $diferencia_segundos = $timestamp_fin - $timestamp_inicio;
    $diferencia_horas = ceil($diferencia_segundos / 3600); // Redondear hacia arriba
    $coste_total = $diferencia_horas * $precio_hora;
    
    // Insertar la nueva reserva
    $sql_insert = "INSERT INTO reservas (id_usuario, id_coche, fecha_inicio, fecha_fin, coste_total)
                   VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iissd", $id_usuario, $id_coche, $fecha_inicio_sql, $fecha_fin_sql, $coste_total);
    
    if ($stmt_insert->execute()) {
        // ¡ÉXITO!
        $stmt_insert->close();
        $db->closeConnection($conn);
        header('Location: mis-reservas.php?exito=1');
        exit();
    } else {
        // Error general
        $stmt_insert->close();
        $db->closeConnection($conn);
        header('Location: reservar.php?id=' . $id_coche . '&error=general');
        exit();
    }
}
?>