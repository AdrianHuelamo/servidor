<?php
require_once "database.php";
class Usuarios
{
    public function showUsuarios()
    {
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

    public function getById($id){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="SELECT * FROM usuarios WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    public function insertarUsuario($nombre,$apellidos,$email,$username,$password){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="INSERT INTO usuarios (nombre,apellidos,email,username,password) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss",$nombre,$apellidos,$email,$username,$password);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    public function actualizarUsuario($id,$nombre,$apellidos,$email,$username){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, username = ? WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi",$nombre,$apellidos,$email,$username,$id);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    public function actualizarPassword($id,$password){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="UPDATE usuarios SET password = ? WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si",$password,$id);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    public function eliminarUsuario($id){
        $db = new Connection();
        $conn = $db->getConnection();
        $sql="DELETE FROM usuarios WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }
}