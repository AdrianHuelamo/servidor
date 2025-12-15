<section>
    <h2><?= esc($title) ?></h2>

    <a id="create" href="<?= base_url('categories/')?>">Volver al listado de categorias</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form method="post" action="<?= base_url('categories')?>">
        <?= csrf_field() ?>

        <label for="category">Category Name</label>
        <input type="input" name="category" value="<?= set_value('category') ?>">
        <br>
        <br>

        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create category item">
    </form>
</section>
