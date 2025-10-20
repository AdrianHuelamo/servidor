<?php
require_once("database.php");
class Usuarios {
    public function showUsuarios() {
        try {
            $sqlConnection = new Connection();
            $mySQL = $sqlConnection->getConnection();
            
            $sql = "SELECT * FROM usuarios";
            $result = $mySQL->query($sql);
            
            $sqlConnection->closeConnection($mySQL);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        } catch (Exception $e) {
            return [];
        }
    }

    public function getById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    public function getLibroById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT usuarios.*, categorias.categoria FROM usuarios
        LEFT JOIN categorias ON usuarios.id_categoria = categorias.id_categoria
        WHERE id_libro = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT usuarios.*, categorias.categoria FROM usuarios
        LEFT JOIN categorias ON usuarios.id_categoria = categorias.id_categoria
        ORDER BY titulo ASC";
        
        $result = $conn->query($sql);
        $db->closeConnection($conn);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function insertarLibro($titulo, $autor, $id_categoria, $precio, $fecha, $portada) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "INSERT INTO usuarios (titulo, autor, id_categoria, precio, fecha, portada, visitas) VALUES (?,?,?,?,?,?,0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidss", $titulo, $autor, $id_categoria, $precio, $fecha, $portada);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    public function actualizarLibro($id, $titulo, $autor, $id_categoria, $precio, $fecha, $portada) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "UPDATE usuarios SET titulo=?, autor=?, id_categoria=?, precio=?, fecha=?, portada=? WHERE id_libro=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidssi", $titulo,$autor,$id_categoria,$precio,$fecha,$portada,$id);
        $stmt->execute();

        $db->closeConnection($conn);
    }

    public function eliminarLibro($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $db->closeConnection($conn);
    }
}
?>
