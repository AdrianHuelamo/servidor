<div class="container py-5">
    <div class="mb-4">
        <a href="<?= base_url('grupos') ?>" class="btn btn-outline-dark rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Volver a Grupos
        </a>
    </div>

    <div class="row align-items-center">
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="bg-white p-4 text-center">
                    <img src="<?= base_url('img/' . ($grupo['imagen'] ?? 'default.jpg')) ?>" 
                         class="img-fluid" 
                         style="max-height: 400px; object-fit: contain;" 
                         alt="<?= esc($grupo['nombre']) ?>"
                         onerror="this.onerror=null;this.src='<?= base_url('img/default.jpg') ?>';">
                </div>
            </div>
        </div>

        <div class="col-md-7 ps-md-5">
            <h1 class="display-4 fw-bold text-uppercase mb-3"><?= esc($grupo['nombre']) ?></h1>
            <div class="bg-warning mb-4" style="width: 80px; height: 5px;"></div>
            
            <p class="card-text text-muted small">
                <?= esc(substr($grupo['descripcion'] ?? '', 0, 60)) ?>...
            </p>

            <a href="<?= base_url('ejercicios?grupo='.$grupo['id']) ?>" class="btn btn-gym mt-3 shadow">
                Ver Ejercicios de <?= esc($grupo['nombre']) ?>
            </a>
        </div>
    </div>
</div>