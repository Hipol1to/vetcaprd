<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

function generateUUID() {
    return bin2hex(random_bytes(16)); // Generates a 32-character hex UUID
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $lista_id = $_POST['lista_id'];
    $nombre_lista = $_POST['nombre_lista'];
    $descripcion = $_POST['descripcion'];
    $emails = $_POST['emails']; // This will be an array of emails

    // Check if the lista_id is in hexadecimal and convert it to binary
    if (strlen($lista_id) === 32 && ctype_xdigit($lista_id)) {
        // Convert hexadecimal ID to binary (16 bytes)
        $lista_id = hex2bin($lista_id);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de lista inválido.']);
        exit;
    }

    // Prepare the update query for the list in lista_direcciones_email table
    $query = "UPDATE lista_direcciones_email SET nombre_lista = ?, descripcion = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    
    // Bind parameters and execute
    $stmt->bindParam(1, $nombre_lista);
    $stmt->bindParam(2, $descripcion);
    $stmt->bindParam(3, $lista_id, PDO::PARAM_STR); // Ensure it's treated as a BINARY(16)

    if ($stmt->execute()) {
        // Optionally update the email addresses in the direcciones_email_registradas table
        // First, delete existing emails related to this list
        $deleteEmailsQuery = "DELETE FROM direcciones_email_registradas WHERE lista_id = ?";
        $deleteStmt = $db->prepare($deleteEmailsQuery);
        $deleteStmt->bindParam(1, $lista_id, PDO::PARAM_STR);
        $deleteStmt->execute();

        // Now, insert new email addresses into the direcciones_email_registradas table
        $insertEmailQuery = "INSERT INTO direcciones_email_registradas (id, direccion_id, direccion_email, lista_id, nombre_lista) 
                             VALUES (?, ?, ?, ?, ?)";
        $insertEmailStmt = $db->prepare($insertEmailQuery);
        
        foreach ($emails as $email) {
            // Generate unique UUIDs for id and direccion_id
            $id = hex2bin(str_replace('-', '', generateUUID()));
            $direccion_id = hex2bin(str_replace('-', '', generateUUID()));

            // Execute the insert query
            $insertEmailStmt->execute([$id, $direccion_id, $email, $lista_id, $nombre_lista]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Lista actualizada exitosamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la lista.']);
    }
}
?>