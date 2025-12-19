<section>
    <h2>Nombre : <?= esc($eventos['nombre']) ?></h2>
    <p>Fecha :<?= esc($eventos['fecha']) ?></p>
    <p>Aforo :<?= esc($eventos['aforo']) ?></p>
    <p>Ciudad :<?= esc($eventos['ciudad_nombre']) ?></p>
    <p><a href="<?= base_url('eventos/del/'.$eventos_item['id'])?>">Eliminar Evento</a></p>
    <p><a href="<?= base_url('/eventos/update/'.$eventos_item['id'])?>">Actualizar Evento</a></p>
    <a href="<?= base_url('eventos') ?>">Volver</a>
</section>