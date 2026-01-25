<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Gestión de Usuarios</h2>
        <p class="text-muted small">Administra los miembros de GymFit</p>
    </div>
    <div class="bg-white p-2 px-4 rounded-pill shadow-sm border">
        <span class="fw-bold text-primary"><?= count($usuarios) ?></span> <span class="text-muted small">Usuarios registrados</span>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha Registro</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border me-3" 
                                     style="width: 40px; height: 40px; font-weight: bold; color: #555;">
                                    <?= strtoupper(substr($usuario['username'], 0, 1)) ?>
                                </div>
                                <span class="fw-bold text-dark"><?= esc($usuario['username']) ?></span>
                            </div>
                        </td>
                        <td class="text-muted"><?= esc($usuario['email']) ?></td>
                        <td>
                            <?php if ($usuario['rol'] == 1): ?>
                                <span class="badge bg-warning text-dark border border-warning">
                                    <i class="bi bi-shield-fill me-1"></i> Admin
                                </span>
                            <?php else: ?>
                                <span class="badge bg-light text-secondary border">
                                    <i class="bi bi-person me-1"></i> Usuario
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted">
                            <?= esc($usuario['created_at'] ?? '-') ?>
                        </td>
                        <td class="text-end pe-4">
                            <?php if(session('user_id') == $usuario['id']): ?>
                                <span class="badge bg-light text-muted border">Tú</span>
                            <?php else: ?>
                                <a href="<?= base_url('admin/usuarios/delete/' . $usuario['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Estás seguro de expulsar a <?= esc($usuario['username']) ?>? Esta acción es irreversible.');">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">No hay usuarios registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>