<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

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
