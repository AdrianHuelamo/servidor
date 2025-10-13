<?php
require_once("database.php");
class Libros {
    public function getPopulares($limite = 4) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM libros ORDER BY visitas DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getRecientes($limite = 4) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM libros ORDER BY fecha DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getByCategoria($id_categoria) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM libros WHERE id_categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }
}
?>