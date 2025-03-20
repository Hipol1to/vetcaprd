<?php
require_once('../includes/config.php');

if (isset($_GET['id'])) {
    $pagoId = $_GET['id'];

    $query = "SELECT * FROM pagos WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$pagoId]);
    $pago = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pago) {
        header('Content-Type: application/json');
        echo json_encode($pago);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Pago no encontrado']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID de pago no proporcionado']);
}