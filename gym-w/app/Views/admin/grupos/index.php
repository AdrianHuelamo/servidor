<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Grupos Musculares</h2>
    <a href="<?= base_url('admin/grupos/new') ?>" class="btn btn-success rounded-pill fw-bold">
        <i class="bi bi-plus-lg"></i> Nuevo Grupo
    </a>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Imagen</th>
                    <th>Nombre</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($grupos)): ?>
                    <?php foreach ($grupos as $grupo): ?>
                    <tr>
                        <td class="ps-4">
                            <img src="<?= base_url('img/' . ($grupo['imagen'] ?? 'default.jpg')) ?>" 
                                 class="table-img" alt="Icono">
                        </td>
                        <td class="fw-bold"><?= esc($grupo['nombre']) ?></td>
                        <td class="text-end pe-4">
                            <a href="<?= base_url('admin/grupos/edit/' . $grupo['id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <a href="<?= base_url('admin/grupos/delete/' . $grupo['id']) ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Seguro? Esto podría afectar a los ejercicios de este grupo.');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center py-4 text-muted">No hay grupos creados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>