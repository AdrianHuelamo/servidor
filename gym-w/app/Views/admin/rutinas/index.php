<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Gestión de Rutinas</h2>
</div>

<div class="card border-0 shadow-sm p-3 mb-4 bg-light">
    <form action="" method="get" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold small text-muted">Filtrar por Usuario:</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-person-search"></i></span>
                <select name="user_id" class="form-select border-start-0" onchange="this.form.submit()">
                    <option value="">Ver todas las rutinas</option>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= ($usuario_seleccionado == $user['id']) ? 'selected' : '' ?>>
                                <?= esc($user['username']) ?> (<?= esc($user['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        
        <?php if (!empty($usuario_seleccionado)): ?>
            <div class="col-auto">
                <a href="<?= base_url('admin/rutinas') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar filtro
                </a>
            </div>
        <?php endif; ?>
    </form>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Usuario (Creador)</th>
                    <th>Nombre Rutina</th>
                    <th>Descripción</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rutinas)): ?>
                    <?php foreach ($rutinas as $rutina): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold"><?= esc($rutina['username']) ?></div>
                                    <small class="text-muted"><?= esc($rutina['email']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-primary">
                            <?= esc($rutina['nombre']) ?>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?= esc(substr($rutina['descripcion'] ?? '', 0, 50)) ?>...
                            </small>
                        </td>
                        <td class="text-end pe-4">
                            <a href="<?= base_url('admin/rutinas/delete/' . $rutina['id']) ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Eliminar la rutina de este usuario? Esta acción es irreversible.');">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-search display-4 d-block mb-3 opacity-25"></i>
                        No se encontraron rutinas para este filtro.
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>