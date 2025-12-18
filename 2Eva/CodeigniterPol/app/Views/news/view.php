<section>
    <h2>Título : <?= esc($news['title']) ?></h2>
    <p><?= esc($news['body']) ?></p>
    <p>Categoría :<?= esc($news['category']) ?></p>
    <a href="<?= base_url('news') ?>">Go to News</a>
</section>