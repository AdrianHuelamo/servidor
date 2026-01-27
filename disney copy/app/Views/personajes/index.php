<section>
    <a href="<?= base_url('personajes/new')?>">Crear un Personaje</a>
    <?php if ($personajes_list !== []): ?>

    <?php foreach ($personajes_list as $personajes_item): ?>

    <h3><?= esc($personajes_item['personaje_nombre']) ?></h3>
    <div class="main">
    </div>
    <h4>Pelicula: : <?= esc($personajes_item['pelicula_nombre'])?></h4>
    <div style="display:flex;gap:10px;">
        <p><a href="<?= base_url('personajes/'.$personajes_item['id'])?>">Ver Detalles</a></p>
        
    </div>


    <?php endforeach ?>

    <?php else: ?>

    <h3>No Personajes</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>