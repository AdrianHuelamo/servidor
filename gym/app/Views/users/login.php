<div class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <div class="card auth-card p-4">
                    <div class="card-body">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-uppercase">Gym<span class="text-warning">Fit</span></h2>
                            <p class="text-muted small">Bienvenido, inicia sesión</p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger text-center small py-2">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->getFlashdata('mensaje')): ?>
                            <div class="alert alert-success text-center small py-2">
                                <?= session()->getFlashdata('mensaje') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('login') ?>" method="post">
                            
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label for="username" class="form-label small text-uppercase fw-bold text-secondary">Usuario</label>
                                <input type="text" 
                                       class="form-control form-control-auth" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Ej: Adahi" 
                                       value="<?= old('username') ?>"
                                       required 
                                       autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small text-uppercase fw-bold text-secondary">Contraseña</label>
                                <input type="password" 
                                       class="form-control form-control-auth" 
                                       id="password" 
                                       name="password"
                                       placeholder="Ej: 1234"
                                       required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-gym rounded-pill fw-bold">Entrar</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">¿No tienes cuenta? 
                                <a href="<?= base_url('registro') ?>" class="text-link-warning">Regístrate</a>
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>