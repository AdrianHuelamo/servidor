<header class="hero-section text-center d-flex align-items-center">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3 text-uppercase">
            Construye tu <span class="text-warning">Legado</span>
        </h1>
        <p class="lead fs-4 mb-5 text-light opacity-75 mx-auto" style="max-width: 700px;">
            La enciclopedia definitiva de hipertrofia. Ejercicios, ciencia y técnica para alcanzar tu mejor versión.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= base_url('ejercicios') ?>" class="btn btn-gym rounded-pill shadow-lg px-5 py-3 fs-5">
                Empezar Ahora
            </a>
        </div>
    </div>
</header>

<div class="container py-5">
    
    <div class="mb-5">
        <h3 class="fw-bold mb-4 text-center">🎯 Entrena por <span class="text-primary">Objetivo</span></h3>
        <div class="row row-cols-2 row-cols-md-4 g-4 justify-content-center">
            <?php if(!empty($grupos)): ?>
                <?php foreach($grupos as $grupo): ?>
                <div class="col">
                    <a href="<?= base_url('grupos/show/'.$grupo['id']) ?>" class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm text-center p-3 card-custom h-100">
                            <img src="<?= base_url('img/'.(esc($grupo['imagen']) ?: 'default.jpg')) ?>" 
                                 class="rounded-circle mx-auto mb-3 shadow" 
                                 style="width: 80px; height: 80px; object-fit: cover;" alt="...">
                            <h5 class="fw-bold m-0"><?= esc($grupo['nombre']) ?></h5>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <hr class="my-5 opacity-25">

    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="fw-bold m-0">🔥 Ejercicios <span class="text-danger">Top</span></h2>
        <a href="<?= base_url('ejercicios') ?>" class="text-decoration-none fw-bold">Ver todos &rarr;</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <?php if (!empty($destacados)): ?>
            <?php foreach ($destacados as $ej): ?>
            <div class="col">
                <div class="card card-custom h-100 position-relative">
                    <div class="position-relative">
                        <span class="badge-top">TOP</span>
                        <img src="<?= base_url('img/'.(esc($ej['imagen']) ?: 'default.jpg')) ?>" class="card-img-fix" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <a href="<?= base_url('ejercicios/show/'.$ej['id']) ?>" class="text-decoration-none text-dark stretched-link">
                                <?= esc($ej['titulo']) ?>
                            </a>
                        </h5>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-layers-fill"></i> <?= esc($ej['grupo_nombre'] ?? 'General') ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <hr class="my-5 opacity-25">

    <div class="d-flex align-items-center mb-4">
        <div class="bg-warning me-3" style="width: 5px; height: 30px;"></div>
        <h2 class="fw-bold m-0">📰 Últimas <span class="text-warning">Novedades</span></h2>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <?php if (!empty($noticias)): ?>
            <?php foreach ($noticias as $noti): ?>
            <div class="col">
                <div class="card card-custom h-100 border-0 shadow-sm">
                    <img src="<?= base_url('img/'.(esc($noti['imagen']) ?: 'news_default.jpg')) ?>" 
                         class="card-img-top" 
                         style="height: 180px; object-fit: cover;" alt="...">
                    
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            <i class="bi bi-calendar3"></i> <?= esc($noti['fecha_publicacion']) ?>
                        </small>
                        <h5 class="card-title fw-bold">
                            <a href="<?= base_url('noticias/show/'.$noti['id']) ?>" class="text-decoration-none text-dark stretched-link">
                                <?= esc($noti['titulo']) ?>
                            </a>
                        </h5>
                        <p class="card-text text-secondary small">
                            <?= esc(substr($noti['resumen'] ?? '', 0, 80)) ?>...
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <small class="text-warning fw-bold">Leer artículo &rarr;</small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info w-100">No hay noticias publicadas recientemente.</div>
        <?php endif; ?>
    </div>

</div>

<section class="position-relative py-5 mt-auto">
    
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'); 
                background-size: cover; 
                background-position: center; 
                filter: brightness(0.25);">
    </div>

    <div class="container text-center position-relative z-1 text-white">
        <h2 class="display-6 fw-bold mb-3 text-uppercase">
            ¿Listo para subir de <span class="text-warning">nivel</span>?
        </h2>
        <p class="lead mb-4 opacity-75" style="max-width: 600px; margin: 0 auto;">
            Únete a GymFit hoy. Accede a las mejores rutinas y lleva el control total de tu progreso físico.
        </p>
        
        <a href="<?= base_url('registro') ?>" class="btn btn-gym rounded-pill px-5 shadow-lg fs-5">
            Crear Cuenta Gratis
        </a>
    </div>
</section>