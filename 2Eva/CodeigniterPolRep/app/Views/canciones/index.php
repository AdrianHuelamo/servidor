<section>
    <p><a href="<?= base_url('canciones/new')?>">
            Create Canción
        </a></p>
    <?php if ($canciones_list !== []): ?>

    <?php foreach ($canciones_list as $canciones_item): ?>

    <h3><a href="<?= base_url('canciones/'.$canciones_item['id'])?>"><?= esc($canciones_item['titulo']) ?></a></h3>

    <h4>Artista: <?= esc ($canciones_item['nombre']) ?></h4>

    <!-- <p><a href="<?= base_url('canciones/'.$canciones_item['id'])?>">View Canción
        </a></p> -->
    <a href="<?= base_url('canciones/del/'.$canciones_item['id'])?>">Delete Canción</a>
    <a href="<?= base_url('canciones/update/'.$canciones_item['id'])?>">Update Canción</a>


    <?php endforeach ?>

    <?php else: ?>

    <h3>No Canciones</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>

</section>