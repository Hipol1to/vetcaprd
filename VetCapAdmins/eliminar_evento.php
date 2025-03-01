<?php
require_once('../includes/config.php');

if (isset($_GET['id'])) {
    $query = "DELETE FROM eventos WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    
    echo "Evento eliminado correctamente";
}
?>
