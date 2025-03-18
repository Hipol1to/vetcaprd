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
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Capacitaciones</h1>
                <!-- Add "Crear nueva capacitación" button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCapacitacionModal">
                    Crear nueva capacitación
                </button>
            </div>
        </div>

        <?php
        // Query to fetch all diplomados
        $query = "SELECT Id, nombre, descripcion, modalidad, precio_inscripcion, fecha_inicio_diplomado, activo FROM diplomados";
        $stmt = $db->prepare($query);
        $stmt->execute();
        ?>

        <table id="capacitacionesAllDataTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Modalidad</th>
                    <th>Precio de Inscripción</th>
                    <th>Fecha de Inicio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['modalidad']) . "</td>";
                        echo "<td>$" . number_format($row['precio_inscripcion'], 2) . "</td>";
                        echo "<td>" . date("Y-m-d H:i:s", strtotime($row['fecha_inicio_diplomado'])) . "</td>";
                        echo "<td>" . ($row['activo'] ? 'Activo' : 'Inactivo') . "</td>";
                        echo "<td>
                            <a href='detalle_capacitacion.php?id=" . htmlspecialchars($row['Id']) . "' class='btn btn-info'>Ver Detalle</a>
                            <button class='btn btn-warning' onclick='editarCapacitacion(\"" . htmlspecialchars($row['Id']) . "\")'>Editar</button>
                            <button class='btn btn-danger' onclick='eliminarCapacitacion(\"" . htmlspecialchars($row['Id']) . "\")'>Eliminar</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay capacitaciones registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal for Creating New Capacitación -->
        <div class="modal fade" id="crearCapacitacionModal" tabindex="-1" aria-labelledby="crearCapacitacionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearCapacitacionLabel">Crear Nueva Capacitación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="crearCapacitacionForm" action="crear_capacitacion.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <input type="text" class="form-control" id="modalidad" name="modalidad" required>
                            </div>
                            <div class="form-group">
                                <label for="foto_diplomado">Foto del Diplomado</label>
                                <input type="file" class="form-control" id="foto_diplomado" name="foto_diplomado" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="precio_inscripcion">Precio de Inscripción</label>
                                <input type="number" step="0.01" class="form-control" id="precio_inscripcion" name="precio_inscripcion" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio_diplomado">Fecha de Inicio</label>
                                <input type="datetime-local" class="form-control" id="fecha_inicio_diplomado" name="fecha_inicio_diplomado" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin_diplomado">Fecha de Fin</label>
                                <input type="datetime-local" class="form-control" id="fecha_fin_diplomado" name="fecha_fin_diplomado" required>
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
    </div>
</div>

<script>
// Open edit modal and fill form with capacitación data
function editarCapacitacion(capacitacionId) {
    fetch("fetch_capacitacion.php?id=" + capacitacionId)
        .then(response => response.json())
        .then(data => {
            document.getElementById("capacitacionId").value = data.Id;
            document.getElementById("nombre").value = data.nombre;
            document.getElementById("descripcion").value = data.descripcion;
            document.getElementById("modalidad").value = data.modalidad;
            document.getElementById("precio_inscripcion").value = data.precio_inscripcion;
            document.getElementById("fecha_inicio_diplomado").value = data.fecha_inicio_diplomado.replace(" ", "T");
            document.getElementById("fecha_fin_diplomado").value = data.fecha_fin_diplomado.replace(" ", "T");
            document.getElementById("fecha_apertura_inscripcion").value = data.fecha_apertura_inscripcion.replace(" ", "T");
            document.getElementById("fecha_cierre_inscripcion").value = data.fecha_cierre_inscripcion.replace(" ", "T");
            document.getElementById("activo").value = data.activo;
            $("#editCapacitacionModal").modal("show");
        });
}

// Delete capacitación
function eliminarCapacitacion(capacitacionId) {
    if (confirm("¿Estás seguro de que quieres eliminar esta capacitación?")) {
        fetch("eliminar_capacitacion.php?id=" + capacitacionId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}
</script>

<?php require('layout/footer.php'); ?>