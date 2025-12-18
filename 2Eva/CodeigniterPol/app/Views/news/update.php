<section>
    <a href="<?= base_url('/news')?>">Volver a listado de noticias</a>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>
    <?php if (!empty($news) && is_array($news)) : ?>
    <form method="post" action=" <?= base_url('news/update/updated/' .$news['id']) ?>">
        <?= csrf_field() ?>

        <label for=" title">Title</label>
        <input type="input" name="title" value="<?= esc($news['title']) ?>">
        <br>

        <label for="body">Text</label>
        <textarea name="body" cols="45" rows="4"><?= esc($news['body']) ?></textarea>
        <br>
        <label for="category">Category</label>
        <select name="id_category">
            <?php if (! empty($category) && is_array($category)): ?>
            <?php foreach ($category as $category_item) :?>
            <option value="<?= $category_item["id"] ?>">
                <?= $category_item["category"] ?>
            </option>
            <?php endforeach ?>
            <?php endif ?>
        </select>
        <input type="submit" name="submit" value="Update item">
    </form>
    <?php endif; ?>
</section>