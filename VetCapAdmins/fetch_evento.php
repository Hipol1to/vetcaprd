<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if (isset($_GET['id'])) {
    $query = "SELECT * FROM eventos WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($event);
}
?>
