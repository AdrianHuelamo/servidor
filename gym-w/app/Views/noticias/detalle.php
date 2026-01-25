<div class="container py-5">
    <div class="mb-4">
        <a href="<?= base_url('noticias') ?>" class="btn btn-outline-dark rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Volver a Noticias
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden">
                
                <div style="height: 400px; overflow: hidden;">
                    <img src="<?= base_url('img/' . ($noticia['imagen'] ?? 'news_default.jpg')) ?>" 
                         class="w-100 h-100" 
                         style="object-fit: cover;" 
                         alt="<?= esc($noticia['titulo']) ?>"
                         onerror="this.onerror=null;this.src='<?= base_url('img/news_default.jpg') ?>';">
                </div>

                <div class="card-body p-5">
                    <div class="text-muted mb-3 d-flex align-items-center">
                        <i class="bi bi-calendar3 me-2 text-warning"></i>
                        <span>Publicado el <?= esc($noticia['fecha_publicacion']) ?></span>
                    </div>

                    <h1 class="fw-bold display-5 mb-4"><?= esc($noticia['titulo']) ?></h1>
                    
                    <hr class="opacity-10 my-4">

                    <p class="card-text text-secondary">
                        <?= esc(substr($noticia['resumen'] ?? '', 0, 100)) ?>...
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>