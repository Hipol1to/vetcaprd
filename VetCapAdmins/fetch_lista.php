<?php
require_once('../includes/config.php');

if (isset($_GET["lista_id"])) {
    $lista_id = $_GET["lista_id"];

    // Get list details
    $stmt = $db->prepare("SELECT HEX(id) as lista_id, nombre_lista, descripcion FROM lista_direcciones_email WHERE id = UNHEX(?)");
    $stmt->execute([$lista_id]);
    $lista = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$lista) {
        echo json_encode(["error" => "Lista no encontrada"]);
        exit;
    }

    // Get emails linked to the list
    $stmt = $db->prepare("SELECT direccion_email FROM direcciones_email_registradas WHERE lista_id = UNHEX(?)");
    $stmt->execute([$lista_id]);
    $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $lista["emails"] = $emails;
    echo json_encode($lista);
}
?>
