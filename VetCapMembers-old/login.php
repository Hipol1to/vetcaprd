<?php
//include config
require_once('includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }

//process login form if submitted
if(isset($_POST['submit'])){

	if (! isset($_POST['username'])) {
		$error[] = "Por favor completa todos los campos";
	}

	if (! isset($_POST['password'])) {
		$error[] = "Por favor completa todos los campos";
	}

	$username = $_POST['username'];
	if ($user->isValidUsername($username)){
		if (! isset($_POST['password'])){
			$error[] = 'Debes introducir una contraseña';
		}

		$password = $_POST['password'];

		if ($user->login($username, $password)){
			$_SESSION['username'] = $username;
			header('Location: memberpage.php');
			exit;

		} else {
			$error[] = 'Credenciales incorrectas, asegurate de haber activado tu cuenta';
		}
	}else{
		$error[] = 'El usuario solo puede tener caracteres alfanumericos, entre 3-16 caracteres';
	}

}//end if submit

//define page title
$title = 'Iniciar Sesion';

//include header template
require('layout/header.php'); 
?>

	

<style>
  .containerrr {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: linear-gradient(to left, #305454, #40546c, #305454) !important;
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
      <h2 style="color: #2e5653 !important;">Iniciar Sesión</h2>
      <p style="color: #2e5653 !important;">¿Todavía no eres miembro? <a href="index.php"><b style="color: #2e5653 !important;">Regístrate</b> </a></p>
      <hr>

      <?php
      // Check for any errors
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<p style="color: white;" class="bg-danger">' . $error . '</p>';
        }
      }

      if (isset($_GET['action'])) {
        // Check the action
        switch ($_GET['action']) {
          case 'active':
            echo "<h2 class='bg-success'>Tu cuenta ha sido activada. Puedes iniciar sesión.</h2>";
            break;
          case 'reset':
            echo "<h2 class='bg-success'>Se ha enviado a tu correo un link de reinicio de contraseña.</h2>";
            break;
          case 'resetAccount':
            echo "<h2 class='bg-success'>Contraseña cambiada correctamente. Puedes iniciar sesion.</h2>";
            break;
        }
      }
      ?>

      <div class="form-group">
        <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
      </div>

      <div class="form-group">
        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="3">
      </div>

      <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9">
          <a href="reset.php">¿Olvidaste tu contraseña?</a>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-xs-6 col-md-6">
          <input type="submit" name="submit" value="Iniciar sesión" class="btn btn-primary btn-block btn-lg" tabindex="5">
        </div>
      </div>
    </form>
  </div>
</div>



<?php 
//include header template
require('layout/footer.php'); 
?>
