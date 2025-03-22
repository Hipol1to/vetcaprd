<?php
require_once('../includes/config.php');

// Check if the user is logged in and is an administrator
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    echo "Acceso denegado.";
    exit();
}

// Check if the ID parameter is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de capacitación no proporcionado.";
    exit();
}

$capacitacionId = $_GET['id'];

try {
    // Prepare the SQL statement to delete the capacitación
    $query = "DELETE FROM diplomados WHERE Id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $capacitacionId, PDO::PARAM_STR);
    
    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo "Capacitación eliminada correctamente.";
        } else {
            echo "No se encontró la capacitación con el ID proporcionado.";
        }
    } else {
        echo "Error al intentar eliminar la capacitación.";
    }
} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
}
?>