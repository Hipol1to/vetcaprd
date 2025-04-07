<?php
// Set headers for CORS and content type
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database connection file
require('../includes/config.php');

// Read the raw POST data
$input = file_get_contents("php://input");
$data = json_decode($input, true);
write_log("-----STARTING REGISTER USER-----");

if (isset($data['event_id']) && isset($_SESSION['memberID'])) {
    $trxToken = $data['trx_token'];
    $eventId = $data['event_id'];
    $userId = $_SESSION['memberID'];
    write_log("Collected data:");
    write_log("trx token: ".$trxToken);
    write_log("Event Id: ".$eventId);
    write_log("User Id: ".$userId);
    $entityType = "Undefined";

// Check if it's a diplomado
$diplomadoQuery = "SELECT Id FROM diplomados WHERE Id = :diplomadoId";
$stmtDiplomado = $db->prepare($diplomadoQuery);
$stmtDiplomado->bindParam(':diplomadoId', $eventId);
$stmtDiplomado->execute();
$diplomadosRecord = $stmtDiplomado->fetch(PDO::FETCH_ASSOC);

if (isset($diplomadosRecord) && $diplomadosRecord['Id'] == $eventId) {
    write_log("The submitted event has been verified as a course");
    $entityType = "Curso";
} else {
    write_log("The submitted event has been verified as an event");

    // Check if it's a regular event
    $eventoQuery = "SELECT Id FROM eventos WHERE Id = :eventoId";
    $stmtEvento = $db->prepare($eventoQuery);
    $stmtEvento->bindParam(':eventoId', $eventId);
    $stmtEvento->execute();
    $eventosRecord = $stmtEvento->fetch(PDO::FETCH_ASSOC);

    if (isset($eventosRecord) && $eventosRecord['Id'] == $eventId) {
        $entityType = "Evento";
    }
}


    

    if ($trxToken != $_SESSION['trxToken']) {
        echo '<script>
                alert("La información de la transacción es invalida, serás redirigido a la página principal");
              </script>';
        sleep(5);
        header('Location: http://localhost/vescaprod/VetCapMembers/login.php');
    exit(); 
    }



    if ($entityType == "Undefined") {
        write_log("Error: Event entity type is undefined");
        write_log(json_encode(["success" => false, "message" => "System could not verify the type of event."]));
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "System could not verify the type of event."]);
        exit();
    }
    if ($entityType == "Evento") {
        try {
            // Prepare and execute the SQL query
            $stmt = $db->prepare("INSERT INTO usuario_eventos (evento_id, usuario_id) VALUES (:eventoId, :usuarioId)");
            $stmt->bindParam(':eventoId', $eventId);
            $stmt->bindParam(':usuarioId', $userId);
    
            if ($stmt->execute()) {
                write_log(json_encode(["success" => true, "message" => "User successfully registered for the event."]));
                http_response_code(200);
                echo json_encode(["success" => true, "message" => "User successfully registered for the event."]);
            } else {
                write_log(json_encode(["success" => false, "message" => "Failed to register user for the event."]));
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Failed to register user for the event."]);
            }
        } catch (PDOException $e) {
            write_log(json_encode(["success" => false, "message" => "There was a Database error while registering the event: " . $e->getMessage()]));
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "There was a Database error while registering the event: " . $e->getMessage()]);
        }
    } else {
        try {
            // Prepare and execute the SQL query
            $stmt = $db->prepare("INSERT INTO usuario_diplomados (diplomado_id, usuario_id) VALUES (:eventoId, :usuarioId)");
            $stmt->bindParam(':eventoId', $eventId);
            $stmt->bindParam(':usuarioId', $userId);
    
            if ($stmt->execute()) {
                write_log(json_encode(["success" => true, "message" => "User successfully registered for the course."]));
                http_response_code(200);
                echo json_encode(["success" => true, "message" => "User successfully registered for the course."]);
            } else {
                write_log(json_encode(["success" => false, "message" => "Failed to register user for the course."]));
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Failed to register user for the course."]);
            }
        } catch (PDOException $e) {
            write_log(json_encode(["success" => false, "message" => "There was a Database error while registering the course: " . $e->getMessage()]));
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "There was a Database error while registering the course: " . $e->getMessage()]);
        }
    }
} else {
    write_log(json_encode(["success" => false, "message" => "Invalid input. Event ID and User ID are required."]));
    // Invalid or incomplete data
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid input. Event ID and User ID are required."]);
}
?>
