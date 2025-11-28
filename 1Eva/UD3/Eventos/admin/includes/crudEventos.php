<?php
require_once("database.php");

class Eventos {
    // Mostrar todos los eventos
    public function showEventos() {
        try {
            $sqlConnection = new Connection();
            $mySQL = $sqlConnection->getConnection();
            
            // Consulta con JOIN para mostrar también el nombre de la ciudad
            $sql = "SELECT e.*, c.ciudad 
                    FROM eventos e
                    INNER JOIN ciudades c ON e.id_ciudad = c.id";
            $result = $mySQL->query($sql);
            
            $sqlConnection->closeConnection($mySQL);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener un evento por su ID
    public function getById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM eventos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    // Insertar un nuevo evento
    public function insertarEvento($evento, $fecha, $aforo, $id_ciudad) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "INSERT INTO eventos (evento, fecha, aforo, id_ciudad) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $evento, $fecha, $aforo, $id_ciudad);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    // Actualizar un evento existente
    public function actualizarEvento($id, $evento, $fecha, $aforo, $id_ciudad) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "UPDATE eventos 
                SET evento = ?, fecha = ?, aforo = ?, id_ciudad = ?
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $evento, $fecha, $aforo, $id_ciudad, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    // Eliminar un evento
    public function eliminarEvento($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM eventos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }
}
?>
