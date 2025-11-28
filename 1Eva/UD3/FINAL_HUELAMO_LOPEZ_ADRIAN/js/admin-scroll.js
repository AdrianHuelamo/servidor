$(document).ready(function(){
    // 1. Lee los parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const accion = params.get('accion');

    // 2. Comprueba si la acción es 'crear' o 'editar'
    if (accion === 'crear' || accion === 'editar') {
        
        // 3. Busca el formulario (todos tienen la clase .form-crud)
        const form = $('.form-crud');
        
        // 4. Si existe, haz scroll suave hacia él
        if (form.length) {
            $('html, body').animate({
                scrollTop: form.offset().top - 100 // -100px de offset para que no se pegue al menú
            }, 800); // 800ms de duración
        }
    }
});