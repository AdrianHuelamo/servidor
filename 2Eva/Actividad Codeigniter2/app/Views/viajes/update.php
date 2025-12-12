<section>
    <h2><?= esc($title) ?></h2>

    <a id="create" href="<?= base_url('viajes/')?>">Volver al listado de viajes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($viajes) && is_array($viajes)):?>
    <form method="post" action="./updated/<?= esc($viajes['id']) ?>">
        <?= csrf_field() ?>

        <label for="viaje">Viaje</label>
        <input type="input" name="viaje" value="<?= esc($viajes['viaje']) ?>">
        <br>
        <br>

        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" value="<?= esc($viajes['fecha']) ?>">
        <br>
        <br>

        <label for="plazas">Plazas</label>
        <input type="number" name="plazas" value="<?= esc($viajes['plazas']) ?>">
        <br>
        <br>

        <input id="create2" type="submit" name="submit" value="Update item">
    </form>
    <?php endif; ?>
</section>