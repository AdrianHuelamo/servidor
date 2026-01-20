<style>
    .auth-bg {
        background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-glass {
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(10px);
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
            <div class="col-md-6 col-lg-5">
                
                <div class="card card-glass shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-center mb-2">Crear Cuenta</h3>
                        <p class="text-center text-white-50 mb-4 small">Únete a la comunidad GymFit</p>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger py-2 small">
                                <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('register/create') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label class="form-label text-warning small fw-bold">USUARIO</label>
                                <input type="text" name="username" class="form-control form-control-dark" placeholder="Elige un nick" value="<?= set_value('username') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-warning small fw-bold">EMAIL</label>
                                <input type="email" name="email" class="form-control form-control-dark" placeholder="ejemplo@correo.com" value="<?= set_value('email') ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-warning small fw-bold">CONTRASEÑA</label>
                                <input type="password" name="password" class="form-control form-control-dark" placeholder="Mínimo 4 caracteres" required>
                            </div>
                            
                            <button type="submit" class="btn btn-gym w-100 rounded-pill fw-bold py-2 mb-3">REGISTRARSE</button>
                            
                            <div class="text-center">
                                <small class="text-white-50">¿Ya eres miembro? <a href="<?= base_url('login') ?>" class="text-warning fw-bold text-decoration-none">Inicia Sesión</a></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>