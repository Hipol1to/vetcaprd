<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require_once('../includes/config.php');

// Get JSON data from the request
$input = file_get_contents('php://input');
$data = json_decode($input, true);
write_log("-----Starting Register Transaction process-----");

if (isset($data)) {
    // Store values
    $id = isset($data['id']) ? $data['id'] : "";
    $eventId = isset($data['eventId']) ? $data['eventId'] : null;
    $usuarioId = $_SESSION['memberID'];
    $trxStatus = isset($data['id']) ? $data['id'] : "";
    $trxCurrencyCode = isset($data['currency_code']) ? $data['currency_code'] : "";
    $trxAmount = isset($data['value']) ? $data['value'] : "";
    $sellerProtectionStatus = isset($data['seller_protection_status']) ? $data['seller_protection_status'] : "";
    $sellerProtectionCategories = isset($data['dispute_categories']) ? $data['dispute_categories'] : "No aplica";
    $paypalCreatedTime = isset($data['create_time']) ? $dateTime = new DateTime($data['create_time']) : "";
    $paypalUpdatedTime = isset($data['update_time']) ? $dateTime = new DateTime($data['update_time']) : "";
    $createdTime = $paypalCreatedTime->format('Y-m-d H:i:s');
    $updatedTime = $paypalUpdatedTime->format('Y-m-d H:i:s');

    try {
      $theRecord = "";
      $eventquery = $db->prepare("SELECT * FROM `eventos` WHERE Id = :eventoId");
      $eventquery->bindParam(':eventoId', $eventId);
      $eventquery->execute();
      // Fetch only the first row
      $eventRow = $eventquery->fetch(PDO::FETCH_ASSOC);
      $theRecord = $eventRow;
      write_log("Fetching event info");
      write_log(print_r($eventRow, true));
      if (isset($eventRow) || $eventRow == null) {
        $courseQuery = $db->prepare("SELECT * FROM `diplomados` WHERE Id = :eventoId");
        $courseQuery->bindParam(':eventoId', $eventId);
        $courseQuery->execute();
        // Fetch only the first row
        $courseRow = $courseQuery->fetch(PDO::FETCH_ASSOC);
        write_log("Fetching course info");
        write_log(print_r($courseRow, true));
        $theRecord = $courseRow;
      }
      
    } catch (Exception $e) {
      die("Error fetching data: " . $e->getMessage());
    }
    $amount = $theRecord['precio_inscripcion']; // Replace this with the desired amount
    $conversionRate = 61.50;
    $amountConverted = $amount / $conversionRate;
    $extraFee = $amountConverted * 0.05;
    $amountToCharge = $amountConverted + $extraFee;
    $amountToChargeFormatted = number_format($amountToCharge, 2);

    write_log("id parameter : ".$id);
    write_log("event id: ".$eventId);
    write_log("the user id: ".$usuarioId);
    write_log("Transaction status: ".$trxStatus);
    write_log("Transaction Currency Code: ".$trxCurrencyCode);
    write_log("Trx amount arrived :".$trxAmount);
    write_log("Seller Protection Status: ".$sellerProtectionStatus);
    write_log("Seller Protection Categories: ".$sellerProtectionCategories);
    write_log("Expected amount: ".$amountToChargeFormatted);


    try {
      $stmt = $db->prepare('SELECT * from finanzas WHERE ambiente = "Prod" ');
      $stmt->execute();
  
      $receiverAccount = $stmt->fetch();
  
    } catch(PDOException $e) {
      write_log("There was an error trying to get the receiver account details: ".$e->getMessage());
    }





    //$receiverAccount = get_receiver_account_details();

    write_log("printing trx values");
    write_log("trx Id: ".$id);
    write_log("trx status: ".$trxStatus);
    write_log("trx currency code: ".$trxCurrencyCode);
    write_log("trx amount: ".$trxAmount);
    write_log("trx seller protection status: ".$sellerProtectionStatus);
    write_log("trx dispute categories: ".$sellerProtectionCategories);
    write_log("trx created time: ".$createdTime);
    write_log("trx updated time: ".$updatedTime);
    write_log("ok");

    if ($eventId == null) {
      echo "Ha habido un erro obteniendo la informacion sobre el evento, contacta al administrador mostrando este mensaje";
      write_log("------------EVENT ID NULL ERROR LOG START------------");
      write_log("Ha habido un erro obteniendo la informacion sobre el evento, contacta al administrador mostrando este mensaje");
      write_log("The event ID could not be fetch, check file trx.js to see what we are getting on eventId field in post request");
      write_log("User: ".$_SESSION['username']);
      write_log("Transaction ammount: ".$trxAmount);
      write_log("Date time:".date("h:i:sa"));
      write_log("------------SESSION DETAILS END------------");
      exit();
    }
    if ($trxAmount != $amountToChargeFormatted) {
      write_log("------------TRX AMOUNT ERROR LOG START------------");
      write_log("The transaction ammount is different from expected");
      write_log("Amount sent:".$trxAmount);
      write_log("Formated amount to charge:".$amountToChargeFormatted);
      echo '<script>
      alert("La información de la transacción es invalida, serás redirigido a la página principal");
            </script>';
      sleep(5);
      header('Location: http://localhost/vescaprod/VetCapMembers/login.php');
      exit(); 
    } else {
      if (isset($eventRow) || $eventRow == null) {
      try {
          //insert into database with a prepared statement

          $stmt = $db->prepare('INSERT INTO pagos (Id,
           monto, 
           metodo_de_pago,
           pago_validado, 
           evento_id, 
           usuario_id, 
           cuenta_remitente, 
           banco_remitente, 
           tipo_cuenta_remitente, 
           cuenta_destinatario, 
           banco_destinatario, 
           tipo_cuenta_destinatario, 
           fecha_de_pago, fecha_creacion, fecha_modificacion) 
           VALUES (:id, 
           :monto, 
           :metodoDePago,
           :pagoValidado, 
           :eventoId, 
           :usuarioId, 
           :cuentaRemitente, 
           :bancoRemitente, 
           :tipoCuentaRemitente, 
           :cuentaDestinatario, 
           :bancoDestinatario, 
           :tipoCuentaDestinatario, 
           :fechaDePago, 
           :fechaDeCreacion, 
           :fechaDeModificacion)');
          if($stmt->execute(array(
            ':id' => $id,
            ':monto' => $trxAmount,
            ':metodoDePago' => "Tarjeta de débito/crédito vía PayPal",
            ':pagoValidado' => 1,
            ':eventoId' => $eventId,
            ':usuarioId' => $usuarioId,
            ':cuentaRemitente' => "Verificar en PayPal con Id de Transaccion",
            ':bancoRemitente' => "PayPal",
            ':tipoCuentaRemitente' => "Tarjeta de débito/crédito",
            ':cuentaDestinatario' => $receiverAccount['correo_electronico'],
            ':bancoDestinatario' => $receiverAccount['banco'],
            ':tipoCuentaDestinatario' => $receiverAccount['tipo_cuenta'],
            ':fechaDePago' => $createdTime,
            ':fechaDeCreacion' => $createdTime,
            ':fechaDeModificacion' => $updatedTime
          ))) {
            $_SESSION['trxToken'] = uniqid();
            http_response_code(200);
            write_log(json_encode(["success" => true, "message" => "The transaction was succesfully registered.", "trxToken" => $_SESSION['trxToken']]));
            echo json_encode(["success" => true, "message" => "The transaction was succesfully registered.", "trxToken" => $_SESSION['trxToken']]);
          } else {
            http_response_code(500);
            write_log(json_encode(["success" => false, "message" => "Failed to register the transaction."]));
            echo json_encode(["success" => false, "message" => "Failed to register the transaction."]);
          }

        

        
        //else catch the exception and show the error.
        } catch(PDOException $e) {
            $error[] = $e->getMessage();
            write_log($e->getMessage());
            http_response_code(500);
            write_log(json_encode(["success" => false, "message" => "Failed to register the transaction: ".$e->getMessage()]));
            echo json_encode(["success" => false, "message" => "Failed to register the transaction: ".$e->getMessage()]);
        }
      } else {
        try {
          //insert into database with a prepared statement

          $stmt = $db->prepare('INSERT INTO pagos (Id,
           monto, 
           metodo_de_pago,
           pago_validado, 
           diplomado_id, 
           usuario_id, 
           cuenta_remitente, 
           banco_remitente, 
           tipo_cuenta_remitente, 
           cuenta_destinatario, 
           banco_destinatario, 
           tipo_cuenta_destinatario, 
           fecha_de_pago, fecha_creacion, fecha_modificacion) 
           VALUES (:id, 
           :monto, 
           :metodoDePago,
           :pagoValidado, 
           :eventoId, 
           :usuarioId, 
           :cuentaRemitente, 
           :bancoRemitente, 
           :tipoCuentaRemitente, 
           :cuentaDestinatario, 
           :bancoDestinatario, 
           :tipoCuentaDestinatario, 
           :fechaDePago, 
           :fechaDeCreacion, 
           :fechaDeModificacion)');
          if($stmt->execute(array(
            ':id' => $id,
            ':monto' => $trxAmount,
            ':metodoDePago' => "Tarjeta de débito/crédito vía PayPal",
            ':pagoValidado' => 1,
            ':eventoId' => $eventId,
            ':usuarioId' => $usuarioId,
            ':cuentaRemitente' => "Verificar en PayPal con Id de Transaccion",
            ':bancoRemitente' => "PayPal",
            ':tipoCuentaRemitente' => "Tarjeta de débito/crédito",
            ':cuentaDestinatario' => $receiverAccount['correo_electronico'],
            ':bancoDestinatario' => $receiverAccount['banco'],
            ':tipoCuentaDestinatario' => $receiverAccount['tipo_cuenta'],
            ':fechaDePago' => $createdTime,
            ':fechaDeCreacion' => $createdTime,
            ':fechaDeModificacion' => $updatedTime
          ))) {
            $_SESSION['trxToken'] = uniqid();
            http_response_code(200);
            write_log(json_encode(["success" => true, "message" => "The transaction was succesfully registered.", "trxToken" => $_SESSION['trxToken']]));
            echo json_encode(["success" => true, "message" => "The transaction was succesfully registered.", "trxToken" => $_SESSION['trxToken']]);
          } else {
            http_response_code(500);
            write_log(json_encode(["success" => false, "message" => "Failed to register the transaction."]));
            echo json_encode(["success" => false, "message" => "Failed to register the transaction."]);
          }

        

        
        //else catch the exception and show the error.
        } catch(PDOException $e) {
            $error[] = $e->getMessage();
            write_log($e->getMessage());
            http_response_code(500);
            write_log(json_encode(["success" => false, "message" => "Failed to register the transaction: ".$e->getMessage()]));
            echo json_encode(["success" => false, "message" => "Failed to register the transaction: ".$e->getMessage()]);
        }
      }
      }
} else {
  // Invalid or incomplete data
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Invalid input. Request data is required8."]);
}
function get_receiver_account_details() {
  try {
    $stmt = $db->prepare('SELECT * from finanzas WHERE ambiente = "Sandbox" ');
    $stmt->execute();

    return $stmt->fetch();

  } catch(PDOException $e) {
    write_log("There was an error trying to get the receiver account details: ".$e->getMessage());
  }
}
?>
