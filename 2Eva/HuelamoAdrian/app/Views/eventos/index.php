<section>
    <?php if ($eventos_list !== []): ?>

    <?php foreach ($eventos_list as $eventos_item): ?>

    <h3><?= esc($eventos_item['nombre']) ?></h3>
    <div class="main">
    </div>
    <span>Evento: </span><a href="<?= base_url('eventos/'.$eventos_item['id'])?>"><?= esc($eventos_item['nombre'])?></a >

    <?php endforeach ?>

    <?php else: ?>

    <h3>No Eventos</h3>

    <p>Unable to find any evetnos for you.</p>

    <?php endif ?>
</section>