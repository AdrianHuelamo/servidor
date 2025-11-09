<?php
require_once 'database.php';

class Coches {

    public function getMarcas($conn) {
        $sql = "SELECT id_marca, nombre FROM marcas ORDER BY nombre ASC";
        $result = $conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAll($conn) {
        $sql = "SELECT c.*, m.nombre AS marca_nombre 
                FROM coches c 
                JOIN marcas m ON c.id_categoria = m.id_marca 
                ORDER BY c.id_coche DESC";
        $result = $conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById($conn, $id) {
        $sql = "SELECT * FROM coches WHERE id_coche = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $datos;
    }

    private function checkDuplicado($conn, $nombre, $id_categoria, $id_coche = null) {
        $sql = "SELECT id_coche FROM coches WHERE nombre = ? AND id_categoria = ?";
        $types = "si";
        $params = [$nombre, $id_categoria];

        if ($id_coche !== null) {
            $sql .= " AND id_coche != ?";
            $types .= "i";
            $params[] = $id_coche;
        }

        $stmt = $conn->prepare($sql);
        
        $bind_args = [$types];
        foreach ($params as $key => &$param) {
            $bind_args[] = &$params[$key];
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_args);
        
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        
        return $num_rows > 0;
    }

    public function insertarCoche($conn, $datos, $imagen_path) {
        if ($this->checkDuplicado($conn, $datos['nombre'], $datos['id_categoria'])) {
            throw new Exception("Ya existe un coche con ese nombre para esa marca.");
        }
        
        $sql = "INSERT INTO coches (nombre, id_categoria, año, precio_hora, precio_dia, precio_mes, imagen, kilometros, transmision, asientos, maletero, combustible) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "siiiiisisiis",
            $datos['nombre'],
            $datos['id_categoria'],
            $datos['año'],
            $datos['precio_hora'],
            $datos['precio_dia'],
            $datos['precio_mes'],
            $imagen_path,
            $datos['kilometros'],
            $datos['transmision'],
            $datos['asientos'],
            $datos['maletero'],
            $datos['combustible']
        );
        $exito = $stmt->execute();
        $stmt->close();
        
        if (!$exito) {
            throw new Exception("Error de la base de datos: " . $conn->error);
        }
        return $exito;
    }

    public function actualizarCoche($conn, $id_coche, $datos, $imagen_path) {
        if ($this->checkDuplicado($conn, $datos['nombre'], $datos['id_categoria'], $id_coche)) {
            throw new Exception("Ya existe otro coche con ese nombre para esa marca.");
        }
        
        $sql = "UPDATE coches SET 
                nombre = ?, id_categoria = ?, año = ?, 
                precio_hora = ?, precio_dia = ?, precio_mes = ?, 
                imagen = ?, kilometros = ?, transmision = ?, 
                asientos = ?, maletero = ?, combustible = ? 
                WHERE id_coche = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "siiiiisisiisi",
            $datos['nombre'],
            $datos['id_categoria'],
            $datos['año'],
            $datos['precio_hora'],
            $datos['precio_dia'],
            $datos['precio_mes'],
            $imagen_path,
            $datos['kilometros'],
            $datos['transmision'],
            $datos['asientos'],
            $datos['maletero'],
            $datos['combustible'],
            $id_coche
        );
        $exito = $stmt->execute();
        $stmt->close();
        
        if (!$exito) {
            throw new Exception("Error de la base de datos: " . $conn->error);
        }
        return $exito;
    }

    public function eliminarCoche($conn, $id_coche) {
        $coche_a_borrar = $this->getById($conn, $id_coche);
        if ($coche_a_borrar) {
            $ruta_imagen = "../" . $coche_a_borrar['imagen'];
            if (!empty($coche_a_borrar['imagen']) && file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }
        
        $sql = "DELETE FROM coches WHERE id_coche = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_coche);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }
}
?>