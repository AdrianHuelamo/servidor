<section>
    <a href="<?= base_url('/artistas')?>">Volver a listado de artistas</a>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>
    <?php if (!empty($artistas) && is_array($artistas)) : ?>
    <form method="post" action=" <?= base_url('artistas/update/updated/' .$artistas['id']) ?>">
        <?= csrf_field() ?>

        <label for=" title">Title</label>
        <input type="input" name="nombre" value="<?= esc($artistas['nombre']) ?>">
        <br>
        <input type="submit" name="submit" value="Update Artista">
    </form>
    <?php endif; ?>
</section>