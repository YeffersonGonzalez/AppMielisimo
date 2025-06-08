
function listar_marcas() {
    fetch(`${baseUrl}/marcas/marcas_api.php`)
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
function DetalleProducto(id) {
    /* console.log(id) */
    // Realiza la solicitud fetch
    fetch(`${baseUrl}/productos/productos_api.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.data && data.data.length > 0) {
                const productos = data.data[0];
                // Asigna los valores a los campos del formulario
                $('#txtCodigo').val(productos.cod);
                $('#txtNombre').val(productos.nom);
                $('#txtStock').val(productos.stock);
                $('#txtStock_min').val(productos.stock_min);
                $('#txtPrecioC').val(productos.prc_compra);
                $('#txtPrecioV').val(productos.prc_venta);
                $('#selectidmarca').val(productos.id_mrc);
                $('#txtFechaV').val(productos.fch_vnc);
                $('#txtObs').val(productos.obs);
                // Enfoca el campo de nombre
                $('#txtNombre').focus();
            } else {
                console.error('No data found');
            }
        })
        .catch(error => console.error('Error:', error)); // Manejo de errores
}
function verificarCampos() {
    var id = $('#txtId').val();
    var cod = $('#txtCodigo').val();
    var nom = $('#txtNombre').val();
    var stock = $('#txtStock').val();
    var stock_minimo = $('#txtStock_min').val();
    var prc_compra = $('#txtPrecioC').val();
    var selectmarca = $('#selectidmarca').val();
    var prc_venta = $('#txtPrecioV').val();
    var fch_vnc = $('#txtFechaV').val();
    var obs = $('#txtObs').val();
    if (!id || !cod || !nom || !stock || !stock_minimo || !prc_compra || !prc_venta || !selectmarca || !fch_vnc || !obs) {
        respuest('Todos los campos son obligatorios.', 'error');
        return false;
    }
    return true;
}
function LimpiarCampos() {
    $('#txtId').val('');
    $('#txtCodigo').val('');
    $('#txtNombre').val('');
    $('#txtStock').val('');
    $('#txtStock_min').val('');
    $('#txtPrecioC').val('');
    $('#txtPrecioV').val('');
    $('#txtFechaV').val('');
    $('#txtObs').val('');
}
function ActualizarProductos() {
    var id = $('#txtId').val();
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
    formData.append('id', id);
    formData.append('cod', cod);
    formData.append('nom', nom);
    formData.append('stock', stock);
    formData.append('stock_minimo', stock_minimo);
    formData.append('prc_compra', prc_compra);
    formData.append('prc_venta', prc_venta);
    formData.append('id_marca', marca);
    formData.append('fch_vnc', fch_vnc);
    formData.append('obs', obs);
    fetch(`${baseUrl}/productos/productos_api_update.php`, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            /* console.log(data); */
            if (data.msg === 'Se ha Actualizado Exitosamente') {
                alert('El Producto ' + data.msg, 'success');
                LimpiarCampos();
                window.location.href = 'lista_productos.php';
            } else {
                respuest(data.msg, 'info');
            }
        })
        .catch(error => console.error('Error:', error));
}
$(document).ready(function () {
    let dato = localStorage.getItem('pk');
    if (dato) {
        listar_marcas();
        $('#txtId').val(dato);
        DetalleProducto(dato);
    } else {
        window.location.href = 'lista_productos.php';
    }
});

window.addEventListener('beforeunload', function () {
    localStorage.removeItem('pk');
});


$('#BtnGuardar').on('click', function (e) {
    e.preventDefault();
    if (!verificarCampos()) {
        return; // Detiene la ejecución si hay campos vacíos
    }
    ActualizarProductos();
});

$('#BtnLimpiar').on('click', function (e) {
    e.preventDefault();
    LimpiarCampos();
});