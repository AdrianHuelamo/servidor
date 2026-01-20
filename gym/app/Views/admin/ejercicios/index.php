<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Gestión de Ejercicios</h2>
    <a href="<?= base_url('ejercicios/new') ?>" class="btn btn-warning fw-bold">
        <i class="bi bi-plus-lg"></i> Nuevo Ejercicio
    </a>
</div>

<div class="card card-dashboard p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="ps-4">Imagen</th>
                    <th>Título</th>
                    <th>Dificultad</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($ejercicios)): ?>
                    <?php foreach($ejercicios as $ej): ?>
                    <tr>
                        <td class="ps-4">
                            <img src="<?= base_url('img/'.($ej['imagen'] ?? 'default.jpg')) ?>" 
                                 class="rounded border" 
                                 style="width: 50px; height: 50px; object-fit: contain;">
                        </td>
                        <td class="fw-bold"><?= esc($ej['titulo']) ?></td>
                        <td>
                            <?php 
                                $badge = match($ej['dificultad']) {
                                    'Alta' => 'bg-danger',
                                    'Media' => 'bg-warning text-dark',
                                    'Baja' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge <?= $badge ?>"><?= esc($ej['dificultad']) ?></span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="<?= base_url('ejercicios/update/'.$ej['id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <a href="<?= base_url('admin/ejercicios/delete/'.$ej['id']) ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Estás seguro de borrar <?= esc($ej['titulo']) ?>?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No hay ejercicios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?= $pager->links() ?>
</div>

<?= $this->endSection() ?>