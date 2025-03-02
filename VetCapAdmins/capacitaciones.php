<?php
//include header template
require_once('../includes/config.php');
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
            <h1>Capacitaciones</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
        <?php
// Query to fetch all events
$query = "SELECT * FROM diplomados ORDER BY Fecha_creacion DESC";
$stmt = $db->prepare($query);
$stmt->execute();
?>

<table id="capacitacionesAllDataTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha cierre inscripcion</th>
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
                echo "<td>" . date("Y-m-d H:i:s", strtotime($row['fecha_cierre_inscripcion'])) . "</td>";
                echo "<td>$" . number_format($row['precio_inscripcion'], 2) . "</td>";
                echo "<td>" . ($row['activo'] == 1 ? 'Activo' : 'Inactivo') . "</td>";
                echo "<td>
                    <a href='detalle_capacitacion.php?id=" . htmlspecialchars($row['Id']) . "' class='btn btn-info'>Ver Detalle</a>
                    <button class='btn btn-warning' onclick='editarCapacitacion(\"" . htmlspecialchars($row['Id']) . "\")'>Editar</button>
                    <button class='btn btn-danger' onclick='eliminarCapacitacion(\"" . htmlspecialchars($row['Id']) . "\")'>Eliminar</button>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay capacitaciones registradas</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Modal for Editing Event -->
<div class="modal fade" id="editCapacitacionModal" tabindex="-1" aria-labelledby="editCapacitacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCapacitacionLabel">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCapacitacionForm">
                    <input type="hidden" id="capacitacionId" name="capacitacionId">
                    <div class="form-group">
                        <label for="capacitacionName">Nombre</label>
                        <input type="text" class="form-control" id="capacitacionName" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="capacitacionDescription">Descripción</label>
                        <textarea class="form-control" id="capacitacionDescription" name="descripcion"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="capacitacionInscripcionDate">Fecha cierre inscripcion</label>
                        <input type="datetime-local" class="form-control" id="capacitacionInscripcionDate" name="fecha_cierre_inscripcion" required>
                    </div>
                    <div class="form-group">
                        <label for="capacitacionPrecio">Precio de Inscripción</label>
                        <input type="number" class="form-control" id="capacitacionPrecio" name="precio_inscripcion" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="capacitacionStatus">Estado</label>
                        <select class="form-control" id="capacitacionStatus" name="activo">
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
function editarCapacitacion(capacitacionId) {
    fetch("fetch_capacitacion.php?id=" + capacitacionId)
        .then(response => response.json())
        .then(data => {
            document.getElementById("capacitacionId").value = data.Id;
            document.getElementById("capacitacionName").value = data.nombre;
            document.getElementById("capacitacionDescription").value = data.descripcion;
            document.getElementById("capacitacionInscripcionDate").value = data.fecha_cierre_inscripcion.replace(" ", "T");
            document.getElementById("capacitacionPrecio").value = data.precio_inscripcion;
            document.getElementById("capacitacionStatus").value = data.activo;
            $("#editCapacitacionModal").modal("show");
        });
}

// Handle form submission
document.getElementById("editCapacitacionForm").addEventListener("submit", function(event) {
    event.preventDefault();
    fetch("editar_capacitacion.php", {
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
function eliminarCapacitacion(capacitacionId) {
    if (confirm("¿Estás seguro de que quieres eliminar este evento?")) {
        fetch("eliminar_capacitacion.php?id=" + capacitacionId, { method: "GET" })
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
      let theEventosTable = document.getElementById("capacitacionesAllDataTable");
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
      const table = document.getElementById('capacitacionesAllDataTable');
          
      if (theEventosTable && theEventosTable.classList && isDarkMode) {
          table.classList.add('table-dark');
      } else {
          if (theEventosTable && theEventosTable.classList && !isDarkMode) {
            table.classList.add('table-light');
        }
      }

      function setTableTheme(theTheme) {
        let eventosTable = document.getElementById("capacitacionesAllDataTable");
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
        new DataTable('#capacitacionesAllDataTable', {
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