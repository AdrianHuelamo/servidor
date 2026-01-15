<header class="hero-section text-center mb-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Supera tus límites</h1>
        <p class="lead">Encuentra los mejores ejercicios, crea rutinas y sigue tu progreso.</p>
        <a href="#lista-ejercicios" class="btn btn-primary btn-lg mt-3">Ver Ejercicios</a>
    </div>
</header>

<div class="container mb-4" id="lista-ejercicios">
    <div class="row g-3">
        <div class="col-md-4">
            <select class="form-select">
                <option selected>Todos los grupos musculares</option>
                <option value="1">Pecho</option>
                <option value="2">Espalda</option>
                <option value="3">Piernas</option>
            </select>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Buscar ejercicio (ej: Press Banca)...">
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        
        <div class="col">
            <div class="card h-100 card-ejercicio">
                <img src="https://placehold.co/600x400/222/fff?text=Press+Banca" class="card-img-top" alt="Press Banca">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary">Pecho</span>
                        <span class="badge bg-warning text-dark">Intermedio</span>
                    </div>
                    <h5 class="card-title">Press de Banca</h5>
                    <p class="card-text text-muted">El ejercicio rey para desarrollar el pectoral mayor y tríceps.</p>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver Detalles</a>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 card-ejercicio">
                <img src="https://placehold.co/600x400/222/fff?text=Sentadilla" class="card-img-top" alt="Sentadilla">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success">Piernas</span>
                        <span class="badge bg-danger">Difícil</span>
                    </div>
                    <h5 class="card-title">Sentadilla Libre</h5>
                    <p class="card-text text-muted">Fundamental para el desarrollo de piernas y glúteos.</p>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver Detalles</a>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-heart"></i></button>
                </div>
            </div>
        </div>
        
        </div>
    
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
        </ul>
    </nav>
</div>