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
$tipo_estudiante = isset($_POST['tipo_estudiante'])? $_POST['tipo_estudiante'] : 'No estudiante';
$universidad = isset($_POST['universidad'])? $_POST['universidad'] : 'No universidad';
$contrasena = $_POST['contrasena'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

//very basic validation
if (! $user->isValidUsername($username)){
$error[] = 'El usuario solo puede tener caracteres alfanumericos, entre 3-16 caracteres';
} else {
$stmt = $db->prepare('SELECT usuario FROM `usuarios` WHERE usuario = :username AND correo_electronico = :email');
$stmt->execute(array(':username' => $username,
                     ':email' => $correo_electronico));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (! empty($row['usuario'])){
  $error[] = 'Este nombre de usuario o correo electrónico ya esta en uso';
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
  header('Location: VetCapMembers/login.php?action=joined');
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
       <style>
    /* Correctly hides elements */
    .hidden {
      display: none;
    }
  </style>
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
          <select id="tipo_visitante" name="tipo_visitante" onchange="toggleRegisterFields()" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Estudiante veterinario">Soy estudiante veterinario</option>
            <option value="Visitante">Solo estoy de visita</option>
            <option value="Veterinario profesional">Soy veterinario profesional</option>
          </select>
        </label>

        <!-- Etapa de Estudios -->
        <div id="estudiosFieldContainer" class="hidden">
        <label style="color: #2d4a34;">
          ¿En qué etapa de tus estudios estás?
          <select id="tipo_estudiante" name="tipo_estudiante" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Estudiante de inicio">He comenzado hace poco</option>
            <option value="Estudiante a mediados de carrea">Estoy a mediados de carrera</option>
            <option value="Estudiante de termino">Soy estudiante de término</option>
          </select>
        </label>
        </div>

        <!-- Universidad -->
         <div id="universidadFieldContainer" class="hidden">
        <label style="color: #2d4a34;">
          ¿En qué universidad estudias?
          <select id="universidad" name="universidad" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <option value="" disabled selected>Selecciona una universidad</option>
    <option value="Puerto Plata Business School">Puerto Plata Business School</option>
    <option value="Universidad Autónoma de Santo Domingo">Universidad Autónoma de Santo Domingo</option>
    <option value="Universidad Católica del Cibao">Universidad Católica del Cibao</option>
    <option value="Pontificia Universidad Católica Madre y Maestra">Pontificia Universidad Católica Madre y Maestra</option>
    <option value="Universidad Católica Nordestana">Universidad Católica Nordestana</option>
    <option value="Universidad Nacional Pedro Henríquez Ureña">Universidad Nacional Pedro Henríquez Ureña</option>
    <option value="Universidad Acción Pro-Educación y Cultura">Universidad Acción Pro-Educación y Cultura</option>
    <option value="Universidad Central del Este">Universidad Central del Este</option>
    <option value="Instituto Tecnológico de Santo Domingo">Instituto Tecnológico de Santo Domingo</option>
    <option value="Universidad INCE">Universidad INCE</option>
    <option value="Universidad Tecnológica de Santiago">Universidad Tecnológica de Santiago</option>
    <option value="Universidad Dominicana Organización y Método">Universidad Dominicana Organización y Método</option>
    <option value="Universidad Iberoamericana">Universidad Iberoamericana</option>
    <option value="Universidad Adventista Dominicana">Universidad Adventista Dominicana</option>
    <option value="Universidad Interamericana">Universidad Interamericana</option>
    <option value="Instituto Tecnológico del Cibao Oriental">Instituto Tecnológico del Cibao Oriental</option>
    <option value="Universidad Tecnológica del Sur">Universidad Tecnológica del Sur</option>
    <option value="Universidad Católica Santo Domingo">Universidad Católica Santo Domingo</option>
    <option value="Universidad Eugenio María de Hostos">Universidad Eugenio María de Hostos</option>
    <option value="Universidad Central Dominicana de Estudios Profesionales">Universidad Central Dominicana de Estudios Profesionales</option>
    <option value="Universidad Odontológica Dominicana">Universidad Odontológica Dominicana</option>
    <option value="Facultad Latinoamericana de Ciencias Sociales">Facultad Latinoamericana de Ciencias Sociales</option>
    <option value="Universidad Nacional Evangélica">Universidad Nacional Evangélica</option>
    <option value="Universidad ISA">Universidad ISA</option>
    <option value="Universidad Cultural Dominico Americana">Universidad Cultural Dominico Americana</option>
    <option value="Universidad Federico Henríquez y Carvajal">Universidad Federico Henríquez y Carvajal</option>
    <option value="Universidad de la Tercera Edad">Universidad de la Tercera Edad</option>
    <option value="Universidad Abierta para Adultos">Universidad Abierta para Adultos</option>
    <option value="Universidad Católica Tecnológica de Barahona">Universidad Católica Tecnológica de Barahona</option>
    <option value="Universidad del Caribe">Universidad del Caribe</option>
    <option value="Universidad Experimental Félix Adam">Universidad Experimental Félix Adam</option>
    <option value="Universidad Agroforestal Fernando Arturo de Meriño">Universidad Agroforestal Fernando Arturo de Meriño</option>
    <option value="Universidad Psicología Industrial Dominicana">Universidad Psicología Industrial Dominicana</option>
    <option value="Instituto Tecnológico Mercy Jácquez">Instituto Tecnológico Mercy Jácquez</option>
    <option value="Instituto Técnico Superior Oscus San Valero">Instituto Técnico Superior Oscus San Valero</option>
    <option value="Universidad Nacional Tecnológica">Universidad Nacional Tecnológica</option>
    <option value="Instituto Cristiano de Estudios Superiores Especializados">Instituto Cristiano de Estudios Superiores Especializados</option>
    <option value="Academia de Diseño de Santo Domingo">Academia de Diseño de Santo Domingo</option>
    <option value="Instituto Superior de Tecnología Universal">Instituto Superior de Tecnología Universal</option>
    <option value="Barna Escuela de Negocios">Barna Escuela de Negocios</option>
    <option value="Universidad Católica del Este">Universidad Católica del Este</option>
    <option value="Instituto Global de Altos Estudios en Ciencias Sociales">Instituto Global de Altos Estudios en Ciencias Sociales</option>
    <option value="Instituto Especializado de Estudios Superiores de la Policía Nacional">Instituto Especializado de Estudios Superiores de la Policía Nacional</option>
    <option value="Instituto De Servicios Psicosociales y Educativos">Instituto De Servicios Psicosociales y Educativos</option>
    <option value="Instituto Superior de Formación Docente Salomé Ureña">Instituto Superior de Formación Docente Salomé Ureña</option>
    <option value="Instituto Superior de Estudios Especializados en Ciencias Sociales y Humanidades Luis Heredia Bonetti">Instituto Superior de Estudios Especializados en Ciencias Sociales y Humanidades Luis Heredia Bonetti</option>
    <option value="Instituto Superior Para la Defensa">Instituto Superior Para la Defensa</option>
    <option value="Instituto Stevens de Tecnología Internacional">Instituto Stevens de Tecnología Internacional</option>
    <option value="Instituto Tecnológico de las Américas">Instituto Tecnológico de las Américas</option>
    <option value="Instituto Especializado de Estudios Superiores Loyola">Instituto Especializado de Estudios Superiores Loyola</option>
    <option value="Academia Superior de Ciencias Aeronáuticas">Academia Superior de Ciencias Aeronáuticas</option>
</select>

        </label>
        </div>

        <!-- Fecha de Nacimiento -->
        <label style="color: #2d4a34;">
          Fecha de Nacimiento:
          <input type="date" name="fecha_nacimiento" required 
       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" 
       onclick="this.showPicker()">
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

<script>
  function toggleRegisterFields() {
    let tipoVisitanteField = document.getElementById("tipo_visitante"); 
    let optionSelected = tipoVisitanteField.value;
    let careerStageContainer = document.getElementById("estudiosFieldContainer");
    let universityContainer = document.getElementById("universidadFieldContainer");
    let careerStageField = document.getElementById("tipo_estudiante");
    let universityField = document.getElementById("universidad");

    if (optionSelected === "Estudiante veterinario") {
      console.log("sor");
      
      if (careerStageContainer.classList.contains("hidden")) {
        console.log("tajiden");
        careerStageContainer.classList.remove("hidden");
        careerStageField.required = true;
      }
      if (universityContainer.classList.contains("hidden")) {
        universityContainer.classList.remove("hidden");
        universityField.required = true;
      }
    } else {
      console.log("nosor");
      if (!careerStageContainer.classList.contains("hidden")) {
        console.log("notajiden");
        careerStageContainer.classList.add("hidden");
        careerStageField.required = false;
      }
      if (!universityContainer.classList.contains("hidden")) {
        universityContainer.classList.add("hidden");
        universityField.required = false;
      }
    }
  }
</script>

<?php 
//include header template
require('layout/footer.php'); 
?>