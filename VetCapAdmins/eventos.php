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
            <!-- /.col-->
            <!-- /.col-->
          <!-- /.row-->
          <!-- /.row-->
          <div class="row">
          <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Eventos</h1>
            <!-- Add "Crear nuevo evento" button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearEventoModal">
                    Crear nuevo evento
                </button>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
        <?php
// Query to fetch all events
$query = "SELECT Id, nombre, descripcion, fecha_evento, precio_inscripcion, activo FROM eventos";
$stmt = $db->prepare($query);
$stmt->execute();
?>

<table id="eventosAllDataTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha del Evento</th>
            <th>Precio de Inscripción</th>
            <th>Estado</th>
            <th>Acciones</th> <!-- New column for buttons -->
        </tr>
    </thead>
    <tbody>
        <?php
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                echo "<td>" . date("Y-m-d H:i:s", strtotime($row['fecha_evento'])) . "</td>";
                echo "<td>$" . number_format($row['precio_inscripcion'], 2) . "</td>";
                echo "<td>" . ($row['activo'] ? 'Activo' : 'Inactivo') . "</td>";
                echo "<td>
                    <a href='detalle_evento.php?id=" . htmlspecialchars($row['Id']) . "' class='btn btn-info'>Ver Detalle</a>
                    <button class='btn btn-warning' onclick='editarEvento(\"" . htmlspecialchars($row['Id']) . "\")'>Editar</button>
                    <button class='btn btn-danger' onclick='eliminarEvento(\"" . htmlspecialchars($row['Id']) . "\")'>Eliminar</button>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay eventos registrados</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="modal fade" id="crearEventoModal" tabindex="-1" aria-labelledby="crearEventoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearEventoLabel">Crear Nuevo Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="crearEventoForm" action="crear_evento.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre del Evento</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="foto_evento">Foto del Evento</label>
                        <input type="file" class="form-control" id="foto_evento" name="foto_evento" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="foto_titulo">Foto del Título</label>
                        <input type="file" class="form-control" id="foto_titulo" name="foto_titulo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="precio_inscripcion">Precio de Inscripción</label>
                        <input type="number" step="0.01" class="form-control" id="precio_inscripcion" name="precio_inscripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_evento">Fecha del Evento</label>
                        <input type="datetime-local" class="form-control" id="fecha_evento" name="fecha_evento" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_apertura_inscripcion">Fecha de Apertura de Inscripción</label>
                        <input type="datetime-local" class="form-control" id="fecha_apertura_inscripcion" name="fecha_apertura_inscripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_cierre_inscripcion">Fecha de Cierre de Inscripción</label>
                        <input type="datetime-local" class="form-control" id="fecha_cierre_inscripcion" name="fecha_cierre_inscripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <select class="form-control" id="activo" name="activo">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal for Editing Event -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventLabel">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <input type="hidden" id="eventId" name="eventId">
                    <div class="form-group">
                        <label for="eventName">Nombre</label>
                        <input type="text" class="form-control" id="eventName" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDescription">Descripción</label>
                        <textarea class="form-control" id="eventDescription" name="descripcion"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Fecha del Evento</label>
                        <input type="datetime-local" class="form-control" id="eventDate" name="fecha_evento" required>
                    </div>
                    <div class="form-group">
                        <label for="eventPrice">Precio de Inscripción</label>
                        <input type="number" class="form-control" id="eventPrice" name="precio_inscripcion" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="eventStatus">Estado</label>
                        <select class="form-control" id="eventStatus" name="activo">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Open edit modal and fill form with event data
function editarEvento(eventId) {
    fetch("fetch_evento.php?id=" + eventId)
        .then(response => response.json())
        .then(data => {
            document.getElementById("eventId").value = data.Id;
            document.getElementById("eventName").value = data.nombre;
            document.getElementById("eventDescription").value = data.descripcion;
            document.getElementById("eventDate").value = data.fecha_evento.replace(" ", "T");
            document.getElementById("eventPrice").value = data.precio_inscripcion;
            document.getElementById("eventStatus").value = data.activo;
            $("#editEventModal").modal("show");
        });
}

// Handle form submission
document.getElementById("editEventForm").addEventListener("submit", function(event) {
    event.preventDefault();
    fetch("editar_evento.php", {
        method: "POST",
        body: new FormData(this),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    });
});

// Delete event
function eliminarEvento(eventId) {
    if (confirm("¿Estás seguro de que quieres eliminar este evento?")) {
        fetch("eliminar_evento.php?id=" + eventId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}
</script>


         
            <!-- /.col-->
          </div>
          <!-- /.row-->
        </div>
      </div>
      <script>
      let theEventosTable = document.getElementById("eventosAllDataTable");
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
      const table = document.getElementById('eventosAllDataTable');
          
      if (theEventosTable && theEventosTable.classList && isDarkMode) {
          table.classList.add('table-dark');
      } else {
          if (theEventosTable && theEventosTable.classList && !isDarkMode) {
            table.classList.add('table-light');
        }
      }

      function setTableTheme(theTheme) {
        let eventosTable = document.getElementById("eventosAllDataTable");
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
        new DataTable('#eventosAllDataTable', {
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        }
    }
});
    </script>
      <?php 
//include header template
require('layout/footer.php'); 
?>