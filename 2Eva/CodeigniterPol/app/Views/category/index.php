<section>
    <h2><?= esc($title) ?></h2>

    <?php if (session()->getFlashdata('success')): ?>
    <p style="color: green; font-weight: bold;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= base_url('category/new')?>">
            Create New Category
        </a>
    </p>

    <?php if (!empty($category_list) && is_array($category_list)): ?>

    <?php foreach ($category_list as $category_item): ?>

    <div>
        <h3><?= esc($category_item['category']) ?></h3>

        <p>
            <a href="<?= base_url('category/update/'.$category_item['id'])?>">Update</a>
            |
            <a href="<?= base_url('category/del/'.$category_item['id'])?>">
                Delete
            </a>
        </p>
    </div>

    <?php endforeach ?>

    <?php else: ?>

    <h3>No Categories Found</h3>

    <p>There are no categories in the database yet.</p>

    <?php endif ?>

</section>