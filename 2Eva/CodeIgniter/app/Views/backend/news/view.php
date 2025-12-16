<section>
    <h2><?= esc($news['title']) ?></h2>
    <p><?= esc($news['body']) ?></p>
    <p><b>Categoria: </b><?= esc($news['category']) ?></p>
    <img  src="<?= base_url('assets/img/'.$news['imagen'])?>" style="width: 35%">
    <p><a id="create" href="<?= base_url('backend')?>">Volver</a></p>
</section>
