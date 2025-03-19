<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

$usuario = null;

if (isset($_GET['id'])) {
    $usuarioId = $_GET['id'];

    // Fetch visitor details
    $query = "SELECT * FROM usuarios WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}

require('layout/header.php');
?>

<div class="container mt-4">
    <h2>Detalles del Visitante</h2>

    <?php if ($usuario): ?>
        <!-- Bootstrap Nav Tabs -->
        <ul class="nav nav-tabs" id="usuarioTabs">
            <li class="nav-item">
                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details">Detalles</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Visitor Details Tab -->
            <div class="tab-pane fade show active" id="details">
                <form method="POST" action="actualizar_visitante.php">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="correo_electronico">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?= htmlspecialchars($usuario['correo_electronico']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="tipo_documento">Tipo de Documento</label>
                        <select class="form-control" id="tipo_documento" name="tipo_documento">
                            <option value="Cédula" <?= $usuario['tipo_documento'] === 'Cédula' ? 'selected' : '' ?>>Cédula</option>
                            <option value="Pasaporte" <?= $usuario['tipo_documento'] === 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cedula_numero">Número de Cédula</label>
                        <input type="text" class="form-control" id="cedula_numero" name="cedula_numero" value="<?= htmlspecialchars($usuario['cedula_numero']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="pasaporte_numero">Número de Pasaporte</label>
                        <input type="text" class="form-control" id="pasaporte_numero" name="pasaporte_numero" value="<?= htmlspecialchars($usuario['pasaporte_numero']) ?>">
                    </div>

                     <!-- Add fields for cedula_ruta images -->
                     <div class="form-group">
                        <label>Captura de Cédula</label>
                        <?php
                        // Split the cedula_ruta field into two image paths
                        $cedula_ruta = $usuario['cedula_ruta'];
                        $image_paths = explode('_.d1vis10n._', $cedula_ruta);

                        if (count($image_paths) === 2) {
                            echo '<div class="row">';
                            echo '<div class="col-md-6">';
                            echo '<p>Captura Frontal</p>';
                            echo '<img src="http://localhost/vesca//' . htmlspecialchars($image_paths[0]) . '" alt="Captura frontal no disponible" class="img-thumbnail" style="max-width: 100%;">';
                            echo '</div>';
                            echo '<div class="col-md-6">';
                            echo '<p>Captura Posterior</p>';
                            echo '<img src="http://localhost/vesca//' . htmlspecialchars($image_paths[1]) . '" alt="Captura posterior no disponible" class="img-thumbnail" style="max-width: 100%;">';
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<p>No se encontraron imágenes válidas.</p>';
                        }
                        ?>
                    </div>

                    <!-- Add select for cedula_validada -->
                    <div class="form-group">
                        <label for="cedula_validada">Cédula Validada</label>
                        <select class="form-control" id="cedula_validada" name="cedula_validada">
                            <option value="1" <?= $usuario['cedula_validada'] ? 'selected' : '' ?>>Validada</option>
                            <option value="0" <?= !$usuario['cedula_validada'] ? 'selected' : '' ?>>No Validada</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="datetime-local" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= date('Y-m-d\TH:i', strtotime($usuario['fecha_nacimiento'])) ?>" onclick="this.showPicker()">
                    </div>

                    <div class="form-group">
                        <label for="tipo_visitante">Tipo de Visitante</label>
                        <input type="text" class="form-control" id="tipo_visitante" name="tipo_visitante" value="<?= htmlspecialchars($usuario['tipo_visitante']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="tipo_estudiante">Tipo de Estudiante</label>
                        <input type="text" class="form-control" id="tipo_estudiante" name="tipo_estudiante" value="<?= htmlspecialchars($usuario['tipo_estudiante']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="universidad">Universidad</label>
                        <input type="text" class="form-control" id="universidad" name="universidad" value="<?= htmlspecialchars($usuario['universidad']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="suscrito_newsletter">Suscrito al Newsletter</label>
                        <select class="form-control" id="suscrito_newsletter" name="suscrito_newsletter">
                            <option value="1" <?= $usuario['suscrito_newsletter'] ? 'selected' : '' ?>>Sí</option>
                            <option value="0" <?= !$usuario['suscrito_newsletter'] ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="suscrito_socials">Suscrito a Redes Sociales</label>
                        <select class="form-control" id="suscrito_socials" name="suscrito_socials">
                            <option value="1" <?= $usuario['suscrito_socials'] ? 'selected' : '' ?>>Sí</option>
                            <option value="0" <?= !$usuario['suscrito_socials'] ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select class="form-control" id="rol" name="rol">
                            <option value="administrador" <?= $usuario['rol'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                            <option value="cliente" <?= $usuario['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="activo">Estado</label>
                        <select class="form-control" id="activo" name="activo">
                            <option value="1" <?= $usuario['activo'] ? 'selected' : '' ?>>Activo</option>
                            <option value="0" <?= !$usuario['activo'] ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['Id']) ?>">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="visitantes.php" class="btn btn-secondary">Volver</a>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Visitante no encontrado.</div>
        <a href="visitantes.php" class="btn btn-secondary">Volver</a>
    <?php endif; ?>
</div>

<?php require('layout/footer.php'); ?>

<!-- Ensure Bootstrap Tabs Work -->
<script>
$(document).ready(function () {
    $('#usuarioTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>