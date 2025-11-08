<?php
class Sessions {   
    public function comprobarCredenciales($usuario, $clave) {
        require_once 'database.php';
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 1) {
            $datos = $resultado->fetch_assoc();
            
            if (password_verify($clave, $datos['password'])) {
                $stmt->close();
                $db->closeConnection($conn);
                return $datos;
            }
        }
        
        $stmt->close();
        $db->closeConnection($conn);
        return false;
    }
    
    public function crearSesion($datos) {
        $_SESSION['id_usuario'] = $datos['id_usuario'];
        $_SESSION['username'] = $datos['username'];
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['correo'] = $datos['correo'];
        $_SESSION['telefono'] = $datos['telefono'];
        $_SESSION['rol'] = $datos['rol'];

        $_SESSION['imagen'] = $datos['imagen'];
        $_SESSION['bio'] = $datos['bio'];
    }
    
    public function comprobarSesion() {
        return isset($_SESSION['id_usuario']);
    }
    
    public function cerrarSesion() {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }
    
    public function esAdmin() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }
    
    public function esEditor() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'editor';
    }
    
    public function esUser() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'user';
    }
    
    public function puedeEditar() {
        return $this->esAdmin() || $this->esEditor();
    }
}
?>