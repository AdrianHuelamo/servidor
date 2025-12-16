<section>
    <h2><?= esc($title) ?></h2>

    <a id="create" href="<?= base_url('news/')?>">Volver al listado de noticias</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form method="post" action="<?= base_url('backend/news/create')?>">
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input type="input" name="title" value="<?= set_value('title') ?>">
        <br>
        <br>

        <label for="body">Text</label>
        <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>
        <br>
        <br>

        <label for="category">Category</label>
        <select name="id_category">
            <?php if(! empty($category) && is_array($category)): ?>
                <?php foreach($category as $category_item):?>
                    <option value="<?= $category_item['id']?>">
                        <?= $category_item['category']?>
                    </option>
                <?php endforeach;?>
            <?php endif; ?>
        </select>
        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create news item">
    </form>
</section>
