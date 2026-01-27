<section>
    <a href="<?= base_url('personajes/new')?>">Crear un Personaje</a>
    <?php if ($canciones_list !== []): ?>

    <?php foreach ($canciones_list as $canciones_item): ?>

    <h3><?= esc($canciones_item['cancion_nombre']) ?></h3>
    <div class="main">
    </div>
    <h4>Cantante: <?= esc($canciones_item['cantante_nombre'])?></h4>
    <div style="display:flex;gap:10px;">
        <p><a href="<?= base_url('canciones/'.$canciones_item['id'])?>">Ver Cancion</a></p>
        <p><a href="./canciones/del/<?= esc($canciones_item['id'], 'url')?>">Eliminar Cancion</a></p>
        <p><a href="./canciones/update/<?= esc($canciones_item['id'], 'url')?>">Actualizar Cancion</a></p>
    </div>


    <?php endforeach ?>

    <?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>