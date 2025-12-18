<section>
    <a href="<?= base_url('/category')?>">Volver a listado de categorías</a>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($category) && is_array($category)) : ?>
    <form method="post" action="<?= base_url('category/update/' . $category['id']) ?>">
        <?= csrf_field() ?>

        <label for="category">Category Name</label>
        <input type="input" name="category" value="<?= set_value('category', esc($category['category'])) ?>" required>
        <br>
        <br>

        <input type="submit" name="submit" value="Update Category">
    </form>
    <?php else: ?>
    <p>No se encontraron datos de la categoría para editar.</p>
    <?php endif; ?>
</section>