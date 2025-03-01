<?php
require_once('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "UPDATE eventos SET nombre = ?, descripcion = ?, fecha_evento = ?, precio_inscripcion = ?, activo = ? WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['fecha_evento'],
        $_POST['precio_inscripcion'],
        $_POST['activo'],
        $_POST['eventId']
    ]);
    echo "Evento actualizado correctamente";
}
?>
