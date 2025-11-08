<?php
require_once 'database.php';

class Marcas {
    public function getAll($conn) {
        $sql = "SELECT * FROM marcas ORDER BY nombre ASC";
        $result = $conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getMarcaById($conn, $id) {
        $sql = "SELECT * FROM marcas WHERE id_marca = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $datos;
    }

    public function insertarMarca($conn, $nombre) {
        $sql = "INSERT INTO marcas (nombre) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }

    public function actualizarMarca($conn, $id, $nombre) {
        $sql = "UPDATE marcas SET nombre = ? WHERE id_marca = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }

    public function eliminarMarca($conn, $id_marca) {
        $sql_check = "SELECT COUNT(*) as total FROM coches WHERE id_categoria = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id_marca);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if ($result_check['total'] > 0) {
            throw new Exception("No se puede eliminar: " . $result_check['total'] . " coche(s) está(n) usando esta marca.");
        }

        $sql_delete = "DELETE FROM marcas WHERE id_marca = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id_marca);
        $exito = $stmt_delete->execute();
        $stmt_delete->close();
        return $exito;
    }
}
?>