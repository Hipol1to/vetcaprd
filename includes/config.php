<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/London');

//database credentials
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','vetcap_storage');
define('ENCRYPTION_KEY', base64_decode('G9S/vWXp8aNCL2NRQFQ/oHjdJJ3kbsT/mLxukjMMN8Q='));
define('ENCRYPTION_IV', '5938506185430479'); // Must be 16 bytes for AES-256-CBC


//application address
define('DIR','http://localhost/vesca/');
define('PAGE','http://localhost/vesca/');
define('SITEEMAIL','noreply@domain.com');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}
function encryptValue($value) {
    $key = ENCRYPTION_KEY;  // 256-bit key
    $iv = ENCRYPTION_IV;    // 16-byte initialization vector

    // Encrypt the value
    $encrypted = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);

    // Encode the encrypted value in base64 to pass it safely
    return base64_encode($encrypted);
}

function decryptValue($encryptedValue) {
    $key = ENCRYPTION_KEY;
    $iv = ENCRYPTION_IV;

    // Decode the base64 value
    $decoded = base64_decode($encryptedValue);

    // Decrypt and return the original value
    return openssl_decrypt($decoded, 'aes-256-cbc', $key, 0, $iv);
}

function getAllEvents($dbContext) {
    try {
        $query = $dbContext->prepare("SELECT * FROM `eventos` ORDER BY fecha_evento ASC");
        $query->execute();
        // Fetch only the first row
        $_SESSION['nextEvent'] = $query->fetch(PDO::FETCH_ASSOC);
        $eventos = $query->fetchAll(PDO::FETCH_ASSOC);
        error_log("------STARTING SESSION LOG------");
        error_log(print_r($_SESSION['nextEvent'], true));
        return $eventos;
      } catch (Exception $e) {
        error_log("------ERROR START------");
        error_log("There was an error while trying to get all events");
        error_log($e->getMessage());
        error_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getUserEvents($dbContext) {
    try {
        $myEventsQuery = $dbContext->prepare("SELECT * FROM eventos LEFT JOIN usuario_eventos ON eventos.Id = usuario_eventos.evento_id WHERE usuario_eventos.usuario_id = :userId");
        $myEventsQuery->bindParam(':userId', $_SESSION['memberID']);
        $myEventsQuery->execute();
        $misEventos = $myEventsQuery->fetchAll(PDO::FETCH_ASSOC);
        return $misEventos;
      } catch (Exception $e) {
        error_log("------ERROR START------");
        error_log("There was an error while trying to get user events");
        error_log($e->getMessage());
        error_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getUserPendingEvents($dbContext) {
    try {
        $myPendingEventsQuery = $dbContext->prepare("SELECT DISTINCT eventos.* FROM eventos LEFT JOIN pagos ON eventos.Id = pagos.evento_id WHERE pagos.usuario_id = :userId AND pagos.pago_validado = 0");
        $myPendingEventsQuery->bindParam(':userId', $_SESSION['memberID']);
        $myPendingEventsQuery->execute();
        $misPendingEventos = $myPendingEventsQuery->fetchAll(PDO::FETCH_ASSOC);
        error_log("User events pending for verification:" . print_r($misPendingEventos, true));
        return $misPendingEventos;
      } catch (Exception $e) {
        error_log("------ERROR START------");
        error_log("There was an error while trying to get user pending events");
        error_log($e->getMessage());
        error_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getDiplomadosEvents($dbContext) {
    try {
        $query = $dbContext->prepare("SELECT * FROM `eventos` ORDER BY fecha_evento ASC");
        $query->execute();
        // Fetch only the first row
        $_SESSION['nextEvent'] = $query->fetch(PDO::FETCH_ASSOC);
        $eventos = $query->fetchAll(PDO::FETCH_ASSOC);
        error_log("------STARTING SESSION LOG------");
        error_log(print_r($_SESSION['nextEvent'], true));
        return $eventos;
      } catch (Exception $e) {
        error_log("------ERROR START------");
        error_log("There was an error while trying to get all events");
        error_log($e->getMessage());
        error_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}


//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
function generateShortGUID() {
    return bin2hex(random_bytes(8)); // Generates a 16-character unique ID
}

?>
