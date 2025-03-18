<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["email"])) {
    $email = trim($_POST["email"]);

    // Check if email already exists
    $stmt = $db->prepare("SELECT COUNT(*) FROM direcciones_email WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        echo "Este correo ya está registrado.";
        exit;
    }

    // Insert email
    $stmt = $db->prepare("INSERT INTO direcciones_email (email) VALUES (?)");
    if ($stmt->execute([$email])) {
        echo "Correo registrado exitosamente.";
    } else {
        echo "Error al registrar el correo.";
    }
} else {
    echo "Correo no válido.";
}
?>
