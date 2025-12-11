<section>

    <a id="create" href="<?= base_url('canciones/')?>">Volver al listado de noticias</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($canciones) && is_array($canciones)):?>
    <form method="post" action="./updated/<?= esc($canciones['id']) ?>">
        <?= csrf_field() ?>

        <label for="nombre">Nombre</label>
        <input type="input" name="nombre" value="<?= esc($canciones['cancion_nombre']) ?>">
        <br>
        <br>

        <label for="cantante">Cantante</label>
        <select name="id_cantante">
            <?php if(! empty($nombre) && is_array($nombre)): ?>
            <?php foreach($nombre as $category_item):?>
            <option value="<?= $category_item['id']?>">
                <?= $category_item['nombre']?>
            </option>
            <?php endforeach;?>
            <?php endif; ?>
        </select>
        <br>
        <br>

        <input id="create2" type="submit" name="submit" value="Update item">
    </form>
    <?php endif; ?>
</section>