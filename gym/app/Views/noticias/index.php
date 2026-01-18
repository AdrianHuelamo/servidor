<div class="container py-5">
    <h1 class="fw-bold mb-5 border-start border-5 border-warning ps-3">Blog & Novedades</h1>

    <?php if (! empty($noticias_list) && is_array($noticias_list)): ?>
        <div class="row">
            <?php foreach ($noticias_list as $noticia): ?>
                <div class="col-lg-8 mx-auto">
                    <div class="card mb-4 border-0 shadow rounded-4 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?= base_url('img/'.(esc($noticia['imagen']) ?: 'news_default.jpg')) ?>" 
                                     class="img-fluid h-100" 
                                     style="object-fit: cover; min-height: 200px;" 
                                     alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4 d-flex flex-column h-100">
                                    <small class="text-muted mb-2">
                                        <i class="bi bi-clock"></i> Publicado el <?= esc($noticia['fecha_publicacion']) ?>
                                    </small>
                                    <h3 class="card-title fw-bold">
                                        <a href="<?= base_url('noticias/show/'.$noticia['id']) ?>" class="text-decoration-none text-dark">
                                            <?= esc($noticia['titulo']) ?>
                                        </a>
                                    </h3>
                                    <p class="card-text text-secondary mb-4"><?= esc($noticia['resumen']) ?></p>
                                    <a href="<?= base_url('noticias/show/'.$noticia['id']) ?>" class="mt-auto btn btn-outline-dark rounded-pill w-auto align-self-start">
                                        Leer artículo completo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">No hay noticias publicadas en este momento.</p>
    <?php endif ?>
</div>