<?php
require('includes/config.php');
header('Content-Type: application/json');

// Get JSON data from the request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data)) {
    // Store values
    $id = isset($data['id']) : $data['id'] ? "";
    $eventId = isset($data['eventId']) : $data['eventId'] ? null;
    $trxStatus = isset($data['id']) : $data['id'] ? "";
    $trxCurrencyCode = isset($data['currency_code']) : $data['currency_code'] ? "";
    $trxAmount = isset($data['value']) : $data['value'] ? "";
    $sellerProtectionStatus = isset($data['seller_protection_status']) : $data['seller_protection_status'] ? "";
    $sellerProtectionCategories = isset($data['dispute_categories']) : $data['dispute_categories'] ? "";
    $createdTime = isset($data['create_time']) : $data['create_time'] ? "";
    $updatedTime = isset($data['update_time']) : $data['update_time'] ? "";

    error_log("printing trx values");
    error_log("trx Id: ".$data['id']);
    error_log("trx status: ".$data['status']);
    error_log("trx currency code: ".$data['currency_code']);
    error_log("trx amount: ".$data['value']);
    error_log("trx seller protection status: ".$data['seller_protection_status']);
    error_log("trx dispute categories: ".$data['dispute_categories']);
    error_log("trx created time: ".$data['create_time']);
    error_log("trx updated time: ".$data['update_time']);
    error_log("ok");

    if ($eventId == null) {
      echo "Ha habido un erro obteniendo la informacion sobre el evento, contacta al administrador mostrando este mensaje";
      error_log("Ha habido un erro obteniendo la informacion sobre el evento, contacta al administrador mostrando este mensaje");
      error_log("The event ID could not be fetch, check file trx.js to see what we are getting on eventId field in post request");
      error_log("------------SESSION DETAILS START------------");
      error_log("User: ".$_SESSION['username']);
      error_log("Transaction ammount: ".$trxAmount);
      error_log("Date time:".date("h:i:sa"));
      error_log("------------SESSION DETAILS END------------");
      exit();
    }

    try {
      error_log('INSERT INTO pagos (Id, monto, metodo_de_pago, evento_id, cuenta_remitente, banco_remitente, tipo_cuenta_remitente, cuenta_destinatario, banco_destinatario, tipo_cuenta_destinatario, fecha_de_pago, fecha_de_creacion, fecha_de_modificacion) VALUES (:'.$id.', :'.$nombre.', :'.$apellido.', :'.$telefono.', :'.$correo_electronico.', :'.$usuario.', :'.$contrasena.', :'.$fecha_nacimiento.', :'.$tipo_visitante.', :'.$tipo_estudiante.', :'.$universidad.', :cliente, :0, :'.$activasion.')');
        //insert into database with a prepared statement
      
        $stmt = $db->prepare('INSERT INTO pagos (Id,
         monto, 
         metodo_de_pago, 
         evento_id, 
         cuenta_remitente, 
         banco_remitente, 
         tipo_cuenta_remitente, 
         cuenta_destinatario, 
         banco_destinatario, 
         tipo_cuenta_destinatario, 
         fecha_de_pago, fecha_de_creacion, fecha_de_modificacion) 
         VALUES (:id, 
         :monto, 
         :metodoDePago, 
         :eventoId, 
         :cuentaRemitente, 
         :bancoRemitente, 
         :tipoCuentaRemitente, 
         :cuentaDestinatario, 
         :bancoDestinatario, 
         :tipoCuentaDestinatario, 
         :fechaDePago, 
         :fechaDeCreacion, 
         :fechaDeModificacion)');
        $stmt->execute(array(
          ':id' => $id,
          ':monto' => $trxAmount,
          ':metodoDePago' => "Tarjeta de débito/crédito vía PayPal",
          ':eventoId' => $eventId,
          ':cuentaRemitente' => "Verificar en PayPal con Id de Transaccion",
          ':bancoRemitente' => "PayPal",
          ':tipoCuentaRemitente' => "Tarjeta de débito/crédito",
          ':cuentaDestinatario' => "",
          ':bancoDestinatario' => $fecha_nacimiento,
          ':tipoCuentaDestinatario' => $tipo_visitante,
          ':fechaDePago' => $tipo_estudiante,
          ':fechaDeCreacion' => $universidad,
          ':fechaDeModificacion' => 'cliente'
        ));
        
      
        //send email
        $to = $_POST['correo_electronico'];
        $subject = "Activa tu cuenta";
        $body = "<p>Gracias por registrarte en Fundacion Vetcap.</p>
        <p>Para activar tu cuenta, por favor clica este enlace: <a href='".DIR."activa-tu-cuenta.php?x=$id&y=$activasion'>".DIR."activa-tu-cuenta.php?x=$id&y=$activasion</a></p>
        <p>Atentamente, el equipo de Fundacion Vetcap</p>";
      
        $mail = new Mail();
        $mail->setFrom(SITEEMAIL);
        $mail->addAddress($to);
        $mail->subject($subject);
        $mail->body($body);
        $mail->send();
      
        //redirect to index page
        header('Location: unete-a-nosotros.php?action=joined');
        exit;
      
      //else catch the exception and show the error.
      } catch(PDOException $e) {
          $error[] = $e->getMessage();
          error_log($e->getMessage());
      }
}
?>
