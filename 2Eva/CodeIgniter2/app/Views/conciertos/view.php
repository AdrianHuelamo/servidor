<section>
<h2><?= esc($conciertos['nombre_concierto']) ?></h2>
<p><?= esc($conciertos['lugar']) ?></p>
<p><?= esc($conciertos['fecha']) ?></p>
<h4><?= esc($conciertos['precio']) ?></h4>
<p><a href="<?= base_url('conciertos')?>">Volver al listado de conciertos</a></p>
</section>