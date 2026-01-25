<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Editar Ejercicio</h2>
    <a href="<?= base_url('admin/ejercicios') ?>" class="btn btn-outline-secondary rounded-pill">
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

    <form action="<?= base_url('admin/ejercicios/update/' . $ejercicio['id']) ?>" method="post" enctype="multipart/form-data">
        
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Título</label>
                <input type="text" name="titulo" class="form-control" 
                       value="<?= old('titulo', $ejercicio['titulo']) ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Dificultad</label>
                <select name="dificultad" class="form-select">
                    <option value="Baja" <?= ($ejercicio['dificultad'] == 'Baja') ? 'selected' : '' ?>>Baja</option>
                    <option value="Media" <?= ($ejercicio['dificultad'] == 'Media') ? 'selected' : '' ?>>Media</option>
                    <option value="Alta" <?= ($ejercicio['dificultad'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Grupo Muscular</label>
                <select name="grupo_id" class="form-select" required>
                    <?php foreach ($grupos as $grupo): ?>
                        <option value="<?= $grupo['id'] ?>" 
                            <?= ($ejercicio['id_grupo'] == $grupo['id']) ? 'selected' : '' ?>>
                            <?= esc($grupo['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Imagen (Deja vacío para mantener la actual)</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                
                <?php if (!empty($ejercicio['imagen'])): ?>
                    <div class="mt-2">
                        <small class="text-muted">Imagen actual:</small>
                        <img src="<?= base_url('img/' . $ejercicio['imagen']) ?>" width="50" class="rounded border ms-2">
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="5" required><?= old('descripcion', $ejercicio['descripcion']) ?></textarea>
            </div>
            
            <div class="col-12">
                <div class="form-check form-switch p-3 bg-light rounded border">
                    <input class="form-check-input ms-0 me-3" type="checkbox" id="destacado" name="destacado" value="1" 
                           <?= ($ejercicio['destacado'] == 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="destacado">
                        Marcar como ejercicio <span class="text-warning">Destacado</span>
                    </label>
                    <div class="text-muted small">Los ejercicios destacados aparecerán en la portada de la web pública.</div>
                </div>
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