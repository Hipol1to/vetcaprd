<?php
require('includes/config.php');

//collect values from the url
$userId = trim($_GET['x']);
$active = trim($_GET['y']);

//if id is number and the active token is not empty carry on
if (is_numeric($userId) && !empty($active)) {

	//update users record set the active column to Yes where the memberID and active value match the ones provided in the array
	$stmt = $db->prepare("UPDATE usuarios SET activo = 1 WHERE Id = :id AND activo = 0");
	$stmt->execute(array(
		':id' => $userId,
		':activo' => $active
	));

	//if the row was updated redirect the user
	if ($stmt->rowCount() == 1){
		//redirect to login page
		header('Location: login.php?action=active');
		exit;

	} else {
		echo "Tu cuenta no pudo ser activada. Quizas este link ha expirado. Por favor, intentalo de nuevo"; 
	}
	
}
?>