

$('#BtnGuardar').on('click', function (e) {
    e.preventDefault();
    if (!verificarCampos()) {
        return; // Detiene la ejecución si hay campos vacíos
    }
    RegistrarMarca();
    listar_marcas(); // Volver a cargar la lista de marcas
});

$('#BtnLimpiar').on('click', function (e) {
    e.preventDefault();
    LimpiarCampos();
});

function RegistrarMarca() {
    var cod = $('#txtCodigo').val();
    var nom = $('#txtNombre').val();

    var formData = new FormData();
    formData.append('cod', cod);
    formData.append('nom', nom);

    fetch(`${baseUrl}/marcas/marcas_api_create.php`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            /* console.log(data); */
            if (data.msg === 'Se ha Registrado Exitosamente') {
                respuest('La Marca ' + data.msg, 'success');
                LimpiarCampos();
                $('#txtCodigo').focus();
            } else {
                respuest(data.msg, 'info');
            }
        })
        .catch(error => console.error('Error:', error));
}
// Limpiar los campos del formulario de marcas

function verificarCampos() {
    var cod = $('#txtCodigo').val();
    var nom = $('#txtNombre').val();
    if (cod === '' || nom === '') {
        respuest('Todos los campos son obligatorios', 'error');
        return false;
    }
    return true; // Todos los campos están completos
}

function VerificarMarca(cod) {
    fetch(`${baseUrl}/marcas/marcas_api_search.php?cod=${cod}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            /* console.log(data) */
            if (data && data.data && data.data.length > 0) {
                const Marcas = data.data[0];
                if (Marcas.act == 1) {
                    LimpiarCampos();
                    DetalleMarca(Marcas.pk);
                } else {
                    respuest('Registro Desactivado, Se reedirigira al menu para reactivarlo!', 'info');
                }
            } else {
                $('#txtNombre').focus();
            }
        })
        .catch(error => console.error('Error:', error)); // Manejo de errores
}

function LimpiarCampos() {
    $('#txtId').val('');
    $('#txtCodigo').val('');
    $('#txtNombre').val('');
}

$("#txtCodigo").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var cod = $(this).val().trim();
        if (cod !== '') {
            VerificarMarca(cod);
        }
    }
});
$("#txtNombre").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Aquí puedes agregar cualquier código que necesites ejecutar al cargar el documento
    listar_marcas(); // Llamar a la función para listar las marcas al cargar el documento
    $('#txtCodigo').focus();
});
