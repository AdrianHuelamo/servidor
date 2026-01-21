<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Nuevo Grupo Muscular</h2>
    <a href="<?= base_url('admin/grupos') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card border-0 shadow-sm p-4">
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/grupos/create') ?>" method="post" enctype="multipart/form-data">
        
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nombre del Grupo</label>
                <input type="text" name="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Ej: Pectoral" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4" required><?= old('descripcion') ?></textarea>
            </div>
            
            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-success fw-bold px-5 rounded-pill">
                    <i class="bi bi-plus-circle me-2"></i> Crear Grupo
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>