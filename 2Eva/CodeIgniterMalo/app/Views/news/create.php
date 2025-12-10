<section>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form  method="post" action="<?= base_url('insert_news')?>">
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input type="input" name="title" value="<?= set_value('title') ?>">
        <br><br>

        <label for="body">Text</label>
        <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>
        <br><br>

        <label for="category">Category</label>
        <select name="id_category">
            <?php if(!empty($category) && is_array($category)) : ?>
                <?php foreach ($category as $category_item) : ?>
                    <option value="<?= $category_item['id']?>">
                        <?= $category_item['category']?>
                    </option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
        <br><br>

        <input type="submit" name="submit" value="Create news item">
    </form>
</section>