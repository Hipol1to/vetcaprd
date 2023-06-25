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
unset($datas['event'.$event_id.'id']);

// Prepare the update statement
$stmt = $pdo->prepare('UPDATE members SET eventsRegistered = ? WHERE memberID = ?');

// Convert the updated array back to JSON
$jsonString = json_encode($datas);

// Execute the update statement
$stmt->execute([$jsonString, $user_id]);

if ($stmt->rowCount() > 0) {
  // Update the session variable
  $_SESSION['eventsQueryResult'] = $jsonString;

  // Redirect to memberpage.php
  header("Location: memberpage.php");
  exit();
} else {
  echo "Failed to unsubscribe from the event.";
}
?>
