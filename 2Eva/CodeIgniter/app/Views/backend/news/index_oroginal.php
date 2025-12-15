<section>
    <h2><?= esc($title) ?></h2>
    <a id="create" href="<?= base_url('news/new')?>">Crear una noticia</a>
    <?php if ($news_list !== []): ?>

        <?php foreach ($news_list as $news_item): ?>
        
        <h3><?= esc($news_item['title']) ?></h3>
        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <h4>Category: <?= esc($news_item['category'])?></h4>
        <div style="display:flex;gap:10px;">
            <p><a href="<?= base_url('news/'.$news_item['slug'])?>">Ver Noticia</a></p>
            <p><a href="./news/del/<?= esc($news_item['id'], 'url')?>">Eliminar Noticia</a></p>
            <p><a href="./news/update/<?= esc($news_item['id'], 'url')?>">Actualizar Noticia</a></p>
        </div>
        
        
        <?php endforeach ?>

    <?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>