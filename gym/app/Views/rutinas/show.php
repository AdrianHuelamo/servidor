<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<div class="container py-5">
    
    <div class="mb-4">
        <a href="<?= base_url('rutinas') ?>" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left"></i> Volver a Mis Rutinas
        </a>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="<?= base_url('rutinas') ?>">Mis Rutinas</a></li>
                    <li class="breadcrumb-item active"><?= esc($rutina['nombre']) ?></li>
                </ol>
            </nav>
            <h1 class="fw-bold display-5"><?= esc($rutina['nombre']) ?></h1>
            <p class="text-muted lead"><?= esc($rutina['descripcion']) ?></p>
        </div>
        
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarRutina">
                <i class="bi bi-pencil"></i> Editar Info
            </button>

            <a href="<?= base_url('rutinas/delete/'.$rutina['id']) ?>" 
               class="btn btn-outline-danger btn-sm"
               onclick="return confirm('¿Borrar esta rutina entera?');">
                <i class="bi bi-trash"></i> Eliminar
            </a>
        </div>
    </div>

    <div class="card p-4 mb-4 bg-light border-0 shadow-sm">
        <label class="fw-bold mb-2">Añadir ejercicio a esta rutina:</label>
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" id="buscadorRutina" class="form-control border-start-0" placeholder="Escribe para buscar (ej: Sentadilla)...">
        </div>
        <form id="formAddEjercicio" action="<?= base_url('rutinas/addEjercicio/'.$rutina['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_ejercicio" id="inputIDEjercicio">
        </form>
    </div>

    <h4 class="fw-bold mb-3">Ejercicios en la rutina</h4>
    
    <?php if (!empty($ejercicios)): ?>
        <div class="list-group shadow-sm">
            <?php foreach ($ejercicios as $ej): ?>
                <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url('img/'.($ej['imagen'] ?? 'default.jpg')) ?>" 
                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: contain; background: #f8f9fa;">
                        <div>
                            <h5 class="mb-0 fw-bold"><?= esc($ej['titulo']) ?></h5>
                            <small class="text-primary fw-bold"><?= esc($ej['grupo_nombre']) ?></small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url('ejercicios/show/'.$ej['id']) ?>" class="btn btn-sm btn-outline-dark" target="_blank">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="<?= base_url('rutinas/removeEjercicio/'.$rutina['id'].'/'.$ej['id_relacion']) ?>" 
                           class="btn btn-sm btn-outline-danger" title="Quitar">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Esta rutina está vacía. Usa el buscador de arriba para añadir ejercicios.
        </div>
    <?php endif; ?>

</div>

<div class="modal fade" id="modalEditarRutina" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Editar Rutina</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('rutinas/update/'.$rutina['id']) ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= esc($rutina['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?= esc($rutina['descripcion']) ?></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary fw-bold">Guardar Cambios</button>
          </div>
      </form>
    </div>
  </div>
</div>

<input type="hidden" class="txt_csrftoken" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $('#buscadorRutina').autocomplete({
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
                        $('input[name="' + csrfName + '"]').val(data.token);
                        response(data.data);
                    }
                });
            },
            select: function(event, ui) {
                $('#inputIDEjercicio').val(ui.item.value);
                $('#formAddEjercicio').submit();
                return false;
            }
        });
    });
</script>