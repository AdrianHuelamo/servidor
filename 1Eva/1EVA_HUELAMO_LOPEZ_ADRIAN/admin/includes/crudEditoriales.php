<?php
require_once "database.php";

class Editoriales
{
    public function showEditoriales()
    {
        try {
            $sqlConnection = new Connection();
            $mySQL = $sqlConnection->getConnection();

            $sql = "SELECT * FROM editoriales"; 
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

        $sql="SELECT * FROM editoriales WHERE id_editorial = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    public function insertarEditorial($nombre,$telefono,$email){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="INSERT INTO editoriales (nombre_editorial,telefono,email) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis",$nombre,$telefono,$email);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    public function actualizarEditorial($id,$nombre,$telefono,$email){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="UPDATE editoriales SET nombre_editorial = ?,telefono = ?,email = ? WHERE id_editorial = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi",$nombre,$telefono,$email,$id);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }

    public function eliminarEditorial($id){
        $db = new Connection();
        $conn = $db->getConnection();

        $sql="DELETE FROM editoriales WHERE id_editorial = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        
        $db->closeConnection($conn);
    }
}