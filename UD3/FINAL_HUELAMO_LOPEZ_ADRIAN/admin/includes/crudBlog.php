<?php
require_once 'database.php';

class Blog {

    public function getAll($conn) {
        $sql = "SELECT b.id_blog, b.titulo, b.fecha, b.imagen, u.nombre AS nombre_autor 
                FROM blog b 
                LEFT JOIN usuarios u ON b.id_autor = u.id_usuario 
                ORDER BY b.fecha DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        $posts = [];
        if ($result && $result->num_rows > 0) {
             while($post = $result->fetch_assoc()) {
                $post['username'] = $post['nombre_autor']; 
                $posts[] = $post;
            }
        }
        $stmt->close();
        return $posts;
    }

    public function getPostById($conn, $id) {
        $sql = "SELECT * FROM blog WHERE id_blog = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $datos = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $datos;
    }

    public function insertarPost($conn, $titulo, $resumen, $contenido, $id_autor, $imagen_path) {
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO blog (titulo, resumen, contenido, id_autor, fecha, imagen) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiss", $titulo, $resumen, $contenido, $id_autor, $fecha, $imagen_path);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }

    public function actualizarPost($conn, $id, $titulo, $resumen, $contenido, $imagen_path, $id_autor) {
        $sql = "UPDATE blog SET titulo = ?, resumen = ?, contenido = ?, imagen = ?, id_autor = ? 
                WHERE id_blog = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $titulo, $resumen, $contenido, $imagen_path, $id_autor, $id);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }

    public function eliminarPost($conn, $id) {
        $post_a_borrar = $this->getPostById($conn, $id);
        if ($post_a_borrar) {
            if (!empty($post_a_borrar['imagen']) && file_exists("../" . $post_a_borrar['imagen'])) {
                unlink("../" . $post_a_borrar['imagen']);
            }
        }

        $sql = "DELETE FROM blog WHERE id_blog = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }
}
?>