<?php
require_once('../includes/config.php');
require_once dirname(__DIR__) . '/includes/classes/PHPMailer/Exception.php';
require_once dirname(__DIR__) . '/includes/classes/PHPMailer/PHPMailer.php';
require_once dirname(__DIR__) . '/includes/classes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listaId = $_POST['listaId'] ?? null;
    $titulo = $_POST['emailTitulo'] ?? 'No recibido';
    $mensaje = $_POST['emailMensaje'] ?? 'No recibido';

    if (!$listaId) {
        die("Error: No se ha seleccionado una lista válida.");
    }

    // Fetch all email addresses from the selected list
    $stmt = $db->prepare("
        SELECT de.email 
        FROM direcciones_email de
        JOIN direcciones_email_registradas der ON de.id = der.direccion_id
        WHERE der.lista_id = UNHEX(?)
    ");
    $stmt->execute([$listaId]);
    $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($emails)) {
        die("Error: No hay correos en la lista seleccionada.");
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'thelegendstutorials@gmail.com';
        $mail->Password   = 'zmfb uwso jmpk yybe';
        $mail->Port       = 587;

        // Email Details
        $mail->setFrom('thelegendstutorials@gmail.com', 'Fundacion VetCap');

        // Add multiple recipients
        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        // 🟢 1. Handle Base64 Images
        preg_match_all('/<img[^>]+src="data:image\/(png|jpeg|jpg|gif);base64,([^"]+)"[^>]*>/i', $mensaje, $matches, PREG_SET_ORDER);

        foreach ($matches as $index => $match) {
            $imageType = $match[1];  // Extract image type (png, jpeg, etc.)
            $imageData = base64_decode($match[2]);  // Decode Base64
            $imageCid  = "image" . $index;  // Unique CID for each image

            // Save image as a temporary file
            $tempImagePath = sys_get_temp_dir() . "/embedded_image_$index.$imageType";
            file_put_contents($tempImagePath, $imageData);

            // Embed the image in email
            $mail->addEmbeddedImage($tempImagePath, $imageCid, "image$index.$imageType");

            // Replace Base64 `src` with `cid:imageX`
            $mensaje = str_replace($match[0], '<img src="cid:' . $imageCid . '">', $mensaje);
        }

        // 🟢 2. Handle Regular Image Paths
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $mensaje, $fileMatches, PREG_SET_ORDER);

        foreach ($fileMatches as $index => $fileMatch) {
            $filePath = $fileMatch[1]; // Get the file path

            // Check if the file exists (assuming it's in `docuploads/` folder)
            if (file_exists($filePath)) {
                $imageCid = "fileImage" . $index; // Unique CID for each file

                // Embed the local file image
                $mail->addEmbeddedImage($filePath, $imageCid, basename($filePath));

                // Replace file path `src` with `cid:fileImageX`
                $mensaje = str_replace($fileMatch[0], '<img src="cid:' . $imageCid . '">', $mensaje);
            }
        }

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $titulo;
        $mail->Body    = $mensaje;

        // Send Email
        if ($mail->send()) {
            // Save email to database
            $emailId = uniqid(); // Generate unique email ID
            $remitente = 'thelegendstutorials@gmail.com';

            // Convert attachments to a string for database storage
            $attachmentsPaths = []; // Add logic to populate this array if needed
            $attachmentsString = !empty($attachmentsPaths) ? implode(',', $attachmentsPaths) : null;

            $stmt = $db->prepare("INSERT INTO emails (Id, titulo, mensaje, remitente, destinatario, adjuntos_ruta) 
                                   VALUES (:Id, :titulo, :mensaje, :remitente, :destinatario, :adjuntos_ruta)");
            $stmt->execute([
                ':Id' => $emailId,
                ':titulo' => $titulo,
                ':mensaje' => $mensaje,
                ':remitente' => $remitente,
                ':destinatario' => implode(',', $emails), // Store all recipients as a comma-separated string
                ':adjuntos_ruta' => $attachmentsString
            ]);

            // Redirect if succeed
            header('Location: correos.php?enviado=1');
            exit;
        } else {
            echo "Error al enviar el correo.";
        }
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>