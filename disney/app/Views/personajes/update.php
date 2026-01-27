<section>

    <a id="create" href="<?= base_url('personajes/')?>">Volver al listado de personajes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($personajes) && is_array($personajes)):?>
    <form method="post" action="./updated/<?= esc($personajes['id']) ?>">
        <?= csrf_field() ?>

        <label for="nombre">Nombre</label>
        <input type="input" name="nombre" value="<?= esc($personaje['personaje_nombre']) ?>">
        <br>
        <br>

        <label for="pelicula">Pelicula</label>
        <select name="id_pelicula">
            <?php if(! empty($nombre) && is_array($nombre)): ?>
            <?php foreach($nombre as $pelicula_item):?>
            <option value="<?= $pelicula_item['id']?>">
                <?= $pelicula_item['nombre']?>
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