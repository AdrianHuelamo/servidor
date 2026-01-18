<div class="container py-5">
    
    <div class="mb-4">
        <h1 class="display-5 fw-bold text-dark">Ejercicios <span class="text-primary">Disponibles</span></h1>
        <p class="text-muted">Utiliza los filtros para encontrar tu ejercicio ideal.</p>
    </div>

    <div class="card card-custom p-4 mb-5 shadow-sm bg-white">
        <form action="<?= base_url('ejercicios') ?>" method="get">
            <div class="row g-3">
                
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light" 
                               placeholder="Ej: Press Banca..." 
                               value="<?= esc($filtros_activos['search'] ?? '') ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">Grupo Muscular</label>
                    <select name="grupo" class="form-select bg-light">
                        <option value="">Todos</option>
                        <?php foreach ($grupos_para_filtro as $grupo): ?>
                            <option value="<?= $grupo['id'] ?>" <?= ($filtros_activos['grupo'] == $grupo['id']) ? 'selected' : '' ?>>
                                <?= esc($grupo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">Dificultad</label>
                    <select name="dificultad" class="form-select bg-light">
                        <option value="">Cualquier dificultad</option>
                        <option value="Baja" <?= ($filtros_activos['dificultad'] == 'Baja') ? 'selected' : '' ?>>Baja</option>
                        <option value="Media" <?= ($filtros_activos['dificultad'] == 'Media') ? 'selected' : '' ?>>Media</option>
                        <option value="Alta" <?= ($filtros_activos['dificultad'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-gym w-100 rounded-pill">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if (empty($ejercicios_list)): ?>
        <div class="alert alert-warning text-center p-5 shadow-sm rounded-3">
            <h3>🔍 No se encontraron resultados</h3>
            <p>Intenta cambiar los filtros de búsqueda.</p>
            <a href="<?= base_url('ejercicios') ?>" class="btn btn-outline-dark mt-2">Limpiar filtros</a>
        </div>
    <?php else: ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
        <?php foreach ($ejercicios_list as $ejercicio): ?>
        <div class="col">
            <div class="card card-custom h-100 position-relative">
                
                <div class="position-absolute top-0 end-0 m-3 z-3">
                    <span class="badge bg-dark bg-gradient p-2">
                        <?= esc($ejercicio['grupo_nombre']) ?>
                    </span>
                </div>

                <img src="<?= base_url('img/'.(esc($ejercicio['imagen'] ?? '') ?: 'default.jpg')) ?>" 
                     class="card-img-fix" 
                     alt="<?= esc($ejercicio['titulo']) ?>">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark mb-1">
                        <a href="<?= base_url('ejercicios/show/'.$ejercicio['id'])?>" class="text-decoration-none text-dark stretched-link">
                            <?= esc($ejercicio['titulo']) ?>
                        </a>
                    </h5>
                    
                    <?php 
                        $dificultad = esc($ejercicio['dificultad'] ?? '');
                        $badgeColor = match($dificultad) {
                            'Alta' => 'text-danger',
                            'Media' => 'text-warning',
                            default => 'text-success'
                        };
                    ?>
                    <p class="small fw-bold <?= $badgeColor ?> mb-3">
                        <i class="bi bi-bar-chart-fill"></i> <?= $dificultad ?>
                    </p>

                    <p class="card-text text-muted small flex-grow-1">
                        <?= esc(substr($ejercicio['descripcion'] ?? '', 0, 80)) ?>...
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
    </div>
    
    <div class="d-flex justify-content-center mt-5 gap-2">
        <?php 
            $params = $_GET; 
        ?>

        <?php if ($pagina_actual > 1): ?>
            <?php $params['page'] = $pagina_actual - 1; ?>
            <a href="<?= base_url('ejercicios?' . http_build_query($params)) ?>" class="btn btn-outline-dark rounded-pill px-4">
                &laquo; Anterior
            </a>
        <?php else: ?>
            <button class="btn btn-outline-secondary rounded-pill px-4" disabled>&laquo; Anterior</button>
        <?php endif; ?>

        <span class="d-flex align-items-center fw-bold px-3">
            Página <?= $pagina_actual ?> de <?= $total_paginas ?>
        </span>

        <?php if ($pagina_actual < $total_paginas): ?>
            <?php $params['page'] = $pagina_actual + 1; ?>
            <a href="<?= base_url('ejercicios?' . http_build_query($params)) ?>" class="btn btn-outline-dark rounded-pill px-4">
                Siguiente &raquo;
            </a>
        <?php else: ?>
            <button class="btn btn-outline-secondary rounded-pill px-4" disabled>Siguiente &raquo;</button>
        <?php endif; ?>

    </div>

    <?php endif; ?>
</div>