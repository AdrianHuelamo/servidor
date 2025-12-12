<section>
    <?php if ($viajes_list !== []): ?>

    <ul>
    <?php foreach ($viajes_list as $viajes_item): ?>
        <li>
            <p><a href="<?= base_url('viajes/'.$viajes_item['id'])?>"><?= esc($viajes_item['viaje']) ?></a></p>
        </li>
    <?php endforeach ?>
    </ul>

    <?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>