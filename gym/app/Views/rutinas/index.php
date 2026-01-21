<div class="container py-5">
    
    <div class="d-flex align-items-center mb-5">
        <div>
            <h1 class="fw-bold mb-0">Mis <span class="text-warning">Rutinas</span></h1>
            <p class="text-muted mb-0">Organiza tus entrenamientos semanales</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
    <?php endif; ?>

    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-light">
                <h5 class="fw-bold mb-3">Crear Nueva Rutina</h5>
                <form action="<?= base_url('rutinas/create') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Pecho y Tríceps" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Descripción (Opcional)</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Objetivo de hipertrofia..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold">Crear Rutina</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <?php if (!empty($rutinas)): ?>
                <div class="list-group shadow-sm">
                    <?php foreach ($rutinas as $rutina): ?>
                        <a href="<?= base_url('rutinas/show/' . $rutina['id']) ?>" class="list-group-item list-group-item-action p-4 border-0 border-bottom">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 fw-bold text-dark"><?= esc($rutina['nombre']) ?></h5>
                                    <p class="mb-1 text-muted small"><?= esc($rutina['descripcion'] ?? 'Sin descripción') ?></p>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill">
                                    <i class="bi bi-chevron-right"></i> Ver / Editar
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info py-4 text-center">
                    Aún no has creado ninguna rutina. ¡Crea la primera a la izquierda!
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>