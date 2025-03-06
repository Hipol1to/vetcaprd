<?php
require_once('../includes/config.php');

header('Content-Type: application/json');

// Check if the query parameter is set
$query = isset($_POST['query']) ? trim($_POST['query']) : '';
error_log("Received query: " . $query);

try {
    // Ensure database connection is established
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    // Prepare the SQL query
    if (empty($query)) {
        // Fetch all lists if the query is empty
        $stmt = $db->prepare("SELECT HEX(id) AS id, nombre_lista FROM lista_direcciones_email");
        $stmt->execute();
    } else {
        // Fetch filtered lists if the query is not empty
        $stmt = $db->prepare("SELECT HEX(id) AS id, nombre_lista FROM lista_direcciones_email WHERE nombre_lista LIKE ?");
        $stmt->execute(["%$query%"]);
    }

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