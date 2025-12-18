<section>
    <h2><?= esc($title) ?></h2>

    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>
    <a href="../public">Volver </a>
    <br><br><br>
    <h1>
        <?= esc($error) ?></h1>
    <form action="./login" method="post">
        <?= csrf_field() ?>

        <label for="username">Usuario</label>
        <input type="input" name="username" value="<?= set_value('username') ?>">
        <br>

        <label for="password">Password</label>
        <input type="password" name="password" value="<?= set_value('password') ?>">>
        <br>

        <input type="submit" name="submit" value="Iniciar Sesión">
    </form>
</section>