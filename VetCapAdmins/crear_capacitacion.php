<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a GUID for the Id field
    $Id = generateGUID();

    // Retrieve form data
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $modalidad = $_POST['modalidad'];
    $precio_inscripcion = $_POST['precio_inscripcion'];
    $fecha_inicio_diplomado = $_POST['fecha_inicio_diplomado'];
    $fecha_fin_diplomado = $_POST['fecha_fin_diplomado'];
    $fecha_apertura_inscripcion = $_POST['fecha_apertura_inscripcion'];
    $fecha_cierre_inscripcion = $_POST['fecha_cierre_inscripcion'];
    $activo = $_POST['activo'];

    // Handle file upload
    $foto_diplomado = uploadFile($_FILES['foto_diplomado']);

    // Insert capacitación into the database
    try {
        $query = "INSERT INTO diplomados (Id, nombre, descripcion, modalidad, foto_diplomado, precio_inscripcion, fecha_inicio_diplomado, fecha_fin_diplomado, fecha_apertura_inscripcion, fecha_cierre_inscripcion, activo) 
                  VALUES (:Id, :nombre, :descripcion, :modalidad, :foto_diplomado, :precio_inscripcion, :fecha_inicio_diplomado, :fecha_fin_diplomado, :fecha_apertura_inscripcion, :fecha_cierre_inscripcion, :activo)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':Id' => $Id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':modalidad' => $modalidad,
            ':foto_diplomado' => $foto_diplomado,
            ':precio_inscripcion' => $precio_inscripcion,
            ':fecha_inicio_diplomado' => $fecha_inicio_diplomado,
            ':fecha_fin_diplomado' => $fecha_fin_diplomado,
            ':fecha_apertura_inscripcion' => $fecha_apertura_inscripcion,
            ':fecha_cierre_inscripcion' => $fecha_cierre_inscripcion,
            ':activo' => $activo,
        ]);

        header('Location: capacitaciones.php');
    } catch (PDOException $e) {
        write_log($e->getMessage());
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