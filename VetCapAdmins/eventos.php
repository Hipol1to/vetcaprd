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
            <h1>Eventos</h1>
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
                    <a href='detalle_evento.php?id=" . htmlspecialchars($row['Id']) . "' target='_blank' class='btn btn-info'>Ver Detalle</a>
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
    fetch("detalle_evento.php?id=" + eventId)
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
      <?php 
//include header template
require('layout/footer.php'); 
?>