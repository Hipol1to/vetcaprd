<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}
require_once dirname(__DIR__) . '/includes/classes/PHPMailer/Exception.php';
require_once dirname(__DIR__) . '/includes/classes/PHPMailer/PHPMailer.php';
require_once dirname(__DIR__) . '/includes/classes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoDestinatario = $_POST['tipoDestinatario'] ?? null; // Get the selected recipient type
    $listaId = $_POST['listaId'] ?? null; // Only used for list recipients
    $destinatario = $_POST['destinatario'] ?? null; // Only used for single recipient
    $titulo = $_POST['emailTitulo'] ?? 'No recibido';
    if (isset($_POST['emailMensaje'])) {
        write_log($_POST['emailMensaje']);
    }
    try {
        $mensaje = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $_POST['emailMensaje']); // Sanitize the input
    } catch (\Throwable $th) {
        $_GET['invalido'] = 1;
        header('Location: correos.php');
        exit;
    }
    $attachmentsString = $_POST['emailAdjunto'] ?? 'No recibido';
    write_log("Received tipoDestinatario: " . $tipoDestinatario);
    write_log("Received listaId: " . $listaId);
    write_log("Received destinatario: " . $destinatario);
    write_log("Received titulo: " . $titulo);
    write_log("Received mensaje: " . $mensaje);

    // Validate recipient type
    if (!$tipoDestinatario) {
        die("Error: No se ha seleccionado un tipo de destinatario válido.");
    }

    // Fetch recipient(s) based on the selected type
    $emails = [];
    if ($tipoDestinatario === "lista") {
        // Fetch emails from the selected list
        if (!$listaId) {
            die("Error: No se ha seleccionado una lista válida.");
        }

        $stmt = $db->prepare("
            SELECT direccion_email 
            FROM direcciones_email_registradas 
            WHERE lista_id = UNHEX(?)
        ");
        $stmt->execute([$listaId]);
        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } elseif ($tipoDestinatario === "direccion") {
        // Use the single recipient
        if (!$destinatario) {
            die("Error: No se ha proporcionado un destinatario válido.");
        }
        $emails = [$destinatario]; // Single recipient as an array
    }

    write_log("Recipients: " . json_encode($emails));

    if (empty($emails)) {
        die("Error: No hay correos válidos para enviar.");
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

        // Add recipients
        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        // 🟢 1. Handle Base64 Images
        preg_match_all('/<img[^>]+src="data:image\/(png|jpeg|jpg|gif);base64,([^"]+)"[^>]*>/i', $mensaje, $matches, PREG_SET_ORDER);

        $imagePaths = []; // Store paths of saved images

        foreach ($matches as $index => $match) {
            $imageType = $match[1];  // Extract image type (png, jpeg, etc.)
            $imageData = base64_decode($match[2]);  // Decode Base64
            $imageCid  = "image" . $index;  // Unique CID for each image

            // Save image to a directory
            $imageFileName = "image_$index.$imageType";
            $imagePath = "path/to/images/$imageFileName"; // Adjust the path as needed
            file_put_contents($imagePath, $imageData);

            // Store the image path for later use
            $imagePaths[$imageCid] = $imagePath;

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

        // 🟢 Send the Email
        if ($mail->send()) {
            $imagePaths[$imageCid] = $filePath;
            // Save the message and image paths to the database
            $emailId = uniqid(); // Generate unique email ID
            $remitente = 'info@vetcaprd.com';

            // Convert image paths to a string for database storage
            $imagePathsString = !empty($imagePaths) ? json_encode($imagePaths) : null;

            $stmt = $db->prepare("INSERT INTO emails (Id, titulo, mensaje, remitente, destinatario, adjuntos_ruta, image_paths) 
                                   VALUES (:Id, :titulo, :mensaje, :remitente, :destinatario, :adjuntos_ruta, :image_paths)");
            $stmt->execute([
                ':Id' => $emailId,
                ':titulo' => $titulo,
                ':mensaje' => $mensaje,
                ':remitente' => $remitente,
                ':destinatario' => implode(',', $emails), // Store all recipients as a comma-separated string
                ':adjuntos_ruta' => $attachmentsString,
                ':image_paths' => $imagePathsString
            ]);

            // Redirect if succeed
            $_GET['enviado'] = 1;
            header('Location: correos.php');
            exit;
        } else {
            echo "Error al enviar el correo.";
        }
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>