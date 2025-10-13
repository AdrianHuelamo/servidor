<?php
require_once("database.php");
class Categorias {
    public function showCategorias() {
        try {
            $sqlConnection = new Connection();
            $mySQL = $sqlConnection->getConnection();
            
            $sql = "SELECT * FROM categorias";
            $result = $mySQL->query($sql);
            
            $sqlConnection->closeConnection($mySQL);

            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
            
        } catch (Exception $e) {
            return [];
        }
    }
}
?>