<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Editar Noticia</h2>
    <a href="<?= base_url('admin/noticias') ?>" class="btn btn-outline-secondary rounded-pill">
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

    <form action="<?= base_url('admin/noticias/update/' . $noticia['id']) ?>" method="post" enctype="multipart/form-data">
        
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Título</label>
                <input type="text" name="titulo" class="form-control" 
                       value="<?= old('titulo', $noticia['titulo']) ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Fecha de Publicación</label>
                <input type="date" name="fecha_publicacion" class="form-control" 
                       value="<?= old('fecha_publicacion', $noticia['fecha_publicacion']) ?>" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Resumen</label>
                <input type="text" name="resumen" class="form-control" 
                       value="<?= old('resumen', $noticia['resumen']) ?>" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Imagen (Opcional)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <?php if (!empty($noticia['imagen'])): ?>
                    <div class="mt-2">
                        <small class="text-muted">Actual:</small>
                        <img src="<?= base_url('img/' . $noticia['imagen']) ?>" width="60" class="rounded border ms-2">
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Contenido Completo</label>
                <textarea name="contenido" class="form-control" rows="8" required><?= old('contenido', $noticia['contenido']) ?></textarea>
            </div>
            
            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-warning fw-bold px-5 rounded-pill text-dark">
                    <i class="bi bi-save me-2"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>