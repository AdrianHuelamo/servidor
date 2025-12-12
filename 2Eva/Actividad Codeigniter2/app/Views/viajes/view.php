<section>
    <h2><?= esc($viajes['viaje']) ?></h2>
    <p>Fecha: <?= esc($viajes['fecha']) ?></p>
    <p>Plazas: <?= esc($viajes['plazas']) ?></p>

    <div style="display:flex;gap:10px;">
        <p><a href="<?= base_url('viajes/del/'.$viajes['id'])?>">Eliminar Viaje</a></p>
        <p><a href="<?= base_url('viajes/update/'.$viajes['id'])?>">Editar Viaje</a></p>
    </div>

    <p><a href="<?= base_url('viajes')?>">Volver</a></p>
</section>
