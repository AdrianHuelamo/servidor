<?php
require_once 'database.php';

class Usuarios {

    public function getAll($conn, $id_admin_actual) {
        $sql = "SELECT id_usuario, nombre, username, correo, rol 
                FROM usuarios 
                WHERE id_usuario != ? AND rol != 'super' 
                ORDER BY nombre ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_admin_actual);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $username, $correo, $rol);
        
        $usuarios = [];
        while ($stmt->fetch()) {
            $usuarios[] = [
                'id_usuario' => $id,
                'nombre' => $nombre,
                'username' => $username,
                'correo' => $correo,
                'rol' => $rol
            ];
        }
        $stmt->close();
        return $usuarios;
    }

    public function getUserById($conn, $id) {
        $sql = "SELECT id_usuario, nombre, username, correo, telefono, rol, imagen, bio 
                FROM usuarios WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result(); 
        $datos = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $datos;
    }

    public function cambiarRol($conn, $id_usuario, $nuevo_rol, $id_admin_actual) {
        if (!in_array($nuevo_rol, ['user', 'editor', 'admin'])) {
            return false;
        }

        $sql = "UPDATE usuarios SET rol = ? 
                WHERE id_usuario = ? 
                AND id_usuario != ? 
                AND rol != 'super'";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $nuevo_rol, $id_usuario, $id_admin_actual);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }

    public function eliminarUsuario($conn, $id_usuario, $id_admin_actual) {
        $usuario_a_borrar = $this->getUserById($conn, $id_usuario);

        if (!$usuario_a_borrar || $usuario_a_borrar['id_usuario'] == $id_admin_actual || $usuario_a_borrar['rol'] == 'super') {
            return false;
        }

        $ruta_imagen = "../" . $usuario_a_borrar['imagen'];
        if (!empty($usuario_a_borrar['imagen']) && $usuario_a_borrar['imagen'] != 'images/autores/default.png' && file_exists($ruta_imagen)) {
            unlink($ruta_imagen);
        }

        $sql = "DELETE FROM usuarios 
                WHERE id_usuario = ? 
                AND id_usuario != ? 
                AND rol != 'super'";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_admin_actual);
        $stmt->execute();
        
        $exito = $stmt->affected_rows > 0;
        $stmt->close();
        return $exito;
    }
    
    public function actualizarPerfil($conn, $id_usuario, $nombre, $correo, $telefono, $bio, $imagen_path) {
        $sql = "UPDATE usuarios SET nombre = ?, correo = ?, telefono = ?, bio = ?, imagen = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $correo, $telefono, $bio, $imagen_path, $id_usuario);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }
    
    public function actualizarPassword($conn, $id_usuario, $pass_actual, $pass_nueva) {
        $sql_pass = "SELECT password FROM usuarios WHERE id_usuario = ?";
        $stmt_pass = $conn->prepare($sql_pass);
        $stmt_pass->bind_param("i", $id_usuario);
        $stmt_pass->execute();
        $stmt_pass->bind_result($hashed_password);
        $stmt_pass->fetch();
        $stmt_pass->close();

        if (password_verify($pass_actual, $hashed_password)) {
            $password_hash = password_hash($pass_nueva, PASSWORD_BCRYPT);

            $sql_update_pass = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";
            $stmt_update = $conn->prepare($sql_update_pass);
            $stmt_update->bind_param("si", $password_hash, $id_usuario);
            $exito = $stmt_update->execute();
            $stmt_update->close();
            return $exito;
        } else {
            throw new Exception("La contraseña actual es incorrecta.");
        }
    }

    public function getAutores($conn) {
        $sql = "SELECT id_usuario, nombre FROM usuarios 
                WHERE rol = 'admin' OR rol = 'editor' OR rol = 'super'
                ORDER BY nombre ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id_usuario, $nombre);
        
        $autores = [];
        while ($stmt->fetch()) {
            $autores[] = [
                'id_usuario' => $id_usuario,
                'nombre' => $nombre
            ];
        }
        $stmt->close();
        return $autores;
    }
}
?>