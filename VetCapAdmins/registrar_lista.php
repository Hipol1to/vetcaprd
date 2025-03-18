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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_lista = trim($_POST["nombre_lista"]);
    $descripcion = trim($_POST["descripcion"]);
    $emails = $_POST["emails"] ?? [];

    if (empty($nombre_lista) || empty($emails)) {
        echo "El nombre de la lista y al menos un correo son obligatorios.";
        exit;
    }

    try {
        $db->beginTransaction();

        // Insert into lista_direcciones_email
        $lista_id = generateUUID();
        $stmt = $db->prepare("INSERT INTO lista_direcciones_email (id, nombre_lista, descripcion) VALUES (UNHEX(?), ?, ?)");
        $stmt->execute([$lista_id, $nombre_lista, $descripcion]);

        foreach ($emails as $email) {
            $email = trim($email);
            if (empty($email)) continue;

            // Check if email exists in direcciones_email
            $stmt = $db->prepare("SELECT HEX(id) as id FROM direcciones_email WHERE email = ?");
            $stmt->execute([$email]);
            $email_id = $stmt->fetchColumn();

            // If not, insert into direcciones_email
            if (!$email_id) {
                $email_id = generateUUID();
                $stmt = $db->prepare("INSERT INTO direcciones_email (id, email) VALUES (UNHEX(?), ?)");
                $stmt->execute([$email_id, $email]);
            }

            // Link email with the list in direcciones_email_registradas, including email & list name
            $rel_id = generateUUID();
            $stmt = $db->prepare("
                INSERT IGNORE INTO direcciones_email_registradas (id, direccion_id, direccion_email, lista_id, nombre_lista) 
                VALUES (UNHEX(?), UNHEX(?), ?, UNHEX(?), ?)
            ");
            $stmt->execute([$rel_id, $email_id, $email, $lista_id, $nombre_lista]);
        }

        $db->commit();
        echo "Lista y correos registrados exitosamente.";
    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
