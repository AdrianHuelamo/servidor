<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Grupos <span class="text-warning">Musculares</span></h1>
        <p class="lead text-muted">Selecciona un grupo para ver sus ejercicios específicos</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php if (!empty($grupos) && is_array($grupos)): ?>
            <?php foreach ($grupos as $grupo): ?>
                <div class="col">
                    <a href="<?= base_url('grupos/show/'.$grupo['id']) ?>" class="text-decoration-none text-dark">
                        
                        <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden">
                            
                            <div style="height: 220px; background-color: #fff;">
                                <img src="<?= base_url('img/' . ($grupo['imagen'] ?? 'default.jpg')) ?>" 
                                     class="w-100 h-100" 
                                     style="object-fit: contain; padding: 15px;" 
                                     alt="<?= esc($grupo['nombre']) ?>"
                                     onerror="this.onerror=null;this.src='<?= base_url('img/default.jpg') ?>';">
                            </div>

                            <div class="card-body text-center p-4 pt-0">
                                <h4 class="card-title fw-bold mb-2"><?= esc($grupo['nombre']) ?></h4>
                                <p class="card-text text-muted small">
                                    <?= esc(substr($grupo['descripcion'] ?? '', 0, 60)) ?>...
                                </p>
                                <span class="btn btn-sm btn-outline-dark rounded-pill mt-2">Ver Ejercicios</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No hay grupos musculares registrados todavía.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>