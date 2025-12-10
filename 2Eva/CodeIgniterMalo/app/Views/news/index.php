<section>
<h2><?= esc($title) ?></h2>

<p><a href="<?= base_url('news/new')?>">Crear Noticia</a></p>

<?php if ($news_list !== []): ?>
    <?php foreach ($news_list as $news_item): ?>
        <h3><?= esc($news_item['title']) ?></h3>
        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <div class="main">
            Categoria: <b><?= esc($news_item['category']) ?></b>
        </div>
        <p>
            <a href="<?= base_url('news/'.$news_item['slug'])?>">View</a>
            <a href="<?= base_url('news/update/'.$news_item['id'])?>">Edit</a>
            <a href="<?= base_url('news/del/'.$news_item['id'])?>">Delete</a>
        </p>

    <?php endforeach ?>

<?php else: ?>
    <h3>No News</h3>
    <p>Unable to find any news for you.</p>
<?php endif ?>
</section>