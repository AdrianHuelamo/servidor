<?php
include_once("database.php");

$usuarios = [
    ['Laura', 'Martínez Pérez', 'laura.martinez@example.com', 'lauram', '1234'],
    ['Carlos', 'García López', 'carlos.garcia@example.com', 'cgarcia', '1234'],
    ['Ana', 'Rodríguez Núñez', 'ana.rodriguez@example.com', 'anar', '1234'],
    ['Mariluz', 'Ruiz', 'mariluz@solvam.es', 'mluz', '1234']
];

$db = new Connection();
$conn = $db->getConnection();

foreach ($usuarios as $u) {
    $nombre = $u[0];
    $apellidos = $u[1];
    $email = $u[2];
    $username = $u[3];
    $password = password_hash($u[4], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellidos, email, username, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellidos, $email, $username, $password);
    $stmt->execute();
}

echo "Usuarios insertados correctamente";
$db->closeConnection($conn);
?>
