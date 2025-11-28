<?php
require_once 'database.php';

class Reservas {

    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT r.*, 
                       c.nombre AS coche_nombre, c.imagen AS coche_imagen, 
                       u.nombre AS usuario_nombre, u.correo AS usuario_correo
                FROM reservas r
                JOIN coches c ON r.id_coche = c.id_coche
                JOIN usuarios u ON r.id_usuario = u.id_usuario
                ORDER BY r.fecha_inicio DESC";
        
        $result = $conn->query($sql);
        $db->closeConnection($conn);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function eliminarReserva($id_reserva) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM reservas WHERE id_reserva = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_reserva);
        $exito = $stmt->execute();
        $stmt->close(); 
        $db->closeConnection($conn);
        return $exito;
    }
    
    public function getReservasPorUsuario($conn, $id_usuario) {
        $sql = "SELECT r.*, c.nombre AS coche_nombre, c.imagen AS coche_imagen, m.nombre AS marca_nombre
                FROM reservas r
                JOIN coches c ON r.id_coche = c.id_coche
                JOIN marcas m ON c.id_categoria = m.id_marca
                WHERE r.id_usuario = ?
                ORDER BY r.fecha_inicio DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $reservas = [];
        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                $reservas[] = $fila;
            }
        }
        $stmt->close();
        return $reservas;
    }
    
    public function cancelarReservaUsuario($conn, $id_reserva, $id_usuario) {
        $sql_cancel = "DELETE FROM reservas WHERE id_reserva = ? AND id_usuario = ?";
        $stmt_cancel = $conn->prepare($sql_cancel);
        $stmt_cancel->bind_param("ii", $id_reserva, $id_usuario);
        $stmt_cancel->execute();
        $filas_afectadas = $stmt_cancel->affected_rows;
        $stmt_cancel->close();
        return $filas_afectadas > 0;
    }
    
    public function crearReserva($conn, $id_coche, $id_usuario, $fecha_inicio_obj, $fecha_fin_obj) {
        $fecha_inicio_sql = $fecha_inicio_obj->format('Y-m-d H:i:00');
        $fecha_fin_sql = $fecha_fin_obj->format('Y-m-d H:i:00');

        $sql_check = "SELECT id_reserva FROM reservas
                      WHERE id_coche = ?
                      AND ( ? < fecha_fin AND ? > fecha_inicio )";

        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("iss", $id_coche, $fecha_inicio_sql, $fecha_fin_sql);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();

        if ($result_check->num_rows > 0) {
            throw new Exception("conflicto");
        }
        
        $sql_precios = "SELECT precio_hora, precio_dia, precio_mes FROM coches WHERE id_coche = ?";
        $stmt_precios = $conn->prepare($sql_precios);
        $stmt_precios->bind_param("i", $id_coche);
        $stmt_precios->execute();
        $precios_coche = $stmt_precios->get_result()->fetch_assoc();
        $stmt_precios->close();

        $precio_h = (float)$precios_coche['precio_hora'];
        $precio_d = (float)$precios_coche['precio_dia'];
        $precio_m = (float)$precios_coche['precio_mes'];

        $coste_total = 0;
        
        $inicio_dia_puro = new DateTime($fecha_inicio_obj->format('Y-m-d'));
        $fin_dia_puro = new DateTime($fecha_fin_obj->format('Y-m-d'));
        $dias_naturales = $inicio_dia_puro->diff($fin_dia_puro)->days;
        
        $total_segundos = $fecha_fin_obj->getTimestamp() - $fecha_inicio_obj->getTimestamp();
        $total_horas_reales = ceil($total_segundos / 3600);
        
        if ($total_horas_reales >= (30*24) && $precio_m > 0) {
            $meses_completos = floor($total_horas_reales / (30*24));
            $coste_total = $meses_completos * $precio_m;
            
            $horas_restantes = $total_horas_reales % (30*24);
            $dias_restantes = floor($horas_restantes / 24);
            $coste_total += $dias_restantes * $precio_d;
            
            $horas_sueltas = $horas_restantes % 24;
            $coste_total += $horas_sueltas * $precio_h;
            
        } elseif ($dias_naturales == 0) {
            $coste_total = $total_horas_reales * $precio_h;
            if ($precio_d > 0 && $coste_total > $precio_d) {
                $coste_total = $precio_d;
            }
        } else {
            $coste_total = $dias_naturales * $precio_d;
            
            $hora_inicio = (int)$fecha_inicio_obj->format('H');
            $hora_fin = (int)$fecha_fin_obj->format('H');
            
            if ((int)$fecha_fin_obj->format('i') > (int)$fecha_inicio_obj->format('i')) {
                $hora_fin += 1;
            }

            $horas_extra = $hora_fin - $hora_inicio;
            
            if ($horas_extra > 0) {
                $coste_horas_extra = $horas_extra * $precio_h;
                
                if ($precio_d > 0 && $coste_horas_extra > $precio_d) {
                    $coste_total += $precio_d;
                } else {
                    $coste_total += $coste_horas_extra;
                }
            }
        }
        
        if ($precio_m > 0 && $coste_total > $precio_m) {
            $coste_total = $precio_m;
        }

        $sql_insert = "INSERT INTO reservas (id_usuario, id_coche, fecha_inicio, fecha_fin, coste_total)
                       VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iissd", $id_usuario, $id_coche, $fecha_inicio_sql, $fecha_fin_sql, $coste_total);
        $exito = $stmt_insert->execute();
        $stmt_insert->close();
        return $exito;
    }
}
?>