<?php
$log_file = 'error_log.txt';
$file = 'archivo_inexistente.txt';

// Intentar abrir el archivo
if (!file_exists($file)) {
    // Registrar el error en el log
    $fecha = date('d/m/Y H:i:s');
    $error_message = "$fecha - Error: El archivo $file no existe.\n";
    
    // Abrir el archivo de log en modo append
    $fp = fopen($log_file, 'a');
    fwrite($fp, $error_message);
    fclose($fp);
    
    echo "Error registrado en el archivo de log.";
} else {
    // Si el archivo existe, leer su contenido
    $fp = fopen($file, 'r');
    $contenido = fread($fp, filesize($file));
    fclose($fp);
    
    echo "Contenido del archivo: $contenido";

}