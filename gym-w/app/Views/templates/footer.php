<footer class="bg-dark text-white pt-5 pb-3 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-warning mb-3">GymFit</h5> 
                <p class="text-white-50 small">
                    Tu compañero ideal para alcanzar tus metas físicas. 
                    Ejercicios, rutinas y consejos de expertos en un solo lugar.
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= base_url('ejercicios') ?>" class="text-white-50 text-decoration-none">Ejercicios</a></li>
                    <li><a href="<?= base_url('grupos') ?>" class="text-white-50 text-decoration-none">Grupos Musculares</a></li>
                    <li><a href="<?= base_url('noticias') ?>" class="text-white-50 text-decoration-none">Noticias</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Síguenos</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-4"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center text-white-50 small">
            &copy; <?php echo date('Y'); ?> GymFit Project. Desarrollado con CodeIgniter 4.
        </div>
    </div>
</footer>

<button type="button" class="btn btn-warning rounded-3 shadow ps-0 pe-0" id="btn-back-to-top" title="Volver arriba">
    <i class="bi bi-arrow-up text-dark fw-bold fs-4"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let mybutton = document.getElementById("btn-back-to-top");

    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    mybutton.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>

</body>
</html>