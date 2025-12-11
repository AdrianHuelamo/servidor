<section>

    <a id="create" href="<?= base_url('cantantes')?>">Volver al listado de cantantes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($cantante) && is_array($cantante)):?>
    <form method="post" action="<?= base_url('cantantes/update/updated/'.$cantante['id']) ?>">
        <?= csrf_field() ?>

        <label for="nombre">Name</label>
        <input type="input" name="nombre" value="<?= esc($cantante['nombre']) ?>">
        <br>
        <br>

        

        <input id="create2" type="submit" name="submit" value="Update item">
    </form>
    <?php endif; ?>
</section>