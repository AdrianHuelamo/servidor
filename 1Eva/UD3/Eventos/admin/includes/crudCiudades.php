<?php
require_once("database.php");

class Ciudades {
    // Mostrar todas las ciudades
    public function showCiudades() {
        try {
            $sqlConnection = new Connection();
            $mySQL = $sqlConnection->getConnection();
            
            $sql = "SELECT * FROM ciudades";
            $result = $mySQL->query($sql);
            
            $sqlConnection->closeConnection($mySQL);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener una ciudad por ID
    public function getById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM ciudades WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    // Insertar una nueva ciudad
    public function insertarCiudad($nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "INSERT INTO ciudades (ciudad) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    // Actualizar una ciudad existente
    public function actualizarCiudad($id, $nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "UPDATE ciudades SET ciudad = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    // Eliminar una ciudad
    public function eliminarCiudad($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM ciudades WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }
}
?>
