<section>
    <h2><?= esc($personajes['personaje_nombre']) ?></h2>
    <h3><?= esc($personajes['pelicula_nombre']) ?></h3>

    <p><a href="./personajes/del/<?= esc($personajes['id'], 'url')?>">Eliminar personaje</a></p>
    <p><a href=<?= base_url('personajes/update/'.$personajes['id'])?>>Actualizar personaje</a></p>

    <p><a href="<?= base_url('personajes')?>">Volver</a></p>
</section>