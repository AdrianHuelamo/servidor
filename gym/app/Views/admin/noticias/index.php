<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Noticias y Blog</h2>
    <a href="<?= base_url('admin/noticias/new') ?>" class="btn btn-warning fw-bold rounded-pill">
        <i class="bi bi-plus-lg"></i> Nueva Noticia
    </a>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Portada</th>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($noticias)): ?>
                    <?php foreach ($noticias as $noticia): ?>
                    <tr>
                        <td class="ps-4">
                            <img src="<?= base_url('img/' . ($noticia['imagen'] ?? 'news_default.jpg')) ?>" 
                                 class="table-img" alt="Noticia">
                        </td>
                        <td>
                            <div class="fw-bold"><?= esc($noticia['titulo']) ?></div>
                            <small class="text-muted"><?= esc(substr($noticia['resumen'] ?? '', 0, 50)) ?>...</small>
                        </td>
                        <td>
                            <small class="badge bg-light text-dark border">
                                <i class="bi bi-calendar3"></i> <?= esc($noticia['fecha_publicacion']) ?>
                            </small>
                        </td>
                        <td class="text-end pe-4">
                            <a href="<?= base_url('admin/noticias/edit/' . $noticia['id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <a href="<?= base_url('admin/noticias/delete/' . $noticia['id']) ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Borrar esta noticia permanentemente?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center py-4">No hay noticias publicadas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>