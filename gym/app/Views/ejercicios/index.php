<div class="container py-5">
    
    <div class="text-center mb-4">
        <h1 class="fw-bold display-5">Biblioteca de <span class="text-warning">Ejercicios</span></h1>
        <p class="lead text-muted">Domina la técnica perfecta</p>
    </div>

    <div class="mb-4">
        <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-warning"></i></span>
            <input type="text" id="liveSearch" class="form-control border-start-0" 
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
        <?= $this->include('ejercicios/_grid') ?>
    </div>

</div>

<script>
    const searchInput = document.getElementById('liveSearch');
    const resultsContainer = document.getElementById('resultados-ejercicios');
    const hiddenSearch = document.getElementById('hiddenSearch');
    let timeout = null; 

    searchInput.addEventListener('input', function() {
        const texto = this.value;
        hiddenSearch.value = texto; 

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            realizarBusqueda(texto);
        }, 300);
    });

    function realizarBusqueda(texto) {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        params.set('search', texto);

        fetch(`<?= base_url('ejercicios') ?>?` + params.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' 
            }
        })
        .then(response => response.text())
        .then(html => {
            resultsContainer.innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
    }
</script>