<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

$event = null;
$pagos = [];
$usuarios = [];

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch event details
    $query = "SELECT * FROM eventos WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch payments for the event
    $queryPagos = "SELECT * FROM pagos WHERE evento_id = ?";
    $stmtPagos = $db->prepare($queryPagos);
    $stmtPagos->execute([$eventId]);
    $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);

    // Fetch registered users for the event
    $queryUsuarios = "SELECT usuarios.* FROM usuarios 
                      LEFT JOIN usuario_eventos ON usuarios.Id = usuario_eventos.usuario_id 
                      WHERE usuario_eventos.evento_id = ?";
    $stmtUsuarios = $db->prepare($queryUsuarios);
    $stmtUsuarios->execute([$eventId]);
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
}

require('layout/header.php');
?>

<div class="container mt-4">
    <h2>Detalles del Evento</h2>

    <?php if ($event): ?>
        <!-- Bootstrap Nav Tabs -->
        <ul class="nav nav-tabs" id="eventTabs">
            <li class="nav-item">
                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details">Detalles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments">Pagos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="users-tab" data-toggle="tab" href="#users">Usuarios Registrados</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Event Details Tab -->
            <div class="tab-pane fade show active" id="details">
                <form method="POST" action="actualizar_evento.php">
                    <div class="form-group">
                        <label for="nombre">Nombre del Evento</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($event['nombre']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($event['descripcion']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="descripcion2">Descripción 2</label>
                        <textarea class="form-control" id="descripcion2" name="descripcion2" rows="3"><?= htmlspecialchars($event['descripcion2']) ?></textarea>
                    </div>

                    <div class="form-group">
    <label for="foto_evento">Foto del Evento</label>
    <input type="file" class="form-control-file" id="foto_evento_file" name="foto_evento_file" accept="image/*">
    <input type="hidden" id="foto_evento" name="foto_evento" value="<?= htmlspecialchars($event['foto_evento']) ?>">
    <small class="form-text text-muted">Sube una imagen para actualizar la foto del evento.</small>
    <img src="http://localhost/vescaprod/<?= htmlspecialchars($event['foto_evento']) ?>" alt="Foto del Evento" class="img-thumbnail mt-2" style="max-width: 200px;" id="foto_evento_preview">
</div>

<div class="form-group">
    <label for="foto_titulo">Foto del Título</label>
    <input type="file" class="form-control-file" id="foto_titulo_file" name="foto_titulo_file" accept="image/*">
    <input type="hidden" id="foto_titulo" name="foto_titulo" value="<?= htmlspecialchars($event['foto_titulo']) ?>">
    <small class="form-text text-muted">Sube una imagen para actualizar la foto del título.</small>
    <img src="http://localhost/vescaprod/<?= htmlspecialchars($event['foto_titulo']) ?>" alt="Foto del Título" class="img-thumbnail mt-2" style="max-width: 200px;" id="foto_titulo_preview">
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Function to handle file upload
    function uploadFile(fileInput, hiddenInput, previewImage) {
        const file = fileInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);

        $.ajax({
            url: 'upload_image.php', // PHP script to handle the upload
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Update the hidden input with the new image path
                    $(hiddenInput).val(response.filePath);
                    // Update the image preview
                    $(previewImage).attr('src', response.filePath);
                    alert('Imagen subida correctamente.');
                } else {
                    alert('Error al subir la imagen: ' + response.message);
                }
            },
            error: function () {
                alert('Error al subir la imagen.');
            }
        });
    }

    // Event listener for foto_evento file input
    $('#foto_evento_file').on('change', function () {
        uploadFile(this, '#foto_evento', '#foto_evento_preview');
    });

    // Event listener for foto_titulo file input
    $('#foto_titulo_file').on('change', function () {
        uploadFile(this, '#foto_titulo', '#foto_titulo_preview');
    });
});
</script>

                    <div class="form-group">
                        <label for="precio_inscripcion">Precio de Inscripción</label>
                        <input type="number" step="0.01" class="form-control" id="precio_inscripcion" name="precio_inscripcion" value="<?= htmlspecialchars($event['precio_inscripcion']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="fecha_apertura_inscripcion">Fecha de Apertura de Inscripción</label>
                        <input type="datetime-local" class="form-control" id="fecha_apertura_inscripcion" name="fecha_apertura_inscripcion" value="<?= date('Y-m-d\TH:i', strtotime($event['fecha_apertura_inscripcion'])) ?>" onclick="this.showPicker()">
                    </div>

                    <div class="form-group">
                        <label for="fecha_cierre_inscripcion">Fecha de Cierre de Inscripción</label>
                        <input type="datetime-local" class="form-control" id="fecha_cierre_inscripcion" name="fecha_cierre_inscripcion" value="<?= date('Y-m-d\TH:i', strtotime($event['fecha_cierre_inscripcion'])) ?>" onclick="this.showPicker()">
                    </div>

                    <div class="form-group">
                        <label for="fecha_evento">Fecha del Evento</label>
                        <input type="datetime-local" class="form-control" id="fecha_evento" name="fecha_evento" value="<?= date('Y-m-d\TH:i', strtotime($event['fecha_evento'])) ?>" onclick="this.showPicker()">
                    </div>

                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <select class="form-control" id="activo" name="activo">
                            <option value="1" <?= $event['activo'] ? 'selected' : '' ?>>Activo</option>
                            <option value="0" <?= !$event['activo'] ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($event['Id']) ?>">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="eventos.php" class="btn btn-secondary">Volver</a>
                </form>
            </div>

            <!-- Payments Tab -->
<div class="tab-pane fade" id="payments">
    <h4>Pagos Registrados</h4>
    <?php if (!empty($pagos)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Comprobante</th>
                    <th>Método de Pago</th>
                    <th>Pago Validado</th>
                    <th>Fecha de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagos as $pago): ?>
                    <tr>
                        <td>$<?= number_format($pago['monto'], 2) ?></td>
                        <td>
                            <?php if (!empty($pago['comprobante_pago_ruta'])): ?>
                                <a href="http://localhost/vescaprod/<?= htmlspecialchars($pago['comprobante_pago_ruta']) ?>" target="_blank">Ver Comprobante</a>
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($pago['metodo_de_pago']) ?></td>
                        <td><?= $pago['pago_validado'] ? 'Sí' : 'No' ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($pago['fecha_de_pago'])) ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="validarPago('<?= htmlspecialchars($pago['Id']) ?>')">Validar</button>
                            <button class="btn btn-danger" onclick="eliminarPago('<?= htmlspecialchars($pago['Id']) ?>')">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <script>
// Validate payment
function validarPago(pagoId) {
    if (confirm("¿Estás seguro de que quieres validar este pago?")) {
        fetch("validar_pago.php?id=" + pagoId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}

// Delete payment
function eliminarPago(pagoId) {
    if (confirm("¿Estás seguro de que quieres eliminar este pago?")) {
        fetch("eliminar_pago.php?id=" + pagoId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}
</script>
    <?php else: ?>
        <p>No hay pagos registrados para este evento.</p>
    <?php endif; ?>
</div>

            <!-- Registered Users Tab -->
            <div class="tab-pane fade" id="users">
                <h4>Usuarios Registrados</h4>
                <?php if (!empty($usuarios)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Usuario</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['Id']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                    <td><?= htmlspecialchars($usuario['correo_electronico']) ?></td>
                                    <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay usuarios registrados para este evento.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Evento no encontrado.</div>
        <a href="eventos.php" class="btn btn-secondary">Volver</a>
    <?php endif; ?>
</div>

<?php require('layout/footer.php'); ?>

<!-- Ensure Bootstrap Tabs Work -->
<script>
$(document).ready(function () {
    $('#eventTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>