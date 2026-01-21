<div class="container py-5">
    
    <div class="d-flex align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0">Mis <span class="text-danger">Favoritos</span></h1>
            <p class="text-muted mb-0">Tu colección personal de ejercicios</p>
        </div>
    </div>

    <?php if (!empty($ejercicios_list) && is_array($ejercicios_list)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($ejercicios_list as $ejercicio): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden position-relative">
                        
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 5;">
                            <a href="<?= base_url('ejercicios/favorito/'.$ejercicio['id']) ?>" class="text-decoration-none">
                                <i class="bi bi-heart-fill text-danger fs-4 shadow-sm" title="Quitar de favoritos"></i>
                            </a>
                        </div>

                        <a href="<?= base_url('ejercicios/show/'.$ejercicio['id']) ?>" class="text-decoration-none text-dark">
                            <?php 
                                $dificultad = ucfirst(strtolower($ejercicio['dificultad'] ?? ''));
                                $color = match($dificultad) {
                                    'Alta' => 'bg-danger',
                                    'Media' => 'bg-warning text-dark',
                                    'Baja' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <div class="position-absolute top-0 end-0 m-3 badge <?= $color ?> shadow-sm">
                                <?= esc($dificultad) ?>
                            </div>

                            <div style="height: 250px; background-color: #fff; display: flex; align-items: center; justify-content: center;">
                                <img src="<?= base_url('img/' . ($ejercicio['imagen'] ?? 'default.jpg')) ?>" 
                                     class="mw-100 mh-100" 
                                     style="object-fit: contain; padding: 20px;" 
                                     alt="<?= esc($ejercicio['titulo']) ?>"
                                     onerror="this.onerror=null;this.src='<?= base_url('img/default.jpg') ?>';">
                            </div>

                            <div class="card-body p-4 border-top">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">
                                    <?= esc($ejercicio['grupo_nombre'] ?? 'General') ?>
                                </small>
                                <h5 class="card-title fw-bold text-uppercase mb-2 mt-1"><?= esc($ejercicio['titulo']) ?></h5>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-heartbreak display-1 text-muted opacity-25"></i>
            </div>
            <h3 class="fw-bold text-muted">Aún no tienes favoritos</h3>
            <p class="text-muted mb-4">Explora nuestra biblioteca y guarda los ejercicios que más te gusten.</p>
            <a href="<?= base_url('ejercicios') ?>" class="btn btn-warning rounded-pill px-5 fw-bold">
                Explorar Ejercicios
            </a>
        </div>
    <?php endif; ?>

</div>