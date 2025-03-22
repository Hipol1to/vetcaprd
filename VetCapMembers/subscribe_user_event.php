<?php
require_once('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    write_log("-----Starting payment processing-----");

    $upload_directory = __DIR__ . "/uploads/";
    $comprobante_path = "";

    // Handle the uploaded file if it's present and valid
    if (isset($_FILES['comprobante_pago']) && $_FILES['comprobante_pago']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid() . '_' . $_FILES['comprobante_pago']['name'];
        if (move_uploaded_file($_FILES['comprobante_pago']['tmp_name'], $upload_directory . $file_name)) {
            $comprobante_path = $upload_directory . $file_name;
        } else {
            write_log("Failed to move uploaded file.");
        }
    } else {
        write_log("No valid comprobante file uploaded.");
    }

    try {
        // Collect and sanitize input data
        $id = uniqid();
        $evento_id = $_POST['eventId'] ?? '';
        $usuario_id = $_SESSION['memberID'] ?? '';
        $monto = $_POST['addMonto'] ?? '0';
        $metodo_de_pago = $_POST['metodo_de_pago'] ?? '';
        $cuenta_remitente = $_POST['addCuentaRemitente'] ?? 'Validar';
        $banco_remitente = $_POST['addEntidadBancariaRemitente'] ?? 'Validar';
        $tipo_cuenta_remitente = $_POST['editTipoCuentaRemitente'] ?? 'Validar';
        $cuenta_destinatario = $_POST['addCuentaDestinatario'] ?? 'Validar';; // Default value if required, adjust as necessary
        $banco_destinatario = $_POST['addEntidadBancariaDestinatario'] ?? 'Validar'; // Adjust as necessary
        $tipo_cuenta_destinatario = $_POST['editTipoCuentaDestinatario'] ?? 'Validar'; // Adjust as necessary
        $fecha_de_pago = date('Y-m-d H:i:s'); // Current timestamp

        // Prepare SQL statement
        $query = "
            INSERT INTO pagos (
                Id, monto, comprobante_pago_ruta, metodo_de_pago, pago_validado,
                evento_id, usuario_id, cuenta_remitente, banco_remitente,
                tipo_cuenta_remitente, cuenta_destinatario, banco_destinatario,
                tipo_cuenta_destinatario, fecha_de_pago
            ) VALUES (
                :Id, :monto, :comprobante_pago_ruta, :metodo_de_pago, 0,
                :evento_id, :usuario_id, :cuenta_remitente, :banco_remitente,
                :tipo_cuenta_remitente, :cuenta_destinatario, :banco_destinatario,
                :tipo_cuenta_destinatario, :fecha_de_pago
            )
        ";

        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':Id', $id);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':comprobante_pago_ruta', $comprobante_path);
        $stmt->bindParam(':metodo_de_pago', $metodo_de_pago);
        $stmt->bindParam(':evento_id', $evento_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':cuenta_remitente', $cuenta_remitente);
        $stmt->bindParam(':banco_remitente', $banco_remitente);
        $stmt->bindParam(':tipo_cuenta_remitente', $tipo_cuenta_remitente);
        $stmt->bindParam(':cuenta_destinatario', $cuenta_destinatario);
        $stmt->bindParam(':banco_destinatario', $banco_destinatario);
        $stmt->bindParam(':tipo_cuenta_destinatario', $tipo_cuenta_destinatario);
        $stmt->bindParam(':fecha_de_pago', $fecha_de_pago);

        // Execute the statement
        if ($stmt->execute()) {
            write_log("Payment information successfully inserted.");
            /*try {
                // Prepare and execute the SQL query
                $stmt = $db->prepare("INSERT INTO usuario_eventos (evento_id, usuario_id) VALUES (:eventoId, :usuarioId)");
                $stmt->bindParam(':eventoId', $evento_id);
                $stmt->bindParam(':usuarioId', $usuario_id);
        
                if ($stmt->execute()) {
                    write_log(json_encode(["success" => true, "message" => "User successfully registered for the event."]));
                } else {
                    write_log(json_encode(["success" => false, "message" => "Failed to register user for the event."]));
                }
            } catch (PDOException $e) {
                write_log(json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]));
            }*/
            header('Location: https://www.vetcaprd.com//VetCapMembers/index.php');
            exit();
        } else {
            write_log("Failed to insert payment information.");
            header('Location: https://www.vetcaprd.com//VetCapMembers/index.php');
            exit();
        }
    } catch (Exception $e) {
        write_log("Error while processing payment: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "An error occurred while processing the payment."]);
    }
}
?>
