<section>
    <p><a href="<?= base_url('artistas/new')?>">
            Create New
        </a></p>
    <?php if ($artistas_list !== []): ?>

    <?php foreach ($artistas_list as $artistas_item): ?>

    <h3><?= esc($artistas_item['nombre']) ?></h3>

    <a href="<?= base_url('artistas/del/'.$artistas_item['id'])?>">Delete New</a>
    <a href="<?= base_url('artistas/update/'.$artistas_item['id'])?>">Update New</a>

    <?php endforeach ?>

    <?php else: ?>

    <h3>No artistas</h3>

    <p>Unable to find any artistas for you.</p>

    <?php endif ?>

</section>