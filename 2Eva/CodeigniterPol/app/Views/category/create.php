<section>
    <a href="<?= base_url('/category')?>">Volver a listado de categorías</a>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form action="<?= base_url('category') ?>" method="post">
        <?= csrf_field() ?>

        <label for="category">Category Name</label>
        <input type="input" name="category" value="<?= set_value('category') ?>" required>
        <br>
        <br>

        <input type="submit" name="submit" value="Create Category">
    </form>
</section>