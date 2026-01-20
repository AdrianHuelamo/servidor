<div class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="card auth-card p-4">
                    <div class="card-body">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-uppercase">Únete a <span class="text-warning">Nosotros</span></h2>
                            <p class="text-muted small">Empieza tu transformación hoy</p>
                        </div>

                        <?php if (isset($validation)): ?>
                            <div class="alert alert-danger small">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('registro/store') ?>" method="post">
                            <div class="mb-3">
                                <label for="nombre" class="form-label small text-uppercase fw-bold text-secondary">Nombre Completo</label>
                                <input type="text" class="form-control form-control-auth" id="nombre" name="nombre" value="<?= set_value('nombre') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label small text-uppercase fw-bold text-secondary">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-auth" id="email" name="email" value="<?= set_value('email') ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small text-uppercase fw-bold text-secondary">Contraseña</label>
                                <input type="password" class="form-control form-control-auth" id="password" name="password" required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-gym rounded-pill fw-bold">Crear Cuenta</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">¿Ya tienes cuenta? 
                                <a href="<?= base_url('login') ?>" class="text-link-warning">Inicia sesión</a>
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>