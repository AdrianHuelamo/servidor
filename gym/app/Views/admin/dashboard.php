<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

    <div class="mb-4">
        <h2 class="fw-bold">Resumen General</h2>
        <p class="text-muted">Bienvenido al panel de control de GymFit.</p>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-blue">
                        <i class="bi bi-activity"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Ejercicios</h6>
                        <h2 class="mb-0 fw-bold"><?= $total_ejercicios ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-success">
                        <i class="bi bi-layers"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Grupos</h6>
                        <h2 class="mb-0 fw-bold"><?= $total_grupos ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-warning">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Noticias</h6>
                        <h2 class="mb-0 fw-bold"><?= $total_noticias ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-stat p-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box icon-info">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Usuarios</h6>
                        <h2 class="mb-0 fw-bold"><?= $total_usuarios ?? 0 ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-3">Accesos Directos</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?= base_url('admin/ejercicios') ?>" class="btn btn-dark rounded-pill px-4">
                <i class="bi bi-list-ul me-2"></i> Gestionar Ejercicios
            </a>
            <a href="<?= base_url('admin/noticias') ?>" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-pencil-square me-2"></i> Publicar Noticia
            </a>
            <a href="<?= base_url('admin/grupos') ?>" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-grid me-2"></i> Ver Grupos
            </a>
        </div>
    </div>

<?= $this->endSection() ?>