<section>

    <a id="create" href="<?= base_url('cantantes')?>">Volver al listado de cantantes</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <form method="post" action="<?= base_url('cantantes')?>">
        <?= csrf_field() ?>

        <label for="nombre">Cantante Name</label>
        <input type="input" name="nombre" value="<?= set_value('nombre') ?>">
        <br>
        <br>
        
        <input id="create2" type="submit" name="submit" value="Create cantante item">
    </form>
</section>
