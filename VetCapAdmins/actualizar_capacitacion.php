<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $modalidad = $_POST['modalidad'];
    $precio_inscripcion = $_POST['precio_inscripcion'];
    $fecha_inicio_diplomado = $_POST['fecha_inicio_diplomado'];
    $fecha_fin_diplomado = $_POST['fecha_fin_diplomado'];
    $fecha_apertura_inscripcion = $_POST['fecha_apertura_inscripcion'];
    $fecha_cierre_inscripcion = $_POST['fecha_cierre_inscripcion'];
    $activo = $_POST['activo'];

    // Handle file upload if a new file is provided
    $foto_diplomado = $_POST['foto_diplomado']; // Default to the existing value

    if (!empty($_FILES['foto_diplomado_file']['name'])) {
        $uploadResult = uploadFile($_FILES['foto_diplomado_file']);
        if ($uploadResult) {
            $foto_diplomado = $uploadResult; // Update with the new file path
        }
    }

    $query = "UPDATE diplomados SET 
              nombre = ?, 
              descripcion = ?, 
              modalidad = ?, 
              foto_diplomado = ?, 
              precio_inscripcion = ?, 
              fecha_inicio_diplomado = ?, 
              fecha_fin_diplomado = ?, 
              fecha_apertura_inscripcion = ?, 
              fecha_cierre_inscripcion = ?, 
              activo = ? 
              WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$nombre, $descripcion, $modalidad, $foto_diplomado, $precio_inscripcion, $fecha_inicio_diplomado, $fecha_fin_diplomado, $fecha_apertura_inscripcion, $fecha_cierre_inscripcion, $activo, $id]);

    header('Location: capacitaciones.php');
    exit;
}

// Function to handle file uploads
function uploadFile($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/'; // Ensure this directory exists and is writable
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
        }
        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return '/uploads/' . $fileName; // Return relative path
        }
    }
    return null; // Return null if upload fails
}
?>