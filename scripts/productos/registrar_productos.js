const contenido = document.getElementById('productos');


$('#BtnGuardar').on('click', function (e) {
    e.preventDefault();
    if (!verificarCampos()) {
        return; // Detiene la ejecución si hay campos vacíos
    }
    RegistrarProducto();
});

$('#BtnLimpiar').on('click', function (e) {
    e.preventDefault();
    LimpiarCampos();

});
function listar_marcas() {
    fetch(`${baseUrl}\api\marcas\marcas_api.php`)
        .then(response => response.json())
        .then(resp => {
            let content = '';
            content += `<option value="" hidden>Seleccionar</option>`;

            if (!resp.data || resp.data.length === 0) {
                content = `<option value="">No existe ningun registro</option>`;
            } else {
                resp.data.forEach((marcas) => {
                    content += `<option value="${marcas.pk}">${marcas.nom}</option>`;
                });
            }

            document.getElementById("selectidmarca").innerHTML = content;
        })
        .catch(error => {
            console.error("Error al obtener los programas:", error);
            document.getElementById("selectidmarca").innerHTML = `<option value="">ERROR</option>`;
        });
}

function RegistrarProducto() {
    var cod = $('#txtCodigo').val();
    var nom = $('#txtNombre').val();
    var stock = $('#txtStock').val();
    var stock_minimo = $('#txtStock_min').val();
    var prc_compra = $('#txtPrecioC').val();
    var prc_venta = $('#txtPrecioV').val();
    var marca = $('#selectidmarca').val();
    var fch_vnc = $('#txtFechaV').val();
    var obs = $('#txtObs').val();

    var formData = new FormData();
    formData.append('cod', cod);
    formData.append('nom', nom);
    formData.append('stock', stock);
    formData.append('stock_minimo', stock_minimo);
    formData.append('prc_compra', prc_compra);
    formData.append('prc_venta', prc_venta);
    formData.append('id_marca', marca);
    formData.append('fch_vnc', fch_vnc);
    formData.append('obs', obs);
    
    fetch(`${baseUrl}/productos/productos_api_Create.php`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            /* console.log(data); */
            if (data.msg === 'Se ha Registrado Exitosamente') {
                respuest('El Producto ' + data.msg, 'success');
                LimpiarCampos();
                $('#txtCodigo').focus();
            } else {
                respuest(data.msg, 'info');
            }
        })
        .catch(error => console.error('Error:', error));
}
// Limpiar los campos del formulario de productos

function verificarCampos() {
    var cod = $('#txtCodigo').val();
    var nom = $('#txtNombre').val();
    var stock = $('#txtStock').val();
    var stock_minimo = $('#txtStock_min').val();
    var prc_compra = $('#txtPrecioC').val();
    var prc_venta = $('#txtPrecioV').val();
    var fch_vnc = $('#txtFechaV').val();
    var obs = $('#txtObs').val();
    if (cod === '' || nom === '' || stock === '' || stock_minimo === '' || prc_compra === '' || prc_venta === '' || fch_vnc === '' || obs === '') {
        respuest('Este campo es obligatorio', 'error');
        return false;
    }
    return true; // Todos los campos están completos
}

function VerificarProducto(cod) {
    fetch(`${baseUrl}/productos/productos_api_search.php?cod=${cod}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            /* console.log(data) */
            if (data && data.data && data.data.length > 0) {
                const Productos = data.data[0];
                if (Productos.act == 1) {
                    LimpiarCampos();
                    localStorage.setItem('pk', Productos.pk);
                    window.location.href = 'actualizar_productos.php';
                } else {
                    closeModal('modalCrearProductos');
                    openModalUpdateStd('modalUpdateStdProductos', 'txtIdProductoUpdateStd', Productos.pk, 'txtStdProductoUpdateStd', Productos.std);
                    LimpiarCampos();
                    respuest('Solicitante Desactivado,Se reedirigira al menu para reactivarlo!', 'info');
                }
            } else {
                $('#txtNombre').focus();
            }
        })
        .catch(error => console.error('Error:', error)); // Manejo de errores
}

function LimpiarCampos() {
    $('#txtCodigo').val('');
    $('#txtNombre').val('');
    $('#txtStock').val('');
    $('#txtStock_min').val('');
    $('#txtPrecioC').val('');
    $('#txtPrecioV').val('');
    $('#txtFechaV').val('');
    $('#txtObs').val('');
}
$("#txtCodigo").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var cod = $(this).val().trim();
        if (cod !== '') {
            VerificarProducto(cod);
        }
    }
});
$("#txtNombre").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var nom = $(this).val().trim();
        if (nom !== '') {
            $('#txtStock').focus();
        }
    }
});
$("#txtStock").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var stock = $(this).val().trim();
        if (stock !== '') {
            $('#txtStock_min').focus();
        }
    }
});
$("#txtStock_min").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var stock_min = $(this).val().trim();
        if (stock_min !== '') {
            $('#txtPrecioC').focus();
        }
    }
});
$("#txtPrecioC").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var prc_compra = $(this).val().trim();
        if (prc_compra !== '') {
            $('#txtPrecioV').focus();
        }
    }
});
$("#txtPrecioV").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var prc_venta = $(this).val().trim();
        if (prc_venta !== '') {
            $('#txtFechaV').focus();
        }
    }
});
$("#txtFechaV").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var fch_vnc = $(this).val().trim();
        if (fch_vnc !== '') {
            $('#txtObs').focus();
        }
    }
});
$("#txtObs").keypress(function (event) {
    if (event.which === 13) {
        event.preventDefault();
        var obs = $(this).val().trim();
        if (obs !== '') {
            $('#BtnGuardar').focus();
        }
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Aquí puedes agregar cualquier código que necesites ejecutar al cargar el documento
    listar_marcas(); // Llamar a la función para listar las marcas al cargar el documento
    $('#txtCodigo').focus();
});
