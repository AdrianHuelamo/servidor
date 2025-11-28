<?php
require_once("database.php");

class organizadores {
    // Mostrar todas las organizadores
    public function showorganizadores() {
        try {
            $sqlConnection = new Connection();
            $mySQL = $sqlConnection->getConnection();
            
            $sql = "SELECT * FROM organizadores";
            $result = $mySQL->query($sql);
            
            $sqlConnection->closeConnection($mySQL);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener una organizador por ID
    public function getById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM organizadores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    // Insertar una nueva organizador
    public function insertarorganizador($nombre, $email) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "INSERT INTO organizadores (nombre, email) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nombre, $email);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    // Actualizar una organizador existente
    public function actualizarorganizador($id, $nombre, $email) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "UPDATE organizadores SET nombre = ? , email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $email, $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    // Eliminar un organizador
    public function eliminarorganizador($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM organizadores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }
}
?>
