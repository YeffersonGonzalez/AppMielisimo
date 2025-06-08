

const contenido = document.getElementById('productos');

if (currentPath.endsWith('lista_productos.php')) {
    let currentPage = 1;
    const itemsPerPage = 10;
    let allData = []; // Aquí se almacenarán todos los usuarios traídos del API


    function editar(id) {
        localStorage.setItem('pk', id);
        window.location.href = 'actualizar_productos.php'; // Cambia esto por la página real de destino
    }
    function confirmarEliminacion(pk, activo) {
        if (activo == 1) {
            if (confirm("¿Estás seguro de que deseas desactivar este producto?")) {
                var activo = false; // Cambiamos el estado a inactivo
                eliminar(pk, activo);
            }
        } else if (activo == 0) {
            if (confirm("¿Estás seguro de que deseas activar este producto?")) {
                var activo = true; // Cambiamos el estado a activo
                eliminar(pk, activo);
            }
        }
        // Si cancela, no ocurre nada
    }
    function eliminar(pk, activo) {
        const formData = new FormData();
        formData.append('pk', pk);
        formData.append('activo', activo);

        fetch(`${baseUrl}/productos/productos_api_update_std.php`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.msg === 'Se ha actualizado Exitosamente') {
                    respuest('se ha modificado su estado exitosamente', 'success');
                    listar_productos(); // Volver a cargar la lista de productos
                } else {
                    respuest(data.msg, 'info');
                }
            })
            .catch(error => console.error('Error:', error));
    }
    function listar_productos() {
        fetch(`${baseUrl}/productos/productos_api.php`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(resp => {
                //console.log(resp.data);
                var tableBody = $('#body_table');
                var total_productos =
                    tableBody.empty();
                if (!resp.data || !Array.isArray(resp.data)) {
                    tableBody.append('<tr><td colspan="5">No hay Registros disponibles</td></tr>');
                } else {
                    allData = resp.data; // Guardamos todos los usuarios aquí
                    paginateData(allData);
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }

    function paginateData(data) {
        const totalPages = Math.ceil(data.length / itemsPerPage);
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedData = data.slice(start, end);

        var tableHeader = $('#header_table');
        tableHeader.empty();
        tableHeader.append(`
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Stock</th>
                      <th>Stock minimo</th>
                      <th>Precio de compra</th>
                      <th>Precio de venta</th>
                      <th>Vencimiento</th>
                      <th>Marca</th>
                      <th>Fecha Registro</th>
                      <th>Fecha Actualización</th>
                      <th>Activo</th>
                      <th>Acciones</th>
                    </tr>
                `);
        var tableBody = $('#body_table');
        tableBody.empty();
        paginatedData.forEach((productos) => {
            if (productos.act === 1) {
                activo = 'Activo';
            } else {
                activo = 'Inactivo';
            }
            tableBody.append(`<tr>
                            <td>${productos.cod}</td>
                            <td>${productos.nom}</td>
                            <td><b>${productos.stock}</b></td>
                            <td><b>${productos.stock_min}</b></td>
                            <td><b>${productos.prc_compra}</b></td>
                            <td><b>${productos.prc_venta}</b></td>
                            <td><b>${productos.fch_vnc}</b></td>
                            <td><b>${productos.nom_mrc}</b></td>
                            <td><b>${productos.fch_reg}</b></td>
                            <td><b>${productos.fch_mod}</b></td>
                            <td><b>${activo}</b></td>
                            <td>
                                <a href="#" onclick="editar(${productos.pk})" title="editar" class="btn-xs btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" onclick="confirmarEliminacion(${productos.pk}, ${productos.act})" title="Eliminar" class="btn-xs btn-secondary">
                                    <i class="fas fa-wrench"></i>
                                </a>
                            </td>
                        </tr>`
            );
        });
        // Crear botones de paginación con estilos de AdminLTE
        var paginationControls = $('#pagination_controls');
        paginationControls.empty();
        // Botón Anterior
        if (currentPage > 1) {
            paginationControls.append(`<button class="btn btn-primary mx-1" onclick="changePage(${currentPage - 1})">Anterior</button>`);
        }

        // Botones de número de página
        for (let i = 1; i <= totalPages; i++) {
            paginationControls.append(`<button class="btn btn-primary mx-1" onclick="changePage(${i})">${i}</button>`);
        }

        // Botón Siguiente
        if (currentPage < totalPages) {
            paginationControls.append(`<button class="btn btn-primary mx-1" onclick="changePage(${currentPage + 1})">Siguiente</button>`);
        }
    }
    function changePage(page) {
        currentPage = page;
        paginateData(allData);
    }
    // Esperamos que el DOM esté completamente cargado
    $(document).ready(function () {
        listar_productos();
        // Cargar usuarios cuando se abre la página
        // Evento que se dispara cada vez que el usuario escribe en la caja de búsqueda
        $('#search').on('input', function () {
            const searchTerm = $(this).val().toLowerCase(); // Lo que el usuario escribe, en minúsculas
            // Filtramos los datos guardados (dni, nom y usu)
            const filteredData = allData.filter(productos =>
                (productos.cod && String(productos.cod).toLowerCase().includes(searchTerm))||
                (productos.nom && productos.nom.toLowerCase().includes(searchTerm))||
                (productos.nom_mrc && productos.nom_mrc.toLowerCase().includes(searchTerm))
            );
            currentPage = 1; // Reiniciamos a la página 1 cuando filtramos
            paginateData(filteredData); // Volvemos a mostrar la tabla pero con los datos filtrados
        });
    });

}