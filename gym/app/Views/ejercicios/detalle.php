<div class="container py-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('ejercicios') ?>">Ejercicios</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($ejercicio['titulo']) ?></li>
        </ol>
    </nav>

    <div class="card border-0 shadow-lg overflow-hidden rounded-4">
        <div class="row g-0">
            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center">
                <img src="<?= base_url('img/'.(esc($ejercicio['imagen'] ?? '') ?: 'default.jpg')) ?>" 
                    class="img-fluid rounded-3 shadow-sm" 
                    alt="<?= esc($ejercicio['titulo']) ?>"
                    style="width: 100%; height: auto; max-height: 500px; object-fit: contain; background-color: #fff;">
            </div>
            
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                
                <div class="mb-3">
                    <span class="badge bg-primary mb-2"><?= esc($ejercicio['grupo_nombre']) ?></span>
                    <?php if($ejercicio['destacado']): ?>
                        <span class="badge bg-warning text-dark">🔥 Destacado</span>
                    <?php endif; ?>
                </div>

                <h1 class="display-4 fw-bold mb-3"><?= esc($ejercicio['titulo']) ?></h1>
                
                <h5 class="text-muted mb-4">
                    Nivel de Dificultad: <strong class="text-dark"><?= esc($ejercicio['dificultad']) ?></strong>
                </h5>

                <div class="p-4 bg-light rounded-3 mb-4">
                    <h6 class="text-uppercase text-muted small fw-bold">Instrucciones / Descripción</h6>
                    <p class="lead mb-0 fs-6">
                        <?= esc($ejercicio['descripcion']) ?>
                    </p>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="<?= base_url('ejercicios') ?>" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                        Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>