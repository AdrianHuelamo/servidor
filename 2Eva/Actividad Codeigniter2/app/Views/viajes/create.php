<section>

    <a id="create" href="<?= base_url('viajes/')?>">Volver al listado de viajes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form method="post" action="<?= base_url('viajes')?>">
        <?= csrf_field() ?>

        <label for="viaje">Viaje</label>
        <input type="input" name="viaje" value="<?= set_value('viaje') ?>">
        <br>
        <br>

        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" value="<?= set_value('fecha') ?>">
        <br>
        <br>

        <label for="plazas">Plazas</label>
        <input type="number" name="plazas" value="<?= set_value('plazas') ?>">
        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create news item">
    </form>
</section>
