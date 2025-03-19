<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if (isset($_GET['email_id'])) {
    write_log("Received email_id: " . $_GET['email_id']); // Log the email_id for debugging

    // Prepare the query with UNHEX() applied to the parameter
    $query = "SELECT HEX(id) as id, email FROM direcciones_email WHERE id = UNHEX(?)";
    $stmt = $db->prepare($query);

    // Execute the query with the email_id parameter
    $stmt->execute([$_GET['email_id']]);

    // Fetch the result
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Log and return the result
    echo json_encode($event);
} else {
    write_log("No email_id provided.");
    echo json_encode(['error' => 'No email_id provided.']);
}
?>