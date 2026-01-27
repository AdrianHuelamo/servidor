<section>
    <a id="create" href="<?= base_url('personajes/')?>">Volver al listado de personajes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form method="post" action="<?= base_url('personajes')?>">
        <?= csrf_field() ?>

        <label for="nombre">Nombre</label>
        <input type="input" name="nombre" value="<?= set_value('nombre') ?>">
        <br>
        <br>

        <label for="pelicula">Pelicula</label>
        <select name="id_pelicula">
            <?php if(! empty($pelicula) && is_array($pelicula)): ?>
                <?php foreach($pelicula as $pelicula_item):?>
                    <option value="<?= $pelicula_item['id']?>">
                        <?= $pelicula_item['titulo']?>
                    </option>
                <?php endforeach;?>
            <?php endif; ?>
        </select>
        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create news item">
    </form>
</section>
