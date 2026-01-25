<?= $this->extend('admin/layout_admin') ?>

<?= $this->section('contenido') ?>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Gestión de Ejercicios</h2>
    <a href="<?= base_url('admin/ejercicios/new') ?>" class="btn btn-warning fw-bold">
        <i class="bi bi-plus-lg"></i> Nuevo Ejercicio
    </a>
</div>

<input type="hidden" class="txt_csrftoken" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

<div class="mb-4">
    <div class="input-group input-group-lg shadow-sm">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-warning"></i></span>
        <input type="text" id="autocomplete" class="form-control border-start-0" 
               placeholder="Buscar ejercicio por nombre (ej: Press)..." 
               value="<?= esc($filtros['search'] ?? '') ?>">
    </div>
</div>

<div class="card p-4 mb-5 shadow-sm border-0 bg-light">
    <form action="" method="get" id="filterForm" class="row g-3 align-items-end">
        
        <input type="hidden" name="search" id="hiddenSearch" value="<?= esc($filtros['search'] ?? '') ?>">

        <div class="col-md-5">
            <label class="form-label fw-bold small text-muted">Dificultad</label>
            <select name="dificultad" class="form-select">
                <option value="">Todas</option>
                <option value="Baja" <?= ($filtros['dificultad'] == 'Baja') ? 'selected' : '' ?>>Baja</option>
                <option value="Media" <?= ($filtros['dificultad'] == 'Media') ? 'selected' : '' ?>>Media</option>
                <option value="Alta" <?= ($filtros['dificultad'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="form-label fw-bold small text-muted">Grupo Muscular</label>
            <select name="grupo" class="form-select">
                <option value="">Todos</option>
                <?php if (!empty($grupos)): ?>
                    <?php foreach ($grupos as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= ($filtros['grupo'] == $g['id']) ? 'selected' : '' ?>>
                            <?= esc($g['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="col-md-2">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">Filtrar</button>
                <?php if(!empty($filtros['dificultad']) || !empty($filtros['grupo']) || !empty($filtros['search'])): ?>
                    <a href="<?= base_url('admin/ejercicios') ?>" class="btn btn-outline-secondary btn-sm">
                        Limpiar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<div id="resultados-ejercicios">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (!empty($ejercicios) && is_array($ejercicios)): ?>
            <?php foreach ($ejercicios as $ejercicio): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative">
                        
                        <div class="position-absolute top-0 start-0 m-3 z-2">
                            <a href="<?= base_url('admin/ejercicios/destacar/'.$ejercicio['id']) ?>" 
                               class="btn btn-sm bg-white rounded-circle shadow-sm" 
                               title="<?= ($ejercicio['destacado']) ? 'Quitar destacado' : 'Marcar destacado' ?>">
                                <?php if($ejercicio['destacado']): ?>
                                    <i class="bi bi-star-fill text-warning fs-5"></i>
                                <?php else: ?>
                                    <i class="bi bi-star text-secondary fs-5 opacity-50"></i>
                                <?php endif; ?>
                            </a>
                        </div>

                        <a href="<?= base_url('admin/ejercicios/edit/'.$ejercicio['id']) ?>" class="text-decoration-none text-dark">
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

                            <div style="height: 200px; background-color: #fff; display: flex; align-items: center; justify-content: center;">
                                <img src="<?= base_url('img/' . ($ejercicio['imagen'] ?? 'default.jpg')) ?>" 
                                     class="mw-100 mh-100" 
                                     style="object-fit: contain; padding: 20px;" 
                                     alt="<?= esc($ejercicio['titulo']) ?>"
                                     onerror="this.onerror=null;this.src='<?= base_url('img/default.jpg') ?>';">
                            </div>

                            <div class="card-body p-3 border-top">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">
                                    <?= esc($ejercicio['grupo_nombre'] ?? 'General') ?>
                                </small>
                                <h5 class="card-title fw-bold text-uppercase mb-2 mt-1 text-truncate"><?= esc($ejercicio['titulo']) ?></h5>
                            </div>
                        </a>
                        
                        <div class="card-footer bg-white border-0 p-3 pt-0 d-flex justify-content-between">
                            <a href="<?= base_url('admin/ejercicios/edit/'.$ejercicio['id']) ?>" class="btn btn-outline-primary btn-sm w-100 me-2">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <a href="<?= base_url('admin/ejercicios/delete/'.$ejercicio['id']) ?>" 
                               class="btn btn-outline-danger btn-sm"
                               onclick="return confirm('¿Borrar <?= esc($ejercicio['titulo']) ?>?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
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

    <div class="d-flex justify-content-center mt-5 gap-3 align-items-center">
        
        <?php if ($pager->getPreviousPageURI()): ?>
            <a href="<?= $pager->getPreviousPageURI() ?>" class="btn btn-outline-dark rounded-pill px-4">
                &laquo; Anterior
            </a>
        <?php else: ?>
            <button class="btn btn-outline-secondary rounded-pill px-4" disabled>&laquo; Anterior</button>
        <?php endif; ?>

        <span class="fw-bold px-2">
            Página <?= $pager->getCurrentPage() ?> de <?= $pager->getPageCount() ?>
        </span>

        <?php if ($pager->getNextPageURI()): ?>
            <a href="<?= $pager->getNextPageURI() ?>" class="btn btn-outline-dark rounded-pill px-4">
                Siguiente &raquo;
            </a>
        <?php else: ?>
            <button class="btn btn-outline-secondary rounded-pill px-4" disabled>Siguiente &raquo;</button>
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
                window.location.href = "<?= base_url('admin/ejercicios/edit/') ?>" + ui.item.id;
                return false;
            }
        });
    });
</script>

<?= $this->endSection() ?>