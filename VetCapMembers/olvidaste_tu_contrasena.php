<?php 
//include config
require_once('../includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }

//if form has been submitted process it
if (isset($_POST['submit'])){

	//Make sure all POSTS are declared
	if (! isset($_POST['email'])) {
		$error[] = "Por favor completa todos los campos";
	}


	//email validation
	if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Por favor ingresa una dirección de correo electrónico válida';
	} else {
		$stmt = $db->prepare('SELECT correo_electronico FROM usuarios WHERE correo_electronico = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($row['correo_electronico'])){
			$error[] = 'Dirección de correo electrónico incorrecta.';
		}

	}

	//if no errors have been created carry on
	if (! isset($error)){

		//create the activation code
		$token = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare("UPDATE usuarios SET token_reinicio = :token, reinicio_completo=0 WHERE correo_electronico = :email");
			$stmt->execute(array(
				':email' => $row['correo_electronico'],
				':token' => $token
			));

			//send email
			$to = $row['correo_electronico'];
			$subject = "Cambio de contraseña";
			$body = "<p>Recibimos una solicitud de cambio de contraseña.</p>
			<p>Si crees que fué un error, por favor ignora este correo.</p>
			<p>Para reiniciar tu contraseña haz click en el siguiente link: <a href='".DIR."/VetCapMembers/cambiar_contrasena.php?key=$token'>".DIR."/VetCapMembers/cambiar_contrasena.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->CharSet = 'UTF-8';
        	$mail->Encoding = 'base64';
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: login.php?action=reset');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

//define page title
$title = 'Reinciar contraseña';

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
			<form role="form" method="post" action="" autocomplete="off">
				<h2 style="color: #214e1f">Reiniciar contraseña</h2>
				<p><a href='login.php'>Volver a iniciar sesión</a></p>
				<hr>

				<?php
				//check for any errors
				if (isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if (isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Tu cuenta ha sido activada exitosamente, puedes iniciar sesión.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Se ha enviado un enlace de verificación, puedes encontrarlo en tu correo electrónico.</h2>";
							break;
					}
				}
				?>

				<div class="form-group">
                <label for="submit-button" class="btn-label">Introduce tu correo electrónico para cambiar tu contraseña</label>   
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Correo electrónico" value="" tabindex="1">
				</div>

				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input class="rounded-button" type="submit" name="submit" value="Enviar enlace" class="btn btn-primary btn-block btn-lg" tabindex="2"></div>
				</div>
			</form>
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
