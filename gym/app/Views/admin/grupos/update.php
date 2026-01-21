<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Editar Grupo Muscular</h2>
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

    <form action="<?= base_url('admin/grupos/update/' . $grupo['id']) ?>" method="post" enctype="multipart/form-data">
        
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nombre del Grupo</label>
                <input type="text" name="nombre" class="form-control" 
                       value="<?= old('nombre', $grupo['nombre']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Imagen (Opcional)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <?php if (!empty($grupo['imagen'])): ?>
                    <div class="mt-2">
                        <small class="text-muted">Actual:</small>
                        <img src="<?= base_url('img/' . $grupo['imagen']) ?>" width="40" class="rounded border ms-2">
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4" required><?= old('descripcion', $grupo['descripcion']) ?></textarea>
            </div>
            
            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-warning fw-bold px-5 rounded-pill">
                    <i class="bi bi-save me-2"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>