<?php
require('includes/config.php');

//if logged in redirect to members page
if ($user->is_logged_in() ){ 
	header('Location: '.DIR.'/VetCapMembers/index.php'); 
	//exit(); 
}
error_log("no envie el submit");
if(isset($_POST['submit'])){
  error_log("envie el submit");
if (! isset($_POST['usuario'])) {
  $error[] = "Debes completar todos los campos";
}

if (! isset($_POST['correo_electronico'])) {
  $error[] = "Debes completar todos los campos";
}

if (! isset($_POST['contrasena'])) {
  $error[] = "Debes completar todos los campos";
}

$username = $_POST['usuario'];
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo_electronico = $_POST['correo_electronico'];
$telefono = $_POST['telefono'];
$tipo_visitante = $_POST['tipo_visitante'];
$tipo_estudiante = $_POST['tipo_estudiante'];
$universidad = $_POST['universidad'];
$contrasena = $_POST['contrasena'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

//very basic validation
if (! $user->isValidUsername($username)){
$error[] = 'El usuario solo puede tener caracteres alfanumericos, entre 3-16 caracteres';
} else {
$stmt = $db->prepare('SELECT usuario FROM `usuarios` WHERE usuario = :username');
$stmt->execute(array(':username' => $username));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (! empty($row['usuario'])){
  $error[] = 'Este nombre de usuario ya esta en uso';
}
}

if (strlen($_POST['contrasena']) < 3){
$error[] = 'La contrasena es muy corta';
}

if (strlen($_POST['confirmacioncontrasena']) < 3){
$error[] = 'Confirma tu contrasena';
}

if ($_POST['contrasena'] != $_POST['confirmacioncontrasena']){
$error[] = 'Las contrasenas no coinciden';
}

//email validation
$email = htmlspecialchars_decode($_POST['correo_electronico'], ENT_QUOTES);
if (! filter_var($email, FILTER_VALIDATE_EMAIL)){
  $error[] = 'Por favor, ingresa una direccion de correo electrónico valida';
} else {
$stmt = $db->prepare('SELECT usuario FROM `usuarios` WHERE correo_electronico = :email');
$stmt->execute(array(':email' => $email));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (! empty($row['correo_electronico'])){
  $error[] = 'Este correo electrónico ya está en uso';
}
}


//if no errors have been created carry on
if (!isset($error)){

//hash the password
$hashedpassword = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

//create the activasion code
$activasion = md5(uniqid(rand(),true));

try {
  $id = generateShortGUID();
error_log('INSERT INTO usuarios (Id, nombre, apellido, telefono, correo_electronico, usuario, contrasena, fecha_nacimiento, tipo_visitante, tipo_estudiante, universidad, rol, activo, token_activacion) VALUES (:'.$id.', :'.$nombre.', :'.$apellido.', :'.$telefono.', :'.$correo_electronico.', :'.$usuario.', :'.$contrasena.', :'.$fecha_nacimiento.', :'.$tipo_visitante.', :'.$tipo_estudiante.', :'.$universidad.', :cliente, :0, :'.$activasion.')');
  //insert into database with a prepared statement

  $stmt = $db->prepare('INSERT INTO usuarios (Id, nombre, apellido, telefono, correo_electronico, usuario, contrasena, fecha_nacimiento, tipo_visitante, tipo_estudiante, universidad, rol, activo, token_activacion) VALUES (:id, :nombre, :apellido, :telefono, :correo_electronico, :usuario, :contrasena, :fecha_nacimiento, :tipo_visitante, :tipo_estudiante, :universidad, :rol, :activo, :token_activacion)');
  $stmt->execute(array(
    ':id' => $id,
    ':nombre' => $nombre,
    ':apellido' => $apellido,
    ':telefono' => $telefono,
    ':correo_electronico' => $correo_electronico,
    ':usuario' => $username,
    ':contrasena' => $hashedpassword,
    ':fecha_nacimiento' => $fecha_nacimiento,
    ':tipo_visitante' => $tipo_visitante,
    ':tipo_estudiante' => $tipo_estudiante,
    ':universidad' => $universidad,
    ':rol' => 'cliente',
    ':activo' => 0,
    ':token_activacion' => $activasion
  ));
  

  //send email
  $to = $_POST['correo_electronico'];
  $subject = "Activa tu cuenta";
  $body = "<p>Gracias por registrarte en Fundacion Vetcap.</p>
  <p>Para activar tu cuenta, por favor clica este enlace: <a href='".DIR."activa-tu-cuenta.php?x=$id&y=$activasion'>".DIR."activa-tu-cuenta.php?x=$id&y=$activasion</a></p>
  <p>Atentamente, el equipo de Fundacion Vetcap</p>";

  $mail = new Mail();
  $mail->setFrom(SITEEMAIL);
  $mail->addAddress($to);
  $mail->subject($subject);
  $mail->body($body);
  $mail->send();

  //redirect to index page
  header('Location: login.php?action=joined');
  exit;

//else catch the exception and show the error.
} catch(PDOException $e) {
    $error[] = $e->getMessage();
    error_log($e->getMessage());
}
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
      <a href="#lobo-promo"><button style="color: white;" class="cta-button2">REGISTRARME</button></a>
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


<section  class="call-to-action-section">
  <div class="cta-content">
    <div class="text-container">
      <h1  style="color: #2d4a34;" class="cta-title">Regístrate en VetCap</h1>
      <form role="form" autocomplete="off" action="" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
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
          case 'failed':
            echo "<h2 class='bg-danger'>Tu cuenta no pudo ser activada. Quizas este link ha expirado. Por favor, intentalo de nuevo.</h2>";
            break;
        }
      }
      ?>  
      <!-- Nombre -->
        <label style="color: #2d4a34;">
          Nombre:
          <input type="text" name="nombre" placeholder="Ingrese su nombre" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Apellido -->
        <label style="color: #2d4a34;">
          Apellido:
          <input type="text" name="apellido" placeholder="Ingrese su apellido" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Correo Electrónico -->
        <label style="color: #2d4a34;">
          Correo Electrónico:
          <input type="email" name="correo_electronico" placeholder="Ingrese su correo electrónico" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Teléfono -->
        <label style="color: #2d4a34;">
          Teléfono:
          <input type="number" name="telefono" placeholder="Ingrese su número de teléfono" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Motivación -->
        <label style="color: #2d4a34;">
          ¿Qué te motiva a unirte a VetCap?
          <select name="tipo_visitante" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Estudiante veterinario">Soy estudiante veterinario</option>
            <option value="Visitante">Solo estoy de visita</option>
            <option value="Veterinario profesional">Soy veterinario profesional</option>
          </select>
        </label>

        <!-- Etapa de Estudios -->
        <label style="color: #2d4a34;">
          ¿En qué etapa de tus estudios estás?
          <select name="tipo_estudiante" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Estudiante de inicio">He comenzado hace poco</option>
            <option value="Estudiante a mediados de carrea">Estoy a mediados de carrera</option>
            <option value="Estudiante de termino">Soy estudiante de término</option>
          </select>
        </label>

        <!-- Universidad -->
        <label style="color: #2d4a34;">
          ¿En qué universidad estudias?
          <select name="universidad" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una universidad</option>
            <option value="ucateci">Universidad Católica del Cibao</option>
            <option value="unapec">Universidad APEC</option>
            <option value="uasd">Universidad Autónoma de Santo Domingo</option>
            <!-- Add all other universities here -->
          </select>
        </label>

        <!-- Fecha de Nacimiento -->
        <label style="color: #2d4a34;">
          Fecha de Nacimiento:
          <input type="date" name="fecha_nacimiento" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Usuario -->
        <label style="color: #2d4a34;">
          Usuario:
          <input type="text" name="usuario" placeholder="Ingrese su usuario" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- contrasena -->
        <label style="color: #2d4a34;">
          contrasena:
          <input type="password" name="contrasena" placeholder="Ingrese su contrasena" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Confirmar contrasena -->
        <label style="color: #2d4a34;">
          Confirmar contrasena:
          <input type="password" name="confirmacioncontrasena" placeholder="Confirme su contrasena" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Botón -->
        <button type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
          REGISTRARME
        </button>
      </form>
    </div>
  </div>
</section>


<?php 
//include header template
require('layout/footer.php'); 
?>