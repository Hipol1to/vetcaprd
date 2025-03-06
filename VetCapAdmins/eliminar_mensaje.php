<?php
require_once('../includes/config.php');

if (isset($_GET['id'])) {
    $query = "DELETE FROM emails WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    
    echo "Mensaje eliminado correctamente";
}
?>
