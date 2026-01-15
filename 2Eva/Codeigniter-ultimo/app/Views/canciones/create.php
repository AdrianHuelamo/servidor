<section>

    <a id="create" href="<?= base_url('canciones/')?>">Volver al listado de noticias</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form method="post" action="<?= base_url('canciones')?>">
        <?= csrf_field() ?>

        <label for="nombre">Nombre</label>
        <input type="input" name="nombre" value="<?= set_value('nombre') ?>">
        <br>
        <br>

        <label for="cantante">Cantante</label>
        <select name="id_cantante">
            <?php if(! empty($nombre) && is_array($nombre)): ?>
                <?php foreach($nombre as $cantante_item):?>
                    <option value="<?= $cantante_item['id']?>">
                        <?= $cantante_item['nombre']?>
                    </option>
                <?php endforeach;?>
            <?php endif; ?>
        </select>
        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create news item">
    </form>
</section>
