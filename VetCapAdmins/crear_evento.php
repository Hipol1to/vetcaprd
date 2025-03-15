<?php
require_once('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a GUID for the Id field
    $Id = generateGUID();

    // Retrieve form data
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio_inscripcion = $_POST['precio_inscripcion'];
    $fecha_evento = $_POST['fecha_evento'];
    $fecha_apertura_inscripcion = $_POST['fecha_apertura_inscripcion'];
    $fecha_cierre_inscripcion = $_POST['fecha_cierre_inscripcion'];
    $activo = $_POST['activo'];

    // Handle file uploads
    $foto_evento = uploadFile($_FILES['foto_evento']);
    $foto_titulo = uploadFile($_FILES['foto_titulo']);

    // Insert event into the database
    try {
        $query = "INSERT INTO eventos (Id, nombre, descripcion, foto_evento, foto_titulo, precio_inscripcion, fecha_evento, fecha_apertura_inscripcion, fecha_cierre_inscripcion, activo) 
                  VALUES (:Id, :nombre, :descripcion, :foto_evento, :foto_titulo, :precio_inscripcion, :fecha_evento, :fecha_apertura_inscripcion, :fecha_cierre_inscripcion, :activo)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':Id' => $Id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':foto_evento' => $foto_evento,
            ':foto_titulo' => $foto_titulo,
            ':precio_inscripcion' => $precio_inscripcion,
            ':fecha_evento' => $fecha_evento,
            ':fecha_apertura_inscripcion' => $fecha_apertura_inscripcion,
            ':fecha_cierre_inscripcion' => $fecha_cierre_inscripcion,
            ':activo' => $activo,
        ]);

        header('Location: eventos.php');
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}

// Function to generate a GUID
function generateGUID() {
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }
    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', 
        mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), 
        mt_rand(16384, 20479), mt_rand(32768, 49151), 
        mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

// Function to handle file uploads
function uploadFile($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return '/VetCapAdmins/uploads/' . $fileName; // Return relative path
        }
    }
    return null; // Return null if upload fails
}
?>