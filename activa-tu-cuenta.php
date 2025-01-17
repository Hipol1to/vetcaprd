<?php 
require('includes/config.php');

//collect values from the url
$userId = trim($_GET['x']);
$active = trim($_GET['y']);

//if id is number and the active token is not empty carry on
if (!empty($userId) && !empty($active)) {

	//update users record set the active column to Yes where the memberID and active value match the ones provided in the array
    error_log("UPDATE usuarios SET activo = 1 WHERE Id = ".$userId." AND activo = 0");
	$stmt = $db->prepare("UPDATE usuarios SET activo = 1 WHERE Id = :id AND activo = 0");
	$stmt->execute(array(
		':id' => $userId
	));

	//if the row was updated redirect the user
	if ($stmt->rowCount() == 1){
		//redirect to login page
		header('Location: VetCapMembers/login.php?action=active');
		exit;

	} else {
        header('Location: unete-a-nosotros.php?action=failed');
		exit;
	}
	
}




require('layout/header.php'); 
       ?>
<section class="call-to-action-section">
  <div class="cta-content">
    <div class="image-container">
      <img src="./assets/img/registrate.png" alt="Animals" class="cta-image" />
    </div>
    <div class="text-container">
      <h1 style="color: #2d4a34;" class="cta-title">Unete a VetCap</h1>
      <p style="color: #2d4a34;" class="cta-quote">
        Unete a una comunidad apasionada por la veterinaria
      </p>
      <a href="unete-a-nosotros.php"><button style="color: white;" class="cta-button2">REGISTRARME</button></a>
    </div>
  </div>
</section>


<div id="lobo-promo" class="promo-bar">
  <div class="text-section">
    <div class="logo-info">LOBO CORPORATION | FUNDACIÓN VETCAP</div>
    <div class="collection-title">HIVE <a style="color:white;">& HOWL</a></div>
    <div class="collection-subtitle">COLLECTION</div>
  </div>
  <div class="image-section">
    <img src="./assets/img/vetcap_lobo.png" alt="Cap image">
  </div>
  <div class="hashtag-section">
    <h2>#VETCAPXLOBO</h2>
  </div>
  <div class="button-section">
    <button class="rounded-button">SHOP NOW</button>
  </div>
</div>
<?php 
//include header template
require('layout/footer.php'); 
?>