<?php
require_once('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pagoId = $_POST['pagoId'];
    $usuarioId = $_POST['usuarioId'];
    $diplomadoId = $_POST['diplomadoId'];
    $monto = $_POST['monto'];
    $cuentaRemitente = $_POST['cuenta_remitente'];
    $bancoRemitente = $_POST['banco_remitente'];
    $tipoCuentaRemitente = $_POST['tipo_cuenta_remitente'];
    $cuentaDestinatario = $_POST['cuenta_destinatario'];
    $bancoDestinatario = $_POST['banco_destinatario'];
    $tipoCuentaDestinatario = $_POST['tipo_cuenta_destinatario'];
    $fechaDePago = $_POST['fecha_de_pago'];
    $pagoValidado = $_POST['pago_validado'];

    // Update the payment record
    $query = "UPDATE pagos SET 
              monto = ?, 
              cuenta_remitente = ?, 
              banco_remitente = ?, 
              tipo_cuenta_remitente = ?, 
              cuenta_destinatario = ?, 
              banco_destinatario = ?, 
              tipo_cuenta_destinatario = ?, 
              fecha_de_pago = ?, 
              pago_validado = ? 
              WHERE Id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([
        $monto, $cuentaRemitente, $bancoRemitente, $tipoCuentaRemitente, 
        $cuentaDestinatario, $bancoDestinatario, $tipoCuentaDestinatario, 
        $fechaDePago, $pagoValidado, $pagoId
    ]);

    // Insert into usuario_diplomados
    $queryInsert = "INSERT INTO usuario_diplomados (usuario_id, diplomado_id) VALUES (?, ?)";
    $stmtInsert = $db->prepare($queryInsert);
    $stmtInsert->execute([$usuarioId, $diplomadoId]);

    echo "Pago actualizado y usuario registrado en el diplomado correctamente.";
} else {
    http_response_code(400);
    echo "Solicitud inválida.";
}