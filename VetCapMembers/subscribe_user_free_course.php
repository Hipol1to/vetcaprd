<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require_once('../includes/config.php');

// Get JSON data from the request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data)) {
    $eventId = isset($data['event_id']) ? $data['event_id'] : null;
    $userId = $_SESSION['memberID'];
    try {
        $eventquery = $db->prepare("SELECT * FROM `eventos` WHERE Id = :eventoId");
        $eventquery->bindParam(':eventoId', $eventId);
        $eventquery->execute();
        // Fetch only the first row
        $eventRow = $eventquery->fetch(PDO::FETCH_ASSOC);
        write_log("Fetching event info");
        write_log(print_r($eventRow, true));
        
      } catch (Exception $e) {
        die("Error fetching data: " . $e->getMessage());
      }
    if ($eventRow['precio_inscripcion'] != 0.00) {
        http_response_code(400);
        write_log(json_encode(["success" => false, "message" => "Error, this event is not registered as free."]));
        echo json_encode(["success" => false, "message" => "Error, this event is not registered as free."]);
    } else {
        try {
            // Prepare and execute the SQL query
            $stmt = $db->prepare("INSERT INTO usuario_eventos (evento_id, usuario_id) VALUES (:eventoId, :usuarioId)");
            $stmt->bindParam(':eventoId', $eventId);
            $stmt->bindParam(':usuarioId', $userId);
    
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(["success" => true, "message" => "User successfully registered for the event."]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Failed to register user for the event."]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }
}
?>
