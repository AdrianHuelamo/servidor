<section>
    <h2><?= esc($news['title']) ?></h2>
    <p><?= esc($news['body']) ?></p>
    <p> <img src="<?= base_url('assets/img/'.$news['imagen'])?>"></p>
    <p><a href="<?= base_url('news')?>">Volver</a></p>
</section>
