<style>
    .auth-bg {
        background: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
        background-size: cover;
        min-height: 100vh; /* Ocupa toda la pantalla */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-glass {
        background: rgba(0, 0, 0, 0.85); /* Negro semitransparente */
        backdrop-filter: blur(10px); /* Efecto borroso detrás */
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
    }
    .form-control-dark {
        background-color: #222;
        border: 1px solid #444;
        color: white;
    }
    .form-control-dark:focus {
        background-color: #333;
        color: white;
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
</style>

<div class="auth-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <div class="text-center mb-4">
                    <h1 class="fw-bold fst-italic text-warning" style="font-size: 3rem;">GYMFIT</h1>
                    <p class="text-white opacity-75">Tu legado empieza aquí</p>
                </div>

                <div class="card card-glass shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-center mb-4">Iniciar Sesión</h3>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('mensaje')): ?>
                            <div class="alert alert-success py-2"><?= session()->getFlashdata('mensaje') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('login') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label class="form-label text-warning small fw-bold">USUARIO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="username" class="form-control form-control-dark" placeholder="Tu nombre de usuario" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-warning small fw-bold">CONTRASEÑA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password" class="form-control form-control-dark" placeholder="••••••••" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-gym w-100 rounded-pill fw-bold py-2 mb-3">ENTRAR</button>
                            
                            <div class="text-center">
                                <small class="text-white-50">¿No tienes cuenta? <a href="<?= base_url('registro') ?>" class="text-warning fw-bold text-decoration-none">Regístrate</a></small>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>