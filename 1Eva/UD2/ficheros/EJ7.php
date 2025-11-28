<?php
$archivo = __DIR__ . '/productos.txt';

if (!file_exists($archivo)) {
    $handle = fopen($archivo, 'w');
    fclose($handle);
}

$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr>
        <th>Nombre del Producto</th>
        <th>Precio (€)</th>
        <th>Cantidad Disponible</th>
      </tr>";

foreach ($lineas as $linea) {
    $datos = preg_split('/\s+/', trim($linea));
    if (count($datos) === 3) {
        list($nombre, $precio, $cantidad) = $datos;
        echo "<tr>
                <td>" . htmlspecialchars($nombre) . "</td>
                <td>" . number_format((float)$precio, 2, ',', '.') . "</td>
                <td>" . (int)$cantidad . "</td>
              </tr>";
    }
}

echo "</table>";
?>