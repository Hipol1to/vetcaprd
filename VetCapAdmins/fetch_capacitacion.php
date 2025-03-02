<?php
require_once('../includes/config.php');

if (isset($_GET['id'])) {
    $query = "SELECT * FROM diplomados WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($event);
}
?>
