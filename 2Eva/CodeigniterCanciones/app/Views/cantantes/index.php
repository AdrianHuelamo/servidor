<section>
    <a id="create" href="<?= base_url('cantantes/new')?>">Crear un Cantante</a>
    <?php if ($cantantes_list !== []): ?>

    <?php foreach ($cantantes_list as $cantante_item): ?>

    <h3><?= esc($cantante_item['nombre']) ?></h3>
    <div style="display:flex;gap:10px;">
 
        <p><a href="<?= base_url('cantantes/del/'.$cantante_item['id'])?>">Eliminar Cantante</a></p>
        <p><a href="<?= base_url('cantantes/update/'.$cantante_item['id'])?>">Actualizar Cantante</a></p>
    </div>


    <?php endforeach ?>

    <?php else: ?>

    <h3>No Categories</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>