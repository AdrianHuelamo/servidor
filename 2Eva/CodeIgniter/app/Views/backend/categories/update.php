<section>
    <h2><?= esc($title) ?></h2>

    <a id="create" href="<?= base_url('categories/')?>">Volver al listado de categorias</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($category) && is_array($category)):?>
    <form method="post" action="./updated/<?= esc($category['id']) ?>">
        <?= csrf_field() ?>

        <label for="category">Name</label>
        <input type="input" name="category" value="<?= esc($category['category']) ?>">
        <br>
        <br>

        

        <input id="create2" type="submit" name="submit" value="Update item">
    </form>
    <?php endif; ?>
</section>