<?php
//importar clase para llamar a las funciones de categorias
require_once "./admin/includes/crudCategorias.php";

//instanciar clase categorias
$categoriaObj = new Categorias();

$categorias = $categoriaObj->showCategorias();

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="logo.png" alt="Logo" height="40">
        </a>
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Acceso privado</a></li>
        </ul>
    </div>
</nav>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Menú lateral de categorías -->
        <aside class="col-md-3">
            <h4>Categorías</h4>
            <ul class="list-group">
                <?php foreach ($categorias as $categoria_item) : ?>
                    <li class="list-group-item">
                        <a href="index.php?cat=<?=$categoria_item['id_categoria']?>" class="text-decoration-none">
                            <?= $categoria_item['categoria']?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </aside>