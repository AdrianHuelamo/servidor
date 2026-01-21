<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<div class="container py-5">
    
    <div class="text-center mb-4">
        <h1 class="fw-bold display-5">Biblioteca de <span class="text-warning">Ejercicios</span></h1>
        <p class="lead text-muted">Domina la técnica perfecta</p>
    </div>

    <input type="hidden" class="txt_csrftoken" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

    <div class="mb-4">
        <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-warning"></i></span>
            <input type="text" id="autocomplete" class="form-control border-start-0" 
                   placeholder="Escribe para buscar (ej: Sentadilla)..." 
                   value="<?= esc($filtros_activos['search'] ?? '') ?>">
        </div>
    </div>

    <div class="card p-4 mb-5 shadow-sm border-0 bg-white">
        <form action="" method="get" id="filterForm" class="row g-3 align-items-end">
            
            <input type="hidden" name="search" id="hiddenSearch" value="<?= esc($filtros_activos['search'] ?? '') ?>">

            <div class="col-md-5">
                <label class="form-label fw-bold small">Dificultad</label>
                <select name="dificultad" class="form-select">
                    <option value="">Todas</option>
                    <option value="Baja" <?= ($filtros_activos['dificultad'] == 'Baja') ? 'selected' : '' ?>>Baja</option>
                    <option value="Media" <?= ($filtros_activos['dificultad'] == 'Media') ? 'selected' : '' ?>>Media</option>
                    <option value="Alta" <?= ($filtros_activos['dificultad'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label fw-bold small">Grupo Muscular</label>
                <select name="grupo" class="form-select">
                    <option value="">Todos</option>
                    <?php if (!empty($grupos_para_filtro)): ?>
                        <?php foreach ($grupos_para_filtro as $g): ?>
                            <option value="<?= $g['id'] ?>" <?= ($filtros_activos['grupo'] == $g['id']) ? 'selected' : '' ?>>
                                <?= esc($g['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col-md-2">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">Filtrar</button>
                    <?php if(!empty($filtros_activos['dificultad']) || !empty($filtros_activos['grupo']) || !empty($filtros_activos['search'])): ?>
                        <a href="<?= base_url('ejercicios') ?>" class="btn btn-outline-danger btn-sm rounded-pill">
                            <i class="bi bi-x-circle"></i> Limpiar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <div id="resultados-ejercicios">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($ejercicios_list) && is_array($ejercicios_list)): ?>
                <?php foreach ($ejercicios_list as $ejercicio): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden position-relative">
                            
                            <div class="position-absolute top-0 start-0 m-3" style="z-index: 5;">
                                <a href="<?= base_url('ejercicios/favorito/'.$ejercicio['id']) ?>" class="text-decoration-none">
                                    <?php if(in_array($ejercicio['id'], $mis_favoritos ?? [])): ?>
                                        <i class="bi bi-heart-fill text-danger fs-4 shadow-sm"></i>
                                    <?php else: ?>
                                        <i class="bi bi-heart text-danger fs-4 bg-white rounded-circle px-1 shadow-sm opacity-75"></i>
                                    <?php endif; ?>
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
                                    <p class="card-text text-muted small">
                                        <?= esc(substr($ejercicio['descripcion'] ?? '', 0, 80)) ?>...
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center py-5 w-100">
                        <i class="bi bi-search display-4 d-block mb-3"></i>
                        No se encontraron ejercicios con estos filtros.
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
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function(){
        
        $('#autocomplete').on('input', function() {
            $('#hiddenSearch').val($(this).val());
        });

        $('#autocomplete').autocomplete({
            source: function(request, response) {
                var csrfName = $('.txt_csrftoken').attr('name');
                var csrfHash = $('.txt_csrftoken').val();

                $.ajax({
                    url: "<?= base_url('ejercicios/autocomplete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        search: request.term,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        $('.txt_csrftoken').val(data.token);
                        response(data.data);
                    }
                });
            },
            select: function(event, ui) {
                $('#autocomplete').val(ui.item.label);
                window.location.href = "<?= base_url('ejercicios/show/') ?>" + ui.item.value;
                return false;
            }
        });
    });
</script>