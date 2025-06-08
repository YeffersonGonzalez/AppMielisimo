// FUNCION PARA AGREGAR UN PRODUCTO A LA COMPRA//
$('#agregar_producto').on('click', function(e) {
    e.preventDefault();
    verificarCampos();
});

function verificarCampos() {
    var cantidad = $('#cantidad').val();
    var precio = $('#precio').val();

    if (cantidad === '' || precio === '') {
        respuest('Este campo es obligatorio', 'error');
    }
}




