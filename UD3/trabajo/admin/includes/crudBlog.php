<?php
require_once 'database.php';

class Blog {
    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT b.*, u.nombre AS nombre_autor 
                FROM blog b 
                LEFT JOIN usuarios u ON b.id_autor = u.id_usuario 
                ORDER BY b.fecha DESC"; //
        
        $result = $conn->query($sql);
        $db->closeConnection($conn);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getPostById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM blog WHERE id_blog = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    public function insertarPost($titulo, $resumen, $contenido, $id_autor, $imagen_path) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO blog (titulo, resumen, contenido, id_autor, fecha, imagen) 
                VALUES (?, ?, ?, ?, ?, ?)"; //
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiss", $titulo, $resumen, $contenido, $id_autor, $fecha, $imagen_path);
        $exito = $stmt->execute();
        
        $db->closeConnection($conn);
        return $exito;
    }

    public function actualizarPost($id, $titulo, $resumen, $contenido, $imagen_path) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "UPDATE blog SET titulo = ?, resumen = ?, contenido = ?, imagen = ? WHERE id_blog = ?"; //
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $titulo, $resumen, $contenido, $imagen_path, $id);
        $exito = $stmt->execute();

        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarPost($id) {
        $db = new Connection();
        $conn = $db->getConnection();

        $post_a_borrar = $this->getPostById($id);
        if ($post_a_borrar && !empty($post_a_borrar['imagen'])) {
            $ruta_imagen = "../" . $post_a_borrar['imagen'];
            if (file_exists($ruta_imagen)) { 
                unlink($ruta_imagen);
            }
        }
        
        $sql = "DELETE FROM blog WHERE id_blog = ?"; //
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $stmt->close();

        $db->closeConnection($conn);
        return $exito;
    }
}
?>