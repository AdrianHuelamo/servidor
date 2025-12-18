<section>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form action="<?= base_url('canciones') ?>" method="post">
        <?= csrf_field() ?>

        <label for=" titulo">Title</label>
        <input type="input" name="titulo" value="<?= set_value('titulo') ?>">
        <br>


        <label for="nombre">Nombre del Artista</label>
        <select name="id_artista">
            <?php if (! empty($artistas) && is_array($artistas)): ?>
            <?php foreach ($artistas as $artistas_item) :?>
            <option value="<?= $artistas_item["id"] ?>">
                <?= $artistas_item["nombre"] ?>
            </option>
            <?php endforeach ?>
            <?php endif ?>
        </select>
        <br>
        <br>

        <input type="submit" name="submit" value="Create Cancion item">
    </form>
</section>