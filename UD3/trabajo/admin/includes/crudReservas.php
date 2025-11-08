<?php
require_once 'database.php'; //

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
                ORDER BY r.fecha_inicio DESC"; //
        
        $result = $conn->query($sql);
        $db->closeConnection($conn);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function eliminarReserva($id_reserva) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM reservas WHERE id_reserva = ?"; //
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_reserva);
        $exito = $stmt->execute();

        $db->closeConnection($conn);
        return $exito;
    }
    
}
?>