<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Músculo no encontrado</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #212529;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .error-code {
            font-size: 10rem;
            font-weight: 900;
            line-height: 1;
            color: #ffc107; 
            text-shadow: 4px 4px 0px #000;
        }
        .btn-gym {
            background-color: #ffc107;
            color: #000;
            font-weight: 800;
            padding: 12px 30px;
            text-transform: uppercase;
            border-radius: 50px;
            text-decoration: none;
            transition: transform 0.3s;
        }
        .btn-gym:hover {
            background-color: #e0a800;
            color: #000;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="mb-4">
            <i class="bi bi-emoji-dizzy display-1 text-secondary"></i>
        </div>
        
        <h1 class="error-code">404</h1>
        
        <h2 class="display-5 fw-bold mb-3">¡Peso muerto!</h2>
        <p class="lead mb-5 text-white-50" style="max-width: 600px; margin: 0 auto;">
            Parece que la página o el ejercicio que buscas no existe o ha sido movido a otra máquina.
            <?php if (! empty($message) && $message !== '(null)') : ?>
                <br><span class="text-warning small mt-2 d-block"><?= esc($message) ?></span>
            <?php endif ?>
        </p>

        <a href="<?= base_url('/') ?>" class="btn-gym shadow-lg">
            <i class="bi bi-arrow-left me-2"></i> Volver al Gimnasio
        </a>
    </div>

</body>
</html>