<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}
require('layout/header.php'); 
?>
      <div class="body flex-grow-1">
        <div class="container-lg px-4">
          <div class="row g-4 mb-4">
          </div>
          <div class="row">
          <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usuarios</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
        <?php
        // Query to fetch all users
        $query = "SELECT id, nombre, correo_electronico, telefono, universidad, cedula_validada, tipo_visitante, Fecha_creacion FROM usuarios WHERE rol = 'cliente'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        ?>

        <table id="usuariosAllDataTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Universidad</th>
                    <th>Teléfono</th>
                    <th>Cedula validada</th>
                    <th>Tipo visitante</th>
                    <th>Fecha creacion</th>
                    <th>Acciones</th> <!-- Column for buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['cedula_validada'] == 0) {
                            $cedulaValidadaText = "Sin validar";
                        } else {
                            $cedulaValidadaText = "Validada";
                        }
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo_electronico']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['universidad']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                        echo "<td>" . htmlspecialchars($cedulaValidadaText) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_visitante']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Fecha_creacion']) . "</td>";
                        echo "<td>
                            <a href='detalle_visitante.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info'>Ver Detalle</a>
                            <button class='btn btn-warning' onclick='editarUsuario(\"" . htmlspecialchars($row['id']) . "\")'>Editar</button>
                            <button class='btn btn-danger' onclick='eliminarUsuario(\"" . htmlspecialchars($row['id']) . "\")'>Eliminar</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            <input type="hidden" id="userId">
                            <div class="mb-3">
                                <label for="userName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="userName" required>
                            </div>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="userEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="userPhone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="userPhone" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarCambiosUsuario()">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
      let theEventosTable = document.getElementById("usuariosAllDataTable");
      let getStoredThemee = () => localStorage.getItem('coreui-free-bootstrap-admin-template-theme');
      if (theEventosTable && theEventosTable.classList) {
        if (window.matchMedia('(prefers-color-scheme: '+getStoredThemee()+')').matches) {
            if(!theEventosTable.classList.contains('table-dark')) {
              theEventosTable.classList.add('table-dark');
            }
          } else {
            if(theEventosTable.classList.contains('table-dark')) {
              theEventosTable.classList.remove('table-dark');
            }
            }
      }

      const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const table = document.getElementById('usuariosAllDataTable');
          
      if (theEventosTable && theEventosTable.classList && isDarkMode) {
          table.classList.add('table-dark');
      } else {
          if (theEventosTable && theEventosTable.classList && !isDarkMode) {
            table.classList.add('table-light');
        }
      }

      function setTableTheme(theTheme) {
        let eventosTable = document.getElementById("usuariosAllDataTable");
        if (theTheme === 'dark' && theEventosTable && theEventosTable.classList && !eventosTable.classList.contains('table-dark')) {
        eventosTable.classList.add('table-dark');
      }
      if (theTheme === 'light' && theEventosTable && theEventosTable.classList && eventosTable.classList.contains('table-dark')) {
        eventosTable.classList.remove('table-dark');
      }
      if (theTheme === 'auto') {        
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
          if(theEventosTable && theEventosTable.classList && !eventosTable.classList.contains('table-dark')) {
             eventosTable.classList.add('table-dark');
          }
        } else {
          if(theEventosTable && theEventosTable.classList && eventosTable.classList.contains('table-dark')) {
            eventosTable.classList.remove('table-dark');
          }
          }
      }
      }
    </script>
        <script>
            function editarUsuario(userId) {
                fetch("fetch_usuario.php?id=" + userId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("userId").value = data.id;
                        document.getElementById("userName").value = data.nombre;
                        document.getElementById("userEmail").value = data.correo_electronico;
                        document.getElementById("userPhone").value = data.telefono;
                        $("#editUserModal").modal("show");
                    });
            }

            function guardarCambiosUsuario() {
                const id = document.getElementById("userId").value;
                const nombre = document.getElementById("userName").value;
                const email = document.getElementById("userEmail").value;
                const telefono = document.getElementById("userPhone").value;

                fetch("actualizar_usuario.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id, nombre, email, telefono })
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                });
            }

            function eliminarUsuario(userId) {
                if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
                    fetch("eliminar_usuario.php?id=" + userId, { method: "GET" })
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            location.reload();
                        });
                }
            }
        </script>

        <script>
            new DataTable('#usuariosAllDataTable', {
                layout: {
                    topStart: {
                        buttons: ['copy', 'excel', 'pdf', 'colvis']
                    }
                }
            });
        </script>

<?php 
//include footer template
require('layout/footer.php'); 
?>
