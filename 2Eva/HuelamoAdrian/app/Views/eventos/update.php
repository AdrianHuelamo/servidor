<section>

    <a id="create" href="<?= base_url('eventos/')?>">Volver al listado de eventos</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($eventos) && is_array($eventos)):?>
    <form method="post" action="./updated/<?= esc($eventos['id']) ?>">
        <?= csrf_field() ?>

        <label for="nombre">Nombre</label>
        <input type="input" name="nombre" value="<?= esc('nombre') ?>">
        <br>
        <br>

        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" value="<?= set_value('fecha') ?>">
        <br>
        <br>

        <label for="aforo">Aforo</label>
        <input type="numbre" name="aforo" value="<?= set_value('aforo') ?>">
        <br>
        <br>

        <label for="ciudades">Ciudades</label>
        <select name="id_ciudades">
            <?php if(! empty($ciudades) && is_array($ciudades)): ?>
                <?php foreach($ciudades as $ciudades_item):?>
                    <option value="<?= $ciudades_item['id']?>">
                        <?= $ciudades_item['nombre']?>
                    </option>
                <?php endforeach;?>
            <?php endif; ?>
        </select>
        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create eventos item">
    </form>
    <?php endif; ?>
</section>