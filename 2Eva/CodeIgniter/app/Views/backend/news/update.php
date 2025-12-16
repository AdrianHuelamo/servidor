<section>
    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/5.3/examples/dashboard/"
    />
    <script src="<?= base_url('assets/js/color-modes.js')?>"></script>
    <link href="<?= base_url('assets/dist/css/bootstrap.min.css')?>" rel="stylesheet" />
    <meta name="theme-color" content="#712cf9" />
    <link href="<?= base_url('assets/css/dashboard.css')?>" rel="stylesheet" />
    
    <h2><?= esc($title) ?></h2>

    <a id="create" href="<?= base_url('backend')?>">Volver al listado de noticias</a><br><br><br>
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>

    <?php if (!empty($news) && is_array($news)):?>
    <form method="post" action="./updated/<?= esc($news['id']) ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input class="form-control form-control-lg" type="input" name="title" value="<?= esc($news['title']) ?>">
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Text</label>
            <textarea class="form-control" name="body" cols="45" rows="4"><?= esc($news['body']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="id_category" class="form-select">
                <?php if(! empty($category) && is_array($category)): ?>
                    <?php foreach($category as $category_item):?>
                        <option value="<?= $category_item['id']?>">
                            <?= $category_item['category']?>
                        </option>
                    <?php endforeach;?>
                <?php endif; ?>
        </select>
        </div>

        <input id="create2" type="submit" name="submit" value="Update item">
    </form>
    <?php endif; ?>
</section>