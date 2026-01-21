<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Últimas <span class="text-warning">Novedades</span></h1>
        <span class="text-muted">Blog de Fitness</span>
    </div>


    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($noticias) && is_array($noticias)): ?>
            <?php foreach ($noticias as $noticia): ?>
                <div class="col">
                    <a href="<?= base_url('noticias/show/'.$noticia['id']) ?>" class="text-decoration-none text-dark">
                        
                        <div class="card h-100 border-0 shadow card-hover overflow-hidden">
                            
                            <div class="position-relative">
                                <img src="<?= base_url('img/' . (esc($noticia['imagen']) ? esc($noticia['imagen']) : 'news_default.jpg')) ?>" 
                                     class="card-img-top" 
                                     style="height: 220px; object-fit: cover;" 
                                     alt="<?= esc($noticia['titulo']) ?>">
                                
                                <div class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-3 py-1 m-2 rounded-pill small shadow">
                                    <i class="bi bi-calendar3"></i> <?= esc($noticia['fecha_publicacion']) ?>
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3"><?= esc($noticia['titulo']) ?></h5>
                                <p class="card-text text-secondary">
                                    <?= esc(substr($noticia['resumen'] ?? '', 0, 100)) ?>...
                                </p>
                            </div>
                            
                            <div class="card-footer bg-white border-0 pb-4 pt-0">
                                <small class="text-warning fw-bold text-uppercase">Leer más <i class="bi bi-arrow-right"></i></small>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No hay noticias publicadas en este momento.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>