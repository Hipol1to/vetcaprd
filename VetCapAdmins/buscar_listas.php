<?php
require_once('../includes/config.php');

header('Content-Type: application/json');

if (!isset($_POST['query']) || empty(trim($_POST['query']))) {
    echo json_encode([]);
    exit;
}

$query = trim($_POST['query']);
error_log("Received query: " . $query);

try {
    // Ensure database connection is established
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    // Prepare statement with case-insensitive search
    $stmt = $db->prepare("SELECT HEX(id) AS id, nombre_lista FROM lista_direcciones_email WHERE nombre_lista LIKE ?");
    $stmt->execute(["%$query%"]);

    // Fetch results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Query results: " . json_encode($results));

    echo json_encode($results);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>