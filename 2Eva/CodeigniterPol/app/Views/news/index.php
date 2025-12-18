<section>
    <h2><?= esc($title) ?></h2>
    <p><a href="<?= base_url('news/new')?>">
            Create New
        </a></p>
    <?php if ($news_list !== []): ?>

    <?php foreach ($news_list as $news_item): ?>

    <h3><?= esc($news_item['title']) ?></h3>

    <div class="main">
        <?= esc($news_item['body']) ?>
    </div>
    <h4>Categoría: <?= esc ($news_item['category']) ?></h4>
    <p><a href="<?= base_url('news/'.$news_item['slug'])?>">
            View article
        </a></p>
    <a href="<?= base_url('news/del/'.$news_item['id'])?>">Delete New</a>
    <a href="<?= base_url('news/update/'.$news_item['id'])?>">Update New</a>


    <?php endforeach ?>

    <?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>

</section>