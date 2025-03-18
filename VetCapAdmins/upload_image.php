<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadDir = '../uploads/'; // Directory to store uploaded images
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
    }

    $fileName = basename($_FILES['file']['name']);
    $filePath = $uploadDir . uniqid() . '_' . $fileName; // Unique file name to avoid conflicts

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        echo json_encode([
            'success' => true,
            'filePath' => $filePath
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al mover el archivo subido.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibió ningún archivo.'
    ]);
}
?>