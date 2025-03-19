<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

header('Content-Type: application/json');

$query = isset($_POST['query']) ? trim($_POST['query']) : '';
write_log("Received query: " . $query);

try {
    // Ensure database connection is established
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    // Prepare the SQL query
    if (empty($query)) {
        // Fetch all emails if the query is empty
        $stmt = $db->prepare("SELECT HEX(id) AS id, email FROM direcciones_email");
        $stmt->execute();
    } else {
        // Fetch filtered emails if the query is not empty
        $stmt = $db->prepare("SELECT HEX(id) AS id, email FROM direcciones_email WHERE email LIKE ?");
        $stmt->execute(["%$query%"]);
    }

    // Fetch results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    write_log("Query results: " . json_encode($results));

    echo json_encode($results);
} catch (Exception $e) {
    write_log("Error: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>