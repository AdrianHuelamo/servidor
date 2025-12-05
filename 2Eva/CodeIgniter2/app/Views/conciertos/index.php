<section>

<?php if ($conciertos_list !== []): ?>
    <?php foreach ($conciertos_list as $conciertos_item): ?>
        <h3><a href="<?= base_url('conciertos/show')?>"><?= esc($conciertos_item['nombre_concierto']) ?></a></h3>
        <div class="main">
            <p>Fecha: <?= esc($conciertos_item['fecha']) ?></p>
        </div><br>


    <?php endforeach ?>

<?php else: ?>
    <h3>No conciertos</h3>
    <p>Unable to find any conciertos for you.</p>
<?php endif ?>
</section>