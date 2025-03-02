<?php
require_once('../includes/config.php');

$event = null;
$pagos = [];
$usuarios = [];

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch event details
    $query = "SELECT * FROM diplomados WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch payments for the event
    $queryPagos = "SELECT * FROM pagos WHERE diplomado_id = ?";
    $stmtPagos = $db->prepare($queryPagos);
    $stmtPagos->execute([$eventId]);
    $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);

    // Fetch registered users for the event
    $queryUsuarios = "SELECT usuarios.* FROM usuarios 
                      LEFT JOIN usuario_diplomados ON usuarios.Id = usuario_diplomados.usuario_id 
                      WHERE usuario_diplomados.diplomado_id = ?";
    $stmtUsuarios = $db->prepare($queryUsuarios);
    $stmtUsuarios->execute([$eventId]);
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
}

require('layout/header.php');
?>

<div class="container mt-4">
    <h2>Detalles de la capacitacion</h2>

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
                <form>
                    <div class="form-group">
                        <label for="nombre">Nombre del Evento</label>
                        <input type="text" class="form-control" id="nombre" value="<?= htmlspecialchars($event['nombre']) ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="3" readonly><?= htmlspecialchars($event['descripcion']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio de Inscripción</label>
                        <input type="text" class="form-control" id="precio" value="<?= number_format($event['precio_inscripcion'], 2) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha_evento">Fecha del Evento</label>
                        <input type="text" class="form-control" id="fecha_evento" value="<?= date('d-m-Y H:i', strtotime($event['fecha_cierre_inscripcion'])) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <input type="text" class="form-control" id="activo" value="<?= $event['activo'] ? 'Activo' : 'Inactivo' ?>" readonly>
                    </div>

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
                                <th>ID Pago</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Monto</th>
                                <th>Fecha de Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagos as $pago): ?>
                                <tr>
                                    <td><?= htmlspecialchars($pago['id']) ?></td>
                                    <td><?= htmlspecialchars($pago['nombre']) ?></td>
                                    <td><?= htmlspecialchars($pago['email']) ?></td>
                                    <td>$<?= number_format($pago['monto'], 2) ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($pago['fecha_pago'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay pagos registrados para esta capacitacion.</p>
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
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay usuarios registrados para esta capacitacion.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Capacitacion no encontrada.</div>
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
