<?php
require_once __DIR__ . '/../models/models_admin.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once "includes/head.php"; ?>
</head>

<body class="sidebar-collapse sidebar-mini">
  <?php include_once "includes/config.php"; ?>

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>">
      <?php include_once "includes/header.php"; ?>
    </nav>

    <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
      <?php include_once "includes/lateralaside.php"; ?>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Usuarios</h1>
            </div>
          </div>
        </div>
      </section>


      <div class="content  col col-sm-12 col-md-6 col-lg-12">
      <div class="container-fluid">
        <div class="row">
          
          <div class="card-header col">
          <button type="button" class="btn" style="background-color: #4C459E; color:white" data-toggle="modal" data-target="#modal-sm">Crear usuario</button>
          <div class="card-tools">
          <style>
                @media (max-width: 576px) { 
                    .card-tools {
                        margin-top: 5px;
                    }
                }
            </style>
              <div class="input-group input-group-sm" style="width: 200px; ">
                  <form name="frm_filtro1" id="frm_filtro1" method="POST">
                      <div class="input-group-append">
                          <input type="text" name="txtBuscar1" id="txtBuscar1" class="form-control float-right" placeholder="Buscar">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                          <button type="reset" class="btn btn-default" onclick="cargarUsuarios();"><ion-icon name="sync"></ion-icon></button>
                      </div>
                  </form>
              </div>
              <div id="suggestions" class="suggestions" style="border-radius: 7px; margin-top: 10px;"></div>
          </div>
      </div>

      <script>
          // Sugerencias al escribir en el campo de búsqueda
          document.getElementById('txtBuscar1').addEventListener('input', function() {
              const query = this.value.trim();
              const suggestionsContainer = document.getElementById('suggestions');

              if (query) {
                  // Llamada a la API para obtener los nombres de usuarios que coincidan
                  fetch('../api/obtenerCoincidenciaUsuario.php?nombre=' + encodeURIComponent(query), {
                      method: 'GET',
                  })
                  .then(response => response.json())
                  .then(data => {
                      suggestionsContainer.innerHTML = ''; // Limpia las sugerencias previas

                      if (data && data.length > 0) {
                          data.forEach(usuario => {
                              const suggestionItem = document.createElement('div');
                              suggestionItem.classList.add('suggestion-item');
                              suggestionItem.textContent = usuario.nombre; // Asegúrate de que 'nombre' esté en el objeto

                              // Asigna el nombre al campo de búsqueda al hacer clic en una sugerencia
                              suggestionItem.addEventListener('click', () => {
                                  document.getElementById('txtBuscar1').value = usuario.nombre;
                                  suggestionsContainer.innerHTML = ''; // Cierra la lista de sugerencias
                              });

                              suggestionsContainer.appendChild(suggestionItem);
                          });
                      } else {
                          suggestionsContainer.innerHTML = '<div class="suggestion-item">No se encontraron coincidencias</div>';
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      suggestionsContainer.innerHTML = '<div class="suggestion-item">Error al obtener sugerencias</div>';
                  });
              } else {
                  suggestionsContainer.innerHTML = ''; // Limpia las sugerencias si no hay texto
              }
          });

          // Manejo del formulario de búsqueda
            document.getElementById('frm_filtro1').addEventListener('submit', function(event) {
                event.preventDefault(); // Evita que se recargue la página
                const query = document.getElementById('txtBuscar1').value.trim();

                // Verifica si hay un valor ingresado
                if (!query) {
                    Swal.fire('Ingrese un dato', 'No se pudo encontrar el usuario.', 'error');
                    cargarUsuarios(); // Carga todos los usuarios
                } else {
                    // Llamada a la API con el nombre ingresado
                    fetch('obtenerCoincidenciaUsuario.php?nombre=' + encodeURIComponent(query), {
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            mostrarUsuarios(data); // Muestra los usuarios encontrados
                        } else {
                            Swal.fire('No se encontró ningún usuario con ese nombre.', '', 'warning');
                            mostrarUsuarios([]); // Limpia la tabla si no hay resultados
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error al buscar usuario', 'No se pudo obtener el usuario.', 'error');
                    });
                }
            });
        </script>
            <table class="table table-bordered table-striped" id="tablaUsuarios">
              <thead>
                <tr>
                  <th ></th>
                  <th >ID</th>
                  <th >Usuario</th>
                  <th >Fecha registro</th>
                  
                  <th>Accion</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
          
        </div>
        <div class="clearfix">
          <ul class="pagination pagination-sm m-0 float-right" id="pagination">
            <!-- Aquí se agregarán los botones de paginación -->
          </ul>
        </div>
        <br>
        <!-- =========== Scripts =========  -->
       
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
         
          const usuariosPorPagina = 6; // Cambia este número según lo que desees
          let paginaActual = 1;
          let totalUsuarios = 0;

          function cargarUsuarios() {
            fetch(`api_usuarios.php?page=${paginaActual}&limit=${usuariosPorPagina}`)
              .then(response => response.json())
              .then(data => {
                console.log(data);
                totalUsuarios = data.total;
                mostrarUsuarios(data.usuarios);
                mostrarPaginacion();
              })
              .catch(error => console.error('Error:', error));
          }

          function mostrarUsuarios(usuarios) {
            const tablaUsuarios = document.querySelector('#tablaUsuarios tbody');
            tablaUsuarios.innerHTML = ''; 

           
            usuarios.forEach(usuarios => {

              
              let row = document.createElement('tr');
              row.innerHTML = `
                <td ></td>
                <td>${usuarios.id}</td>
                <td>${usuarios.usuario}</td>
                <td>${usuarios.fc_creacion}</td>
                
                <td >
                  <a href="#" class="btn btn-warning btn-sm btn-editar"  onclick="confirmarEditar(${usuarios.id})">Editar</a>
                 <a href="#" class="btn btn-danger btn-sm btn-eliminar"  onclick="confirmarEliminacion(${usuarios.id})">Eliminar</a>
                  
                </td>
              `;
              tablaUsuarios.appendChild(row);
            });
          }

          function mostrarPaginacion() {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = ''; // Limpiar paginación antes de agregar nuevos botones

            const totalPaginas = Math.ceil(totalUsuarios / usuariosPorPagina);

            for (let i = 1; i <= totalPaginas; i++) {
              const li = document.createElement('li');
              li.className = 'page-item ';
              li.innerHTML = `<a class="page-link btng" href="#" onclick="cambiarPagina(${i})">${i}</a>`;
              pagination.appendChild(li);
            }
          }

          function cambiarPagina(nuevaPagina) {
            paginaActual = nuevaPagina;
            cargarUsuarios();
          }

          
          function confirmarEliminacion(id) {
            Swal.fire({
                title: 'Eliminar Usuario',
                text: `¿Estás seguro de que deseas eliminar al usuario: ${id}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor:'#d33' ,
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
           
                    fetch(`api_eliminar_usuarios.php`, {
                            method: 'DELETE',
                                headers: {
                                'Content-Type': 'application/json'
                                    },
                                body: JSON.stringify({ id: id })
                                })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error en la eliminación del usuario');
                                }
                                return response.json();
                            })
                            .then(data => {
                            
                                if (data.success) {
                                    Swal.fire('¡usuario eliminado!', '', 'success');
                                    cargarUsuarios(); // Recargar citas después de eliminar
                                } else {
                                    Swal.fire('Error', data.message || 'No se pudo eliminar al usuario', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error', 'Hubo un problema al eliminar al usuario', 'error');
                            });
                        }

                    });
                }

                function confirmarEditar(id) {
                  fetch(`obtenerID_usuarios.php?id=${id}`)
                      .then(response => response.json())
                      .then(data => {
                          if (data.error) {
                              Swal.fire('Error', data.error, 'error');
                          } else {
                              Swal.fire({
                                  title: 'Editar Usuario',
                                  html:
                                      `<div class="container-fluid col">
                                          <form role="form" name="registroForm2" id="registroForm2" method="POST" enctype="multipart/form-data">
                                              <div class="row">
                                                  <div class="col">
                                                      <label for="nombre2">Usuario:</label>
                                                      <input type="text" class="form-control" id="nombre2" name="nombre2" value="${data.usuario}" required>
                                                  </div>
                                                  
                                              </div>
                                          </form>
                                      </div>`,
                                  showCancelButton: true,
                                  confirmButtonColor: '#744CD4',
                                  confirmButtonText: 'Sí, editar!',
                                  cancelButtonText: 'Cancelar',
                                  preConfirm: () => {
                                    const data = {
                                        id: id,
                                        nombre: document.getElementById('nombre2').value,
                                    };
                                    console.log(data); // Verificar el contenido de data
                                    return data;
                                }
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                    fetch(`api_editar_usuarios.php`, {
                                      method: 'POST',
                                      headers: {
                                          'Content-Type': 'application/json'
                                      },
                                      body: JSON.stringify(result.value)
                                  })
                                  .then(response => response.json())
                                  .then(data => {
                                      if (data.success) {
                                          Swal.fire({
                                              icon: "success",
                                              title: '¡Usuario actualizado!',
                                              showConfirmButton: false,
                                              timer: 1500
                                          }).then(() => {
                                              cargarUsuarios();
                                          });
                                      } else {
                                          Swal.fire({
                                              icon: "error",
                                              title: "Error",
                                              text: data.message || 'No se pudo editar al usuario'
                                          });
                                      }
                                  })
                                  .catch(error => {
                                      console.error('Error:', error);
                                      Swal.fire('Error', 'Hubo un problema al editar al usuario', 'error');
                                  });

                                  }
                              });
                          }
                      })
                      .catch(error => {
                          console.error('Error al obtener los datos del usuario:', error);
                          Swal.fire('Error', 'Hubo un problema al obtener los datos del usuario', 'error');
                      });
              }



          document.addEventListener('DOMContentLoaded', cargarUsuarios);
        </script>
            
           <div class="modal fade " id="modal-sm">
              <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Crear Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                      <div class="modal-body">
                        <div class="col">
                            <form role="form" name="registroForm" id="registroForm" method="POST" enctype="multipart/form-data" >
         
                                  </div>
                                    
                                  <div class="row">
                                  <div class="col-6">
                                      <label for="nombre" >Usuario:</label>
                                      <input type="text" class="form-control"   id="nombre" name="nombre" required>
                                  </div>
                                  
                                <div class="col-6">
                                  <label for="nombre" >Tipo Usuario:</label>
                                <select id="tipo" name="tipo"  class="form-control">
                                    <option value="1">Admin</option>
                                    <option value="2">Usuario</option>
                                </select>
                                 </div>

                                  <div class="col-6"> <label for="password">Password:</label> 
                                  <input type="password" class="form-control" id="password" name="password" oninput="validatePassword()"> </div> 
                                  <div><span id="password-error" style="color: red; display: none;">La contraseña debe tener al menos 8 caracteres</span> </div>
                                  <script> function validatePassword() { 
                                    var passwordInput = document.getElementById('password'); 
                                    var passwordError = document.getElementById('password-error'); 
                                    if (passwordInput.value.length < 8) { 
                                     passwordError.style.display = 'inline'; 
                                    } else { passwordError.style.display = 'none'; } 
                                    } 
                                    </script>
                                <div class="col-6">
                                      <label ></label>
                                      
                                  </div>
                                  <div class="col-6"><br> 
                                      <input type="submit" class="btn btn-primary btn-block" style='color:white;' value="Guardar">
                                  </div> <br>
                                  <div class="col-6"><br>
                                      <a href='#' class="btn bg-secondary btn-block " data-dismiss="modal" style=' text-decoration:none ; color:white;'>Cancelar</a>
                                  <br></div> 
                                  
                                  </div>
                                  </div></div>
                                  </div>
                                <br><br>
                             </form> 
                             <script>
                                document.getElementById('registroForm').addEventListener('submit', function(event) {
                                event.preventDefault();

                                // Capturar los datos del formulario
                                const nombre = document.getElementById('nombre').value;
                                const tipo = document.getElementById('tipo').value;
                                const password = document.getElementById('password').value;
                                
                                // Crear objeto con los datos
                        
                                const data = {
                                    nombre: nombre,
                                    tipo: tipo,
                                    password: password
                                };

                                // Enviar los datos a la API
                                fetch('api_registro.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(data)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                        icon: "success",
                                        title: data.success,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        willClose: () => {
                                            document.getElementById('registroForm').reset();
                                            cargarUsuarios();
                                        }
                                    });
                                    } else {
                                        Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: data.error,
                                    });
                                      
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            });
                        </script>
                                
      
            </div>
      </div>
    </div>
</div>

    <footer class="main-footer">
      <?php include_once "includes/footer.php"; ?>
    </footer>
  </div>

  <?php include_once "includes/scripts.php"; ?>


</div>
</body>
</html>
