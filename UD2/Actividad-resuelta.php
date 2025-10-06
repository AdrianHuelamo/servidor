<?php
// Nombre del archivo: ACT2_APELLIDOS_NOMBRE.php

date_default_timezone_set("Europe/Madrid"); // Ajustamos zona horaria

$archivoComentarios = "comentarios.txt";
$archivoAdmin = "log_admin.txt";

// 1. Simulación de acceso
if (!isset($_POST['usuario'])) {
    // Mostrar formulario de acceso inicial
    ?>
    <form method="post">
        <label>Introduce tu nombre de usuario: </label>
        <input type="text" name="usuario" required>
        <button type="submit">Entrar</button>
    </form>
    <?php
    exit;
}

$usuario = trim($_POST['usuario']);

// Registrar acceso admin
if ($usuario === "admin") {
    $fecha = date("d/m/Y H:i:s");
    $f = fopen($archivoAdmin, "a");
    fwrite($f, "Admin accedió el $fecha\n");
    fclose($f);
}

// 2. Visualización de comentarios
echo "<h2>Bienvenido, $usuario</h2>";
echo "<h3>Comentarios existentes:</h3>";

if (file_exists($archivoComentarios)) {
    $f = fopen($archivoComentarios, "r");
    echo "<ol>";
    while (($linea = fgets($f)) !== false) {
        echo "<li>" . htmlspecialchars($linea) . "</li>";
    }
    echo "</ol>";
    fclose($f);
} else {
    echo "<p>No hay comentarios todavía.</p>";
}

// Si es admin, mostrar enlace para ver log_admin
if ($usuario === "admin") {
    echo "<form method='post'>
            <input type='hidden' name='usuario' value='admin'>
            <button type='submit' name='ver_log'>Ver log de accesos admin</button>
          </form>";
    if (isset($_POST['ver_log'])) {
        echo "<h3>Log de accesos admin:</h3>";
        if (file_exists($archivoAdmin)) {
            $f = fopen($archivoAdmin, "r");
            echo "<ul>";
            while (($linea = fgets($f)) !== false) {
                echo "<li>" . htmlspecialchars($linea) . "</li>";
            }
            echo "</ul>";
            fclose($f);
        } else {
            echo "<p>No hay registros de admin.</p>";
        }
    }
}

// 3. Añadir nuevos comentarios (solo usuarios estándar)
if ($usuario !== "admin") {
    if (isset($_POST['nuevo_comentario'])) {
        $comentario = trim($_POST['comentario']);
        if ($comentario !== "") {
            $fecha = date("d/m/Y H:i:s");
            $linea = "$usuario | $fecha | $comentario\n";
            $f = fopen($archivoComentarios, "a");
            fwrite($f, $linea);
            fclose($f);
            // Refrescar para que aparezca el comentario
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<p style='color:red;'>⚠️ El comentario no puede estar vacío.</p>";
        }
    }

    // Formulario para añadir comentarios
    ?>
    <h3>Añadir un comentario:</h3>
    <form method="post">
        <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
        <textarea name="comentario" rows="3" cols="40" required></textarea><br>
        <button type="submit" name="nuevo_comentario">Enviar comentario</button>
    </form>
    <?php
}
?>
