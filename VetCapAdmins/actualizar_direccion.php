<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email_id = $_POST['email_id'] ?? null;
    $email = $_POST['correo_electronico'] ?? null;

    // Validate input
    if (empty($email_id) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Check if the email_id is a valid 32-character hexadecimal string
    if (strlen($email_id) !== 32 || !ctype_xdigit($email_id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID de correo inválido.']);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no es válido.']);
        exit;
    }

    try {
        // Prepare the update query
        $query = "UPDATE direcciones_email SET email = ? WHERE id = UNHEX(?)";
        $stmt = $db->prepare($query);

        // Execute the query with the email and email_id parameters
        $stmt->execute([$email, $email_id]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Correo actualizado exitosamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontró el correo o no se realizaron cambios.']);
        }
    } catch (Exception $e) {
        // Handle database errors
        error_log("Error updating email: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el correo.']);
    }
} else {
    // Handle invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
}
?>