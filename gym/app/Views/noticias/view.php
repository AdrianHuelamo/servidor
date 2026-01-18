<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('noticias') ?>">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Artículo</li>
                </ol>
            </nav>

            <h1 class="display-4 fw-bold mb-3"><?= esc($noticia['titulo']) ?></h1>
            
            <div class="d-flex align-items-center mb-4 text-muted border-bottom pb-4">
                <i class="bi bi-calendar-event me-2"></i> <?= esc($noticia['fecha_publicacion']) ?>
                <span class="mx-3">|</span>
                <span class="text-warning fw-bold">GymFit News</span>
            </div>

            <img src="<?= base_url('img/'.(esc($noticia['imagen']) ?: 'news_default.jpg')) ?>" 
                 class="img-fluid rounded-4 shadow mb-5 w-100" 
                 alt="Imagen principal">

            <div class="content fs-5 lh-lg text-dark">
                <?= nl2br(esc($noticia['contenido'])) ?>
            </div>

            <div class="mt-5 pt-5 border-top text-center">
                <h5 class="mb-3">¿Te ha gustado este artículo?</h5>
                <a href="<?= base_url('noticias') ?>" class="btn btn-dark btn-lg rounded-pill px-5">Volver al Blog</a>
            </div>

        </div>
    </div>
</div>