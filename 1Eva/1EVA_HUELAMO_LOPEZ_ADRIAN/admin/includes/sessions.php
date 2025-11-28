<?php
require_once("database.php");

class Sessions
{
    public function comprobarCredenciales($username, $password)
    {
        $db = new Connection();
        $conn = $db->getConnection();

        $sql = "SELECT * FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuario = $result->fetch_assoc();
        $db->closeConnection($conn);

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        return null;
    }

    private function log($user)
    {
        $username = $user['username'];
        $fecha = date("d-m-Y H:i:sa");
        $registro = "[$fecha]: $username ha cerrado sesión en el sistema.\n";

        $file = "../../logs/actividad.log";
        $fp = fopen($file, "a");
        fwrite($fp, $registro);
        fclose($fp);
    }
    public function crearSesion($usuario)
    {
        session_start();
        $_SESSION['usuario'] = $usuario;
        //$this->log($usuario);
    }

    public function comprobarSesion()
    {
        session_start();
        return isset($_SESSION['usuario']);
    }

    public function cerrarSesion()
    {
        session_start();
        $usuario = $_SESSION['usuario'];
        $this->log($usuario);
        session_destroy();

    }
}
?>