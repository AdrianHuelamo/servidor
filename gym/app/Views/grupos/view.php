<div class="container py-5">
    <div class="p-5 mb-5 bg-light rounded-4 shadow-sm text-center border">
        <span class="badge bg-primary mb-2">Grupo Muscular</span>
        <h1 class="display-4 fw-bold mb-3"><?= esc($grupo['nombre']) ?></h1>
        <p class="lead text-muted mx-auto col-lg-8"><?= esc($grupo['descripcion']) ?></p>
        <a href="<?= base_url('grupos') ?>" class="btn btn-outline-secondary btn-sm mt-3 rounded-pill">← Volver al listado</a>
    </div>

    <h3 class="mb-4 pb-2 border-bottom">Ejercicios para <?= esc($grupo['nombre']) ?></h3>

    <?php if (! empty($ejercicios_list) && is_array($ejercicios_list)): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($ejercicios_list as $ejercicio): ?>
                <div class="col">
                    <div class="card card-custom h-100 position-relative">
                        <div class="d-flex align-items-center p-2">
                            <img src="<?= base_url('img/'.(esc($ejercicio['imagen']) ?: 'default.jpg')) ?>" 
                                 class="rounded-3" 
                                 style="width: 100px; height: 100px; object-fit: cover;" alt="...">
                            
                            <div class="card-body">
                                <h5 class="card-title text-dark fw-bold mb-1">
                                    <a href="<?= base_url('ejercicios/show/'.$ejercicio['id']) ?>" class="text-decoration-none text-dark stretched-link">
                                        <?= esc($ejercicio['titulo']) ?>
                                    </a>
                                </h5>
                                <span class="badge bg-secondary"><?= esc($ejercicio['dificultad']) ?></span>
                            </div>
                            <div class="px-3 text-warning">
                                <i class="bi bi-chevron-right fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info py-4 text-center">
            Aún no hay ejercicios asignados a este grupo muscular.
        </div>
    <?php endif ?>
</div>