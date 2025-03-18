<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}

if (isset($_GET['id'])) {
    $lista_id = $_GET['id'];

    if (strlen($lista_id) === 32 && ctype_xdigit($lista_id)) {
        $lista_id_bin = hex2bin($lista_id);

        // Delete from lista_direcciones_email
        $query = "DELETE FROM lista_direcciones_email WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$lista_id_bin]);

        // Delete from direcciones_email_registradas
        $query = "DELETE FROM direcciones_email_registradas WHERE lista_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$lista_id_bin]);

        echo "Evento eliminado correctamente";
    } else {
        echo "ID de lista inválido.";
    }
} else {
    echo "No se proporcionó un ID de lista.";
}
?>