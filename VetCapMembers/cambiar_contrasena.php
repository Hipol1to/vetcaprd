<?php require('../includes/config.php'); 

//if logged in redirect to members page
if ($user->is_logged_in() ){ 
	header('Location: index.php'); 
	exit(); 
}

$resetToken = $_GET['key'];

$stmt = $db->prepare('SELECT token_reinicio, reinicio_completo FROM usuarios WHERE token_reinicio = :token');
$stmt->execute(array(':token' => $resetToken));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//if no token from db then kill the page
if (empty($row['token_reinicio'])){
	$stop = 'Link invalido, asegurate que el link enviado a tu correo no ha expirado.';
} elseif($row['token_reinicio'] == 1) {
	//$stop = 'Your password has already been changed!';
}

//if form has been submitted process it
if (isset($_POST['submit'])){

	if (! isset($_POST['password']) || ! isset($_POST['passwordConfirm'])) {
		$error[] = 'Por favor confirma tu contraseña';
	}

	//basic validation
	if (strlen($_POST['password']) < 3){
		$error[] = 'Esta contraseña es muy corta.';
	}

	if (strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'La confirmacion de contraseña es muy corta.';
	}

	if ($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Las contraseñas no coinciden.';
	}

	//if no errors have been created carry on
	if (! isset($error)){

		//hash the password
		$hashedpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {

			$stmt = $db->prepare("UPDATE usuarios SET contrasena = :hashedpassword, reinicio_completo = 1  WHERE token_reinicio = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['token_reinicio']
			));

			//redirect to index page
			header('Location: login.php?action=resetAccount');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

//define page title
$title = 'Cambiar contraseña';

//include header template
require('layout/header.php'); 
?>
<div class="promo-bar">
        <div class="hashtag-section">
          <h2>LOBO CORPORATION | FUNDACIÓN VETCAP</h2>
        </div>
        <div class="text-section">
          <div class="collectionn-title">HIVE <a style="color:white;">& HOWL</a></div>
        </div>
        <div class="image-section">
          <img width="50px" src="../assets/img/icons/lobo-icon-white.png" alt="Cap image">
          <img width="50px" src="../assets/img/icons/bee-icon-white.png" alt="Cap image">
        </div>
        <div class="button-section">
          <button class="rounded-button">SHOP NOW</button>
        </div>
      </div>
      <br><br>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


	    	<?php if (isset($stop)){

	    		echo "<p class='bg-danger'>$stop</p>";

	    	} else { ?>

				<form role="form" method="post" action="" autocomplete="off">
					<h2 style="color: #214e1f">Cambia tu contraseña</h2>
					<hr>

					<?php
					//check for any errors
					if (isset($error)){
						foreach($error as $error){
							echo '<p class="bg-danger">'.$error.'</p>';
						}
					}

					if (isset($_GET['action'])) {

						//check the action
						switch ($_GET['action']) {
							case 'active':
								echo "<h2 class='bg-success'>Tu cuenta ha sido activada, puedes iniciar sesión.</h2>";
								break;
							case 'reset':
								echo "<h2 class='bg-success'>Se ha enviado un link de cambio de contraseña, revisa tu correo electrónico.</h2>";
								break;
						}
					}
					?>

					<p>Introduce y confirma tu contraseña para cambiarla.</p>

					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="1">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmar contraseña" tabindex="1">
							</div>
						</div>
					</div>
					
					<hr>
					<div class="row">
						<div class="col-xs-6 col-md-6"><input style="color: white" type="submit" name="submit" value="Cambiar contraseña" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
					</div>
				</form>

			<?php } ?>
		</div>
	</div>


</div>
<br><br>
<section class="vibix-banner-section">
  <div class="vibix-banner-container">
    <img src="../assets/img/color-logos/vibix-logo.png" alt="Vibix Logo" class="vibix-logo">
    <h2 class="vibix-title">Garantía de Inmunidad comprobada</h2>
    <div class="vibix-products">
      <img src="../assets/img/medicinas-vibix.png" alt="Vibix Products">
    </div>
    <div class="vibix-dog">
      <img src="../assets/img/perro.png" alt="Dog">
    </div>
    <div class="vibix-dog">
    <img src="../assets/img/3-years.png" alt="Virus Icon" class="vibix-virus">
    </div>
  </div>
</section>
<?php 
//include header template
require('layout/footer.php'); 
?>
