<section>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form action="<?= base_url('artistas') ?>" method="post">
        <?= csrf_field() ?>

        <label for="nombre">Nombre del Artista</label>
        <input type="input" name="nombre" value="<?= set_value('nombre') ?>">
        <br>

        <input type="submit" name="submit" value="Create Artista">
    </form>
</section>