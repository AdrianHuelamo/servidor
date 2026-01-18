<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Grupos Musculares</h1>
        <p class="lead text-muted">Selecciona una zona del cuerpo para ver sus ejercicios específicos.</p>
    </div>

    <?php if (! empty($grupos_list) && is_array($grupos_list)): ?>
        <div class="row g-4">
            <?php foreach ($grupos_list as $grupo): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-white border-0 shadow rounded-4 overflow-hidden card-hover h-100">
                        <div style="background: black;">
                             <img src="<?= base_url('img/'.(esc($grupo['imagen']) ?: 'muscle_default.jpg')) ?>" 
                                  class="card-img opacity-50" 
                                  alt="<?= esc($grupo['nombre']) ?>"
                                  style="height: 200px; object-fit: contain; background-color: #f8f9fa;">
                        </div>
                        <div class="card-img-overlay d-flex flex-column justify-content-center text-center p-4">
                            <h2 class="card-title fw-bold text-uppercase display-6"><?= esc($grupo['nombre']) ?></h2>
                            <p class="card-text text-light small d-none d-md-block"><?= esc($grupo['descripcion']) ?></p>
                            
                            <a href="<?= base_url('grupos/show/'.$grupo['id']) ?>" class="btn btn-outline-light mt-3 rounded-pill stretched-link">
                                Ver Ejercicios
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">No hay grupos musculares registrados.</div>
    <?php endif ?>
</div>