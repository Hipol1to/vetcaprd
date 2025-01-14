<?php 
require('includes/config.php');

//if logged in redirect to members page
if ($user->is_logged_in() ){ 
	header('Location: memberpage.php'); 
	//exit(); 
}

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (! isset($_POST['username'])) {
    	$error[] = "Please fill out all fields";
    }

    if (! isset($_POST['email'])) {
    	$error[] = "Please fill out all fields";
    }

    if (! isset($_POST['password'])) {
    	$error[] = "Please fill out all fields";
    }

	$username = $_POST['username'];

	//very basic validation
	if (! $user->isValidUsername($username)){
		$error[] = 'El usuario solo puede tener caracteres alfanumericos, entre 3-16 caracteres';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (! empty($row['username'])){
			$error[] = 'Este nombre de usuario ya esta en uso';
		}
	}

	if (strlen($_POST['password']) < 3){
		$error[] = 'La contraseña es muy corta';
	}

	if (strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirma tu contraseña';
	}

	if ($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Las contraseñas no coinciden';
	}

	//email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if (! filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Por favor, ingresa una direccion de correo electrónico valida';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (! empty($row['email'])){
			$error[] = 'Este correo electrónico ya está en uso';
		}
	}


	//if no errors have been created carry on
	if (!isset($error)){

		//hash the password
		$hashedpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $username,
				':password' => $hashedpassword,
				':email' => $email,
				':active' => $activasion
			));
			$id = $db->lastInsertId('memberID');

			//send email
			$to = $_POST['email'];
			$subject = "Activa tu cuenta";
			$body = "<p>Gracias por registrarte en Fundacion Vetcap.</p>
			<p>Para activar tu cuenta, por favor clica este enlace: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Atentamente, el equipo de Fundacion Vetcap</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

//define page title
$title = 'Usuarios VetCap';

//include header template
require('layout/header.php');
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style>
  .containerrr {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: linear-gradient(to left, #305454, #40546c, #305454) !important
  }

  .form-containerrr {
    max-width: 400px;
    width: 100%;
    padding: 20px;
    background-color: rgba(248, 249, 250, 0.8);
    border-radius: 10px;
  }

  .form-containerrr h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #2e5653 !important;
  }
</style>
<div class="containerrr">
  <div class="form-containerrr">
    <form role="form" method="post" action="" autocomplete="off">
      <h2 style="color: #2e5653 !important;">Registrate</h2>
      <p style="color: #2e5653 !important;">¿Ya eres miembro? <a href="login.php"><b style="color: #2e5653 !important;">Inicia Sesión</b> </a></p>
      <hr>

      <?php
      // Check for any errors
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<p style="color: white;" class="bg-danger">'.$error.'</p>';
        }
      }

      // If action is joined, show success message
      if (isset($_GET['action']) && $_GET['action'] == 'joined') {
        echo "<h2 class='bg-success'>Registro satisfactorio, revisa tu correo electronico para activar tu cuenta.</h2>";
      }
      ?>

      <div class="form-group">
        <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
      </div>
      <div class="form-group">
        <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Correo Electrónico" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="2">
      </div>
      <div class="form-group">
        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Contraseña" tabindex="3">
      </div>
      <div class="form-group">
        <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control form-control-lg" placeholder="Confirmar contraseña" tabindex="4">
      </div>

      <div class="form-group">
        <input style="color: white !important;" type="submit" name="submit" value="Registrate" class="btn btn-primary btn-block btn-lg" tabindex="5">
      </div>
    </form>
  </div>
</div>

<?php
//include header template
require('layout/footer.php');
?>
