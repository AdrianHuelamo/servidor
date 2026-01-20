<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php if (!empty($ejercicios_list) && is_array($ejercicios_list)): ?>
        <?php foreach ($ejercicios_list as $ejercicio): ?>
            <div class="col">
                <a href="<?= base_url('ejercicios/show/'.$ejercicio['id']) ?>" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden">
                        
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
                            <p class="card-text text-muted small">
                                <?= esc(substr($ejercicio['descripcion'] ?? '', 0, 80)) ?>...
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center py-5 w-100">
                <i class="bi bi-search display-4 d-block mb-3"></i>
                No se encontraron ejercicios.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if (isset($total_paginas) && $total_paginas > 1): ?>
    <div class="d-flex justify-content-center mt-5 gap-2">
        <?php if ($pagina_actual > 1): ?>
            <a href="<?= current_url() ?>?page=<?= $pagina_actual - 1 ?>&search=<?= esc($filtros_activos['search'] ?? '') ?>&dificultad=<?= esc($filtros_activos['dificultad'] ?? '') ?>&grupo=<?= esc($filtros_activos['grupo'] ?? '') ?>" class="btn btn-outline-dark rounded-pill">Anterior</a>
        <?php endif; ?>
        <span class="d-flex align-items-center fw-bold px-3">Página <?= $pagina_actual ?> de <?= $total_paginas ?></span>
        <?php if ($pagina_actual < $total_paginas): ?>
            <a href="<?= current_url() ?>?page=<?= $pagina_actual + 1 ?>&search=<?= esc($filtros_activos['search'] ?? '') ?>&dificultad=<?= esc($filtros_activos['dificultad'] ?? '') ?>&grupo=<?= esc($filtros_activos['grupo'] ?? '') ?>" class="btn btn-outline-dark rounded-pill">Siguiente</a>
        <?php endif; ?>
    </div>
<?php endif; ?>