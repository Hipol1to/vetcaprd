<?php
require('memberpage.php');
// Retrieve form data
$event_id = $_POST['event_id'];
$user_id = $_SESSION['memberID'];

// Perform the database update
$pdo = new PDO('mysql:host=localhost;dbname=daravey', 'root', '');
$stmt = $pdo->prepare('SELECT eventsRegistered FROM members WHERE memberID = ?');
$stmt->execute([$user_id]);
$existingData = $stmt->fetchColumn();

$datas = ($existingData !== false) ? json_decode($existingData, true) : array();
$datas['event'.$event_id.'id'] = $event_id;

// Prepare the update statement
$stmt = $pdo->prepare('UPDATE members SET eventsRegistered = ? WHERE memberID = ?');

// Convert the updated array back to JSON
$jsonString = json_encode($datas);

// Execute the update statement
$stmt->execute([$jsonString, $user_id]);

if ($stmt->rowCount() > 0) {
  $jsonString = json_encode($datas);

// Update the session variable
$_SESSION['eventsQueryResult'] = $jsonString;

// Execute the update statement
$stmt->execute([$jsonString, $user_id]);

// Redirect to memberpage.php
//echo "Successs";
header("Location: memberpage.php");
//exit();
} else {
  echo "Failed to insert the event.";
  echo htmlspecialchars($user_id, ENT_QUOTES);
  echo htmlspecialchars($existingData, ENT_QUOTES);
}
?>
