<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

$capacitacion = null;

if (isset($_GET['id'])) {
    $capacitacionId = $_GET['id'];

    // Fetch capacitación details
    $query = "SELECT * FROM diplomados WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$capacitacionId]);
    $capacitacion = $stmt->fetch(PDO::FETCH_ASSOC);
}

require('layout/header.php');
?>

<div class="container mt-4">
    <h2>Detalles de la Capacitación</h2>

    <?php if ($capacitacion): ?>
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
                <input type="file" class="form-control" id="foto_diplomado" name="foto_diplomado" accept="image/*">
                <img src="https://www.vetcaprd.com/<?= htmlspecialchars($capacitacion['foto_diplomado']) ?>" alt="Foto del Diplomado" class="img-thumbnail mt-2" style="max-width: 200px;">
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
    <?php else: ?>
        <div class="alert alert-danger">Capacitación no encontrada.</div>
        <a href="capacitaciones.php" class="btn btn-secondary">Volver</a>
    <?php endif; ?>
</div>

<?php require('layout/footer.php'); ?>