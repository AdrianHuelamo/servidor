<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
//incluir la conexion

include "./admin/conexion.php";
$ver_categoria = $conexion -> query("SELECT genero, codigo FROM generos;") or die ($conexion->error) ;
$mostrar_videojuegos = $conexion -> query("SELECT videojuegos.imagen, videojuegos.nombre, sagas.nombre, generos.genero FROM videojuegos JOIN sagas ON videojuegos.saga = sagas.codigo JOIN generos ON videojuegos.genero = generos.codigo ORDER BY videojuegos.codigo LIMIT 5;
");
$consolas_vendidas = $conexion -> query("SELECT imagen, nombre, año_lanzamiento, ventas FROM `consolas` ORDER BY `consolas`.`ventas` DESC LIMIT 3;") or die ($conexion->error) ;


//Si la URL tiene la variable id_categoria
if (isset($_GET["id_genero"])){
    //recoger variable de URL
    $id_genero = $_GET["id_genero"];


    //ejecutamos Select de libros de la categoria $id_categoria
    $mostrar_generos = $conexion->query( "SELECT * FROM videojuegos JOIN consolas on videojuegos.consola = consolas.codigo JOIN sagas on videojuegos.saga = sagas.codigo JOIN generos ON videojuegos.genero = generos.codigo WHERE videojuegos.genero = $id_genero;") or die ($conexion->error) ;
} 

else {
    //ejecutamos SELECT de libros
    $mostrar_generos = $conexion->query( "SELECT * FROM videojuegos JOIN consolas on videojuegos.consola = consolas.codigo JOIN sagas on videojuegos.saga = sagas.codigo JOIN generos ON videojuegos.genero = generos.codigo") or die ($conexion->error) ;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NINTENDO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>NINTENDO</h1>
            <nav>
            <ul>
            <?php
                while($fila = $ver_categoria->fetch_array()){
                    $genero = $fila[0];
                    $id_genero = $fila [1];
            ?>
                
                    <li><a href="generos.php?id_genero=<?php echo $id_genero;?>"><?php echo $genero;?></a></li>
            <?php } //end while?>
            </ul>
            </nav>
        </div>
    </header>

    <section class="banner">
        <div class="container">
            <img src="./img/portada.jpg" alt="Banner Principal">
            </div>
    </section>

    <section class="highlight-section">
        <h2>Consolas más vendidas</h2>
        <div class="container"> <div class="featured-items">
            <?php
                while($fila = $consolas_vendidas->fetch_array()){
                    $imagen = $fila[0];
                    $consola = $fila[1];
                    $año = $fila[2];
                    $ventas = $fila[3];
                ?>
                <article class="featured-item">
                    <img src="./img/<?php echo $imagen ?>" alt="Imagen Producto 1">
                    <h4><?php echo $consola ?></h4>
                    <p class="meta-info release-date">Lanzamiento: <?php echo $año ?></p>
                    <p class="meta-info sales-data">Ventas: <?php echo $ventas ?> unidades</p>
                    </article>
                <?php } //end while?>
            </div></div></section>

    <div class="main-container container">

        <main class="main-content">
            <h2>Videojuegos</h2>

            <section class="news-container">
            <?php
            while($fila = $mostrar_generos->fetch_array()){
                    $imagen = $fila[2];
                    $videojuego = $fila[1];
                    $saga = $fila[12];
                    $genero = $fila[16];
                ?>
                <article class="news-item">
                    <img src="./img/<?php echo $imagen ?>" alt="Imagen de la noticia 1">
                    <div class="news-content">
                        <h3><?php echo $videojuego ?></h3>
                        <p class="meta-info">Perteneciente a la saga de: <?php echo $saga ?></p>
                        <p>Videojuego del genero de: <?php echo $genero ?></p>
                    </div>
                </article>
                <?php } //end while?>
                </section>
        </main>

        <aside class="sidebar">
            <div class="widget">
                <h4>Filtrar por:</h4>
                <ul>
                <?php
                include "menu.php" 
                    ?>
                </ul>
                </div>

            <div class="widget">
                <h4>Publicidad</h4>
                <div class="ad-placeholder">
                    <img src="./img/portada.jpg" alt="Publicidad">
                    <p align="center">5 de junio a la venta</p>
                    </div>
            </div>

             
        </aside>

    </div> <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Mi Sitio Web. Todos los derechos reservados.</p>
             </div>
    </footer>

</body>
</html>