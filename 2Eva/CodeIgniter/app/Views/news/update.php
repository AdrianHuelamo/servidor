<section>
    <p><a href="<?= base_url('news')?>">Volver al listado de noticias</a></p>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if(!empty($news) && is_array($news)) : ?>
    <form  method="post" action="<?= base_url('news/update/updated/'.$news['id'])?>">
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input type="input" name="title" value="<?= esc($news['title']) ?>">
        <br><br>

        <label for="body">Text</label>
        <textarea name="body" cols="45" rows="4"><?= esc($news['body']) ?></textarea>
        <br><br>

        <input type="submit" name="submit" value="update item">
    </form>
    <?php endif ?>
</section>