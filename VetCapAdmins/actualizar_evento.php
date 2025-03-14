<?php
require_once('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $descripcion2 = $_POST['descripcion2'];
    $foto_evento = $_POST['foto_evento'];
    $foto_titulo = $_POST['foto_titulo'];
    $precio_inscripcion = $_POST['precio_inscripcion'];
    $fecha_apertura_inscripcion = $_POST['fecha_apertura_inscripcion'];
    $fecha_cierre_inscripcion = $_POST['fecha_cierre_inscripcion'];
    $fecha_evento = $_POST['fecha_evento'];
    $activo = $_POST['activo'];

    $query = "UPDATE eventos SET 
              nombre = ?, 
              descripcion = ?, 
              descripcion2 = ?, 
              foto_evento = ?, 
              foto_titulo = ?, 
              precio_inscripcion = ?, 
              fecha_apertura_inscripcion = ?, 
              fecha_cierre_inscripcion = ?, 
              fecha_evento = ?, 
              activo = ? 
              WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$nombre, $descripcion, $descripcion2, $foto_evento, $foto_titulo, $precio_inscripcion, $fecha_apertura_inscripcion, $fecha_cierre_inscripcion, $fecha_evento, $activo, $id]);

    header('Location: eventos.php');
    exit;
}
?>