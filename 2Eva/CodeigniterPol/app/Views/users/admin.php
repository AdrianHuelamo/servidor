<?php $session = session();?>
<?= "Bienvenid@" . $session->get('user')?>

<?php if (! empty($user) && is_array($user)): ?>
    <?php foreach ($user as $get_user): ?>
        <h3><?= esc($get_user['username']) ?></h3>
    <?php endforeach ?>

<?php else: ?>
    <h3>No Users</h3>
    <p>Unable to find any news for you.</p>
<?php endif ?>