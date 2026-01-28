<section>

    <a id="create" href="<?= base_url('personajes/') ?>">Volver al listado de personajes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($personaje) && is_array($personaje)): ?>
        <form method="post" action="./updated/<?= esc($personaje['id']) ?>">
            <?= csrf_field() ?>

            <label for="nombre">Nombre</label>
            <input type="input" name="nombre" value="<?= esc($personaje['personaje_nombre']) ?>">
            <br>
            <br>

            <label for="pelicula">Pelicula</label>
            <select name="id_pelicula">
                <?php if (! empty($pelicula) && is_array($pelicula)): ?>
                    <?php foreach ($pelicula as $pelicula_item): ?>

                        <option value="<?= $pelicula_item['id'] ?>"
                            <?php
                            // Comparamos el ID de la película actual del bucle
                            // con el ID de la película que tiene el personaje ($personaje['id_pelicula'])
                            if ($pelicula_item['id'] == $personaje['id_pelicula']) {
                                echo 'selected';
                            }
                            ?>>
                            <?= $pelicula_item['titulo'] ?>
                        </option>

                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <br>
            <br>

            <input id="create2" type="submit" name="submit" value="Update item">
        </form>
    <?php endif; ?>
</section>