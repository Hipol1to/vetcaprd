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


//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
function generateShortGUID() {
    return bin2hex(random_bytes(8)); // Generates a 16-character unique ID
}

?>
