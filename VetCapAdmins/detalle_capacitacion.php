<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

$capacitacion = null;
$pagos = [];
$usuarios = [];

if (isset($_GET['id'])) {
    $capacitacionId = $_GET['id'];

    // Fetch capacitación details
    $query = "SELECT * FROM diplomados WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$capacitacionId]);
    $capacitacion = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch payments for the capacitación
    $queryPagos = "SELECT * FROM pagos WHERE diplomado_id = ?";
    $stmtPagos = $db->prepare($queryPagos);
    $stmtPagos->execute([$capacitacionId]);
    $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);

    // Fetch registered users for the capacitación
    $queryUsuarios = "SELECT usuarios.* FROM usuarios 
                      LEFT JOIN usuario_diplomados ON usuarios.Id = usuario_diplomados.usuario_id 
                      WHERE usuario_diplomados.diplomado_id = ?";
    $stmtUsuarios = $db->prepare($queryUsuarios);
    $stmtUsuarios->execute([$capacitacionId]);
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
}

require('layout/header.php');
?>

<div class="container mt-4">
    <h2>Detalles de la Capacitación</h2>

    <?php if ($capacitacion): ?>
        <!-- Bootstrap Nav Tabs -->
        <ul class="nav nav-tabs" id="capacitacionTabs">
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
            <!-- Capacitación Details Tab -->
            <div class="tab-pane fade show active" id="details">
                <form method="POST" action="actualizar_capacitacion.php">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($capacitacion['nombre']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($capacitacion['descripcion']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modalidad">Modalidad</label>
                        <input type="text" class="form-control" id="modalidad" name="modalidad" value="<?= htmlspecialchars($capacitacion['modalidad']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="foto_diplomado">Foto del Diplomado</label>
                        <input type="file" class="form-control-file" id="foto_diplomado_file" name="foto_diplomado_file" accept="image/*">
                        <input type="hidden" id="foto_diplomado" name="foto_diplomado" value="<?= htmlspecialchars($capacitacion['foto_diplomado']) ?>">
                        <!-- <small class="form-text text-muted">Sube una imagen para actualizar la foto del diplomado.</small> -->
                        <img src="https://www.vetcaprd.com/<?= htmlspecialchars(str_replace("../", "", $capacitacion['foto_diplomado'])) ?>" alt="Foto del Diplomado no disponible" class="img-thumbnail mt-2" style="max-width: 200px;" id="foto_diplomado_preview">
                    </div>
                    <div class="form-group">
                        <label for="precio_inscripcion">Precio de Inscripción</label>
                        <input type="number" step="0.01" class="form-control" id="precio_inscripcion" name="precio_inscripcion" value="<?= htmlspecialchars($capacitacion['precio_inscripcion']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio_diplomado">Fecha de Inicio</label>
                        <input type="datetime-local" class="form-control" id="fecha_inicio_diplomado" name="fecha_inicio_diplomado" value="<?= date('Y-m-d\TH:i', strtotime($capacitacion['fecha_inicio_diplomado'])) ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin_diplomado">Fecha de Fin</label>
                        <input type="datetime-local" class="form-control" id="fecha_fin_diplomado" name="fecha_fin_diplomado" value="<?= date('Y-m-d\TH:i', strtotime($capacitacion['fecha_fin_diplomado'])) ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_apertura_inscripcion">Fecha de Apertura de Inscripción</label>
                        <input type="datetime-local" class="form-control" id="fecha_apertura_inscripcion" name="fecha_apertura_inscripcion" value="<?= date('Y-m-d\TH:i', strtotime($capacitacion['fecha_apertura_inscripcion'])) ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_cierre_inscripcion">Fecha de Cierre de Inscripción</label>
                        <input type="datetime-local" class="form-control" id="fecha_cierre_inscripcion" name="fecha_cierre_inscripcion" value="<?= date('Y-m-d\TH:i', strtotime($capacitacion['fecha_cierre_inscripcion'])) ?>">
                    </div>
                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <select class="form-control" id="activo" name="activo">
                            <option value="1" <?= $capacitacion['activo'] ? 'selected' : '' ?>>Activo</option>
                            <option value="0" <?= !$capacitacion['activo'] ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($capacitacion['Id']) ?>">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="capacitaciones.php" class="btn btn-secondary">Volver</a>
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
                                        <?php $comprobantePath = explode("VetCapMembers/uploads/", $pago['comprobante_pago_ruta']) ?>
                                            <a href="<?= htmlspecialchars("https://www.vetcaprd.com/VetCapMembers/uploads/".$comprobantePath[1]) ?>" target="_blank">Ver Comprobante</a>
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
                        // Fetch payment details and open modal
                        function validarPago(pagoId) {
                            fetch(`obtener_pago.php?id=${pagoId}`)
                                .then(response => response.json())
                                .then(data => {
                                    // Populate the modal form
                                    document.getElementById('pagoId').value = data.Id;
                                    document.getElementById('usuarioId').value = data.usuario_id;
                                    document.getElementById('diplomadoId').value = data.diplomado_id;
                                    document.getElementById('monto').value = data.monto;
                                    document.getElementById('cuenta_remitente').value = data.cuenta_remitente;
                                    document.getElementById('banco_remitente').value = data.banco_remitente;
                                    document.getElementById('tipo_cuenta_remitente').value = data.tipo_cuenta_remitente;
                                    document.getElementById('cuenta_destinatario').value = data.cuenta_destinatario;
                                    document.getElementById('banco_destinatario').value = data.banco_destinatario;
                                    document.getElementById('tipo_cuenta_destinatario').value = data.tipo_cuenta_destinatario;
                                    document.getElementById('fecha_de_pago').value = data.fecha_de_pago.replace(' ', 'T');
                                    document.getElementById('pago_validado').value = data.pago_validado ? '1' : '0';
                                
                                    // Open the modal
                                    $('#editarPagoModal').modal('show');
                                })
                                .catch(error => {
                                    console.error('Error fetching payment details:', error);
                                });
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
                    <p>No hay pagos registrados para esta capacitación.</p>
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
                    <p>No hay usuarios registrados para esta capacitación.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Capacitación no encontrada.</div>
        <a href="capacitaciones.php" class="btn btn-secondary">Volver</a>
    <?php endif; ?>
</div>


<!-- Modal for Editing Payment -->
<div class="modal fade" id="editarPagoModal" tabindex="-1" aria-labelledby="editarPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPagoModalLabel">Editar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarPagoForm" method="POST" action="actualizar_pago.php">
                    <input type="hidden" id="pagoId" name="pagoId">
                    <input type="hidden" id="usuarioId" name="usuarioId">
                    <input type="hidden" id="diplomadoId" name="diplomadoId">
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                    </div>
                    <div class="form-group">
                        <label for="cuenta_remitente">Numero de Cuenta Remitente</label>
                        <input type="text" class="form-control" id="cuenta_remitente" name="cuenta_remitente" required>
                    </div>
                    <div class="form-group">
                        <label for="banco_remitente">Banco Remitente</label>
                        <input type="text" class="form-control" id="banco_remitente" name="banco_remitente" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cuenta_remitente">Tipo de Cuenta Remitente</label>
                        <input type="text" class="form-control" id="tipo_cuenta_remitente" name="tipo_cuenta_remitente" required>
                    </div>
                    <div class="form-group">
                        <label for="cuenta_destinatario">Numero de Cuenta Destinatario</label>
                        <input type="text" class="form-control" id="cuenta_destinatario" name="cuenta_destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="banco_destinatario">Banco Destinatario</label>
                        <input type="text" class="form-control" id="banco_destinatario" name="banco_destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cuenta_destinatario">Tipo de Cuenta Destinatario</label>
                        <input type="text" class="form-control" id="tipo_cuenta_destinatario" name="tipo_cuenta_destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_de_pago">Fecha de Pago</label>
                        <input type="datetime-local" class="form-control" id="fecha_de_pago" name="fecha_de_pago" required step="1">
                    </div>
                    <div class="form-group">
                        <label for="pago_validado">Pago Validado</label>
                        <select class="form-control" id="pago_validado" name="pago_validado">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Editing Payment -->
<div class="modal fade" id="editarPagoModal" tabindex="-1" aria-labelledby="editarPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPagoModalLabel">Editar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarPagoForm" method="POST" action="actualizar_pago.php">
                    <input type="hidden" id="pagoId" name="pagoId">
                    <input type="hidden" id="usuarioId" name="usuarioId">
                    <input type="hidden" id="diplomadoId" name="diplomadoId">
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                    </div>
                    <div class="form-group">
                        <label for="cuenta_remitente">Cuenta Remitente</label>
                        <input type="text" class="form-control" id="cuenta_remitente" name="cuenta_remitente" required>
                    </div>
                    <div class="form-group">
                        <label for="banco_remitente">Banco Remitente</label>
                        <input type="text" class="form-control" id="banco_remitente" name="banco_remitente" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cuenta_remitente">Tipo de Cuenta Remitente</label>
                        <input type="text" class="form-control" id="tipo_cuenta_remitente" name="tipo_cuenta_remitente" required>
                    </div>
                    <div class="form-group">
                        <label for="cuenta_destinatario">Cuenta Destinatario</label>
                        <input type="text" class="form-control" id="cuenta_destinatario" name="cuenta_destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="banco_destinatario">Banco Destinatario</label>
                        <input type="text" class="form-control" id="banco_destinatario" name="banco_destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cuenta_destinatario">Tipo de Cuenta Destinatario</label>
                        <input type="text" class="form-control" id="tipo_cuenta_destinatario" name="tipo_cuenta_destinatario" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_de_pago">Fecha de Pago</label>
                        <input type="datetime-local" class="form-control" id="fecha_de_pago" name="fecha_de_pago" required>
                    </div>
                    <div class="form-group">
                        <label for="pago_validado">Pago Validado</label>
                        <select class="form-control" id="pago_validado" name="pago_validado">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
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

    // Event listener for foto_diplomado file input
    $('#foto_diplomado_file').on('change', function () {
        uploadFile(this, '#foto_diplomado', '#foto_diplomado_preview');
    });
});
</script>


<?php require('layout/footer.php'); ?>

<!-- Ensure Bootstrap Tabs Work -->
<script>
$(document).ready(function () {
    $('#capacitacionTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>