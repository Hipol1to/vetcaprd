<?php
// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database connection file
require('../includes/config.php');

// Read the raw POST data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['event_id']) && isset($_SESSION['memberID'])) {
    $eventId = $data['event_id'];
    $userId = $_SESSION['memberID'];

    try {
        // Prepare and execute the SQL query
        $stmt = $db->prepare("DELETE FROM usuario_eventos WHERE evento_id = :eventoId AND usuario_id = :usuarioId");
        $stmt->bindParam(':eventoId', $eventId);
        $stmt->bindParam(':usuarioId', $userId);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "User has been unsubscribed for the event successfully."]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Failed to unsubscribe user for the event."]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    // Invalid or incomplete data
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid input. Event ID and User ID are required."]);
}
?>
