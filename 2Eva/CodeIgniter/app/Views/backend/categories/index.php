<section>
    <h2><?= esc($title) ?></h2>
    <a id="create" href="<?= base_url('backend/categories/new')?>">Crear una categoria</a>
    <?php if ($categories_list !== []): ?>

    <?php foreach ($categories_list as $category_item): ?>

    <h3><?= esc($category_item['category']) ?></h3>
    <div style="display:flex;gap:10px;">
 
        <p><a href="./categories/del/<?= esc($category_item['id'], 'url')?>">Eliminar Categoria</a></p>
        <p><a href="./categories/update/<?= esc($category_item['id'], 'url')?>">Actualizar Categoria</a></p>
    </div>
    <?php endforeach ?>

    <p><a id="create" href="<?= base_url('backend')?>">Volver</a></p>
   
    <?php else: ?>

    <h3>No Categories</h3>

    <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>