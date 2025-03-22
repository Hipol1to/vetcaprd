<?php
ob_start();
session_start();
//set timezone
date_default_timezone_set('Europe/London');

//database credentials
define('DBHOST','localhost');
define('DBUSER','u881757960_vetcap_adm');
define('DBPASS','!!zU7543Mjk!!');
define('DBNAME','u881757960_vetcap_storage');
define('ENCRYPTION_KEY', base64_decode('G9S/vWXp8aNCL2NRQFQ/oHjdJJ3kbsT/mLxukjMMN8Q='));
define('ENCRYPTION_IV', '5938506185430479'); // Must be 16 bytes for AES-256-CBC


//application address
define('DIR','https://www.vetcaprd.com//');
define('PAGE','https://www.vetcaprd.com//');
define('SITEEMAIL','info@vetcaprd.com');
$log_file = __DIR__ . '/custom_log.log'; // Define log file path

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}
// Function to write logs
function write_log($message) {
  global $log_file;
  $date = date('Y-m-d H:i:s'); // Timestamp
  file_put_contents($log_file, "[$date] $message" . PHP_EOL, FILE_APPEND);
}
function encryptValue($value) {
    $key = ENCRYPTION_KEY;  // 256-bit key
    $iv = ENCRYPTION_IV;    // 16-byte initialization vector

    // Encrypt the value
    $encrypted = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);

    // Encode the encrypted value in base64 to pass it safely
    return base64_encode($encrypted);
}

function decryptValue($encryptedValue) {
    $key = ENCRYPTION_KEY;
    $iv = ENCRYPTION_IV;

    // Decode the base64 value
    $decoded = base64_decode($encryptedValue);

    // Decrypt and return the original value
    return openssl_decrypt($decoded, 'aes-256-cbc', $key, 0, $iv);
}

function getAllEvents($dbContext) {
    try {
        $query = $dbContext->prepare("SELECT * FROM `eventos` WHERE activo = 1 ORDER BY fecha_evento ASC");
        $query->execute();
        // Fetch only the first row
        $_SESSION['nextEvent'] = $query->fetch(PDO::FETCH_ASSOC);
        $eventos = $query->fetchAll(PDO::FETCH_ASSOC);
        write_log("------STARTING SESSION LOG------");
        write_log(print_r($_SESSION['nextEvent'], true));
        return $eventos;
      } catch (Exception $e) {
        write_log("------ERROR START------");
        write_log("There was an error while trying to get all events");
        write_log($e->getMessage());
        write_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getUserEvents($dbContext) {
    try {
        $myEventsQuery = $dbContext->prepare("SELECT * FROM eventos LEFT JOIN usuario_eventos ON eventos.Id = usuario_eventos.evento_id WHERE usuario_eventos.usuario_id = :userId AND activo = 1");
        $myEventsQuery->bindParam(':userId', $_SESSION['memberID']);
        $myEventsQuery->execute();
        $misEventos = $myEventsQuery->fetchAll(PDO::FETCH_ASSOC);
        return $misEventos;
      } catch (Exception $e) {
        write_log("------ERROR START------");
        write_log("There was an error while trying to get user events");
        write_log($e->getMessage());
        write_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getUserPendingEvents($dbContext) {
    try {
        $myPendingEventsQuery = $dbContext->prepare("SELECT DISTINCT eventos.* FROM eventos LEFT JOIN pagos ON eventos.Id = pagos.evento_id WHERE pagos.usuario_id = :userId AND pagos.pago_validado = 0 AND activo = 1");
        $myPendingEventsQuery->bindParam(':userId', $_SESSION['memberID']);
        $myPendingEventsQuery->execute();
        $misPendingEventos = $myPendingEventsQuery->fetchAll(PDO::FETCH_ASSOC);
        write_log("User events pending for verification:" . print_r($misPendingEventos, true));
        return $misPendingEventos;
      } catch (Exception $e) {
        write_log("------ERROR START------");
        write_log("There was an error while trying to get user pending events");
        write_log($e->getMessage());
        write_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getAllCourses($dbContext) {
    try {
        $query = $dbContext->prepare("SELECT * FROM `diplomados` WHERE activo = 1 ORDER BY fecha_inicio_diplomado ASC");
        $query->execute();
        $diplomados = $query->fetchAll(PDO::FETCH_ASSOC);
        write_log("------STARTING SESSION LOG------");
        return $diplomados;
      } catch (Exception $e) {
        write_log("------ERROR START------");
        write_log("There was an error while trying to get all the courses");
        write_log($e->getMessage());
        write_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getUserCourses($dbContext) {
    try {
        $myCoursesQuery = $dbContext->prepare("SELECT * FROM diplomados LEFT JOIN usuario_diplomados ON diplomados.Id = usuario_diplomados.diplomado_id WHERE usuario_diplomados.usuario_id = :userId AND activo = 1");
        $myCoursesQuery->bindParam(':userId', $_SESSION['memberID']);
        $myCoursesQuery->execute();
        $misDiplomados = $myCoursesQuery->fetchAll(PDO::FETCH_ASSOC);
        return $misDiplomados;
      } catch (Exception $e) {
        write_log("------ERROR START------");
        write_log("There was an error while trying to get user courses");
        write_log($e->getMessage());
        write_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function getUserPendingCourses($dbContext) {
    try {
        $myPendingCoursesQuery = $dbContext->prepare("SELECT DISTINCT diplomados.* FROM diplomados LEFT JOIN pagos ON diplomados.Id = pagos.diplomado_id WHERE pagos.usuario_id = :userId AND pagos.pago_validado = 0 AND activo = 1");
        $myPendingCoursesQuery->bindParam(':userId', $_SESSION['memberID']);
        $myPendingCoursesQuery->execute();
        $misPendingCourses = $myPendingCoursesQuery->fetchAll(PDO::FETCH_ASSOC);
        write_log("User courses pending for verification:" . print_r($misPendingCourses, true));
        return $misPendingCourses;
      } catch (Exception $e) {
        write_log("------ERROR START------");
        write_log("There was an error while trying to get user pending courses");
        write_log($e->getMessage());
        write_log("------ERROR END------");
        die("Error fetching data: " . $e->getMessage());
        return null;
      }
}

function renderDiplomadosSlider($diplomadosArray, $misPendingDiplomados, $misDiplomados, $theUser) {
    $diplomadosSliderContainerHeader = '
    <div class="slider-capacitaciones-container">
   <div class="slider-capacitaciones">
    ';
    echo $diplomadosSliderContainerHeader;
    foreach ($diplomadosArray as $theDiplomado) {
        $eventosList = $_SESSION['eventosListForPayment'];
        array_push($eventosList, [$theDiplomado['Id'], 0]);
        $_SESSION['eventosListForPayment'] = $eventosList;
        $onclick = getOnclickForDiplomados($misDiplomados, $theDiplomado, $misPendingDiplomados);
        $diplomadoSlide = '
<div class="slide">
    <div class="diplomado-container">
            <div class="image-box">
                <div class="image-placeholder">
                    <img style="width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the whole area */" src="https://www.vetcaprd.com/'.str_replace("../", "", $theDiplomado['foto_diplomado']).'" alt="Foto capacitación" class="hero-image">
                    <span class="month">MARZO</span>
                </div>
                <div class="disvi">
                    <button class="rounded-button marginnnn er-bustonn" onclick="'.$onclick.'" style="margin-top: 20px;">INSCRIBIRME</button>
                </div>
            </div>

            <div class="info-box">
               <h2 class="course-title">'.$theDiplomado['nombre'].'</h2>
               <p class="mode"><span>Modalidad: </span>'.$theDiplomado['modalidad'].'</p>
               <p class="duration">
                  <span>Duración</span>
                  <br />
                  Inicio: '.$theDiplomado['fecha_inicio_diplomado'].'
                  <br />
                  Fin: '.$theDiplomado['fecha_fin_diplomado'].'
               </p>
               <p class="price">RD$'.$theDiplomado['precio_inscripcion'].'</p>
               <p class="contact">
                  Para más información, contáctanos al
                  <br />
                  <strong>(809) 344-5048</strong>
               </p>
            </div>
            <div id="countdown-'.$theDiplomado['Id'].'" class="countdown">
               <div class="time-unit">
                  <span class="number" id="days-'.$theDiplomado['Id'].'">00</span>
                  <span class="label">DÍAS</span>
               </div>
               <div class="time-unit">
                  <span class="number" id="hours-'.$theDiplomado['Id'].'">00</span>
                  <span class="label">HRS</span>
               </div>
               <div class="time-unit">
                  <span class="number" id="minutes-'.$theDiplomado['Id'].'">00</span>
                  <span class="label">MINS</span>
               </div>
               <div class="time-unit">
                  <span class="number" id="seconds-'.$theDiplomado['Id'].'">00</span>
                  <span class="label">SEGS</span>
               </div>
            </div>
         </div>
</div>
<script>
  let diplomadoId_'.str_replace("-", "_", $theDiplomado['Id']).' = "'.$theDiplomado['Id'].'";
  let eventTimestamp_'.str_replace("-", "_", $theDiplomado['Id']).' = "'.$theDiplomado['fecha_cierre_inscripcion'].'";
  // Update every second
  console.log(diplomadoId_'.str_replace("-", "_", $theDiplomado['Id']).');
  console.log(eventTimestamp_'.str_replace("-", "_", $theDiplomado['Id']).');
  
  const timerInterval_'.str_replace("-", "_", $theDiplomado['Id']).' = setInterval(() => updateCountdown(diplomadoId_'.str_replace("-", "_", $theDiplomado['Id']).', eventTimestamp_'.str_replace("-", "_", $theDiplomado['Id']).'), 1000);
updateCountdown(diplomadoId_'.str_replace("-", "_", $theDiplomado['Id']).', eventTimestamp_'.str_replace("-", "_", $theDiplomado['Id']).');
</script>
    ';
    echo $diplomadoSlide;
    }
    $diplomadosSliderContainerFooter = '
    </div>
   <button class="slider-capacitaciones-btn prev-btn">&lt;</button>
   <button class="slider-capacitaciones-btn next-btn">&gt;</button>
</div>
    ';
    echo $diplomadosSliderContainerFooter;

    foreach ($diplomadosArray as $theDiplomado) {
        renderCoursePaymentModal($theDiplomado, $theUser);
    }
}

function renderDiplomadosSliderWithoutPayments($diplomadosArray) {
  $diplomadosSliderContainerHeader = '
  <div class="slider-capacitaciones-container">
 <div class="slider-capacitaciones">
  ';
  echo $diplomadosSliderContainerHeader;
  $onclick = 'onclick="location.href=\''.DIR.'VetCapMembers/login.php\'" type="button"';
  foreach ($diplomadosArray as $theDiplomado) {
      $diplomadoSlide = '
<div class="slide">
  <div class="diplomado-container">
          <div class="image-box">
             <div class="image-placeholder">
                <span class="month">MARZO</span>
             </div>
             <div class="disvi"><button class="rounded-button marginnnn er-bustonn" '.$onclick.' style="margin-top: 20px; ">INSCRIBIRME</button></div>
          </div>
          <div class="info-box">
             <h2 class="course-title">'.$theDiplomado['nombre'].'</h2>
             <p class="mode"><span>Modalidad: </span>'.$theDiplomado['modalidad'].'</p>
             <p class="duration">
                <span>Duración</span>
                <br />
                Inicio: '.$theDiplomado['fecha_inicio_diplomado'].'
                <br />
                Fin: '.$theDiplomado['fecha_fin_diplomado'].'
             </p>
             <p class="price">RD$'.$theDiplomado['precio_inscripcion'].'</p>
             <p class="contact">
                Para más información, contáctanos al
                <br />
                <strong>(809) 344-5048</strong>
             </p>
          </div>
          <div id="countdown-'.$theDiplomado['Id'].'" class="countdown">
             <div class="time-unit">
                <span class="number" id="days-'.$theDiplomado['Id'].'">00</span>
                <span class="label">DÍAS</span>
             </div>
             <div class="time-unit">
                <span class="number" id="hours-'.$theDiplomado['Id'].'">00</span>
                <span class="label">HRS</span>
             </div>
             <div class="time-unit">
                <span class="number" id="minutes-'.$theDiplomado['Id'].'">00</span>
                <span class="label">MINS</span>
             </div>
             <div class="time-unit">
                <span class="number" id="seconds-'.$theDiplomado['Id'].'">00</span>
                <span class="label">SEGS</span>
             </div>
          </div>
       </div>
</div>
<script>
let diplomadoId_'.$theDiplomado['Id'].' = "'.$theDiplomado['Id'].'";
let eventTimestamp_'.$theDiplomado['Id'].' = "'.$theDiplomado['fecha_cierre_inscripcion'].'";
// Update every second
console.log(diplomadoId_'.$theDiplomado['Id'].');
console.log(eventTimestamp_'.$theDiplomado['Id'].');

const timerInterval_'.$theDiplomado['Id'].' = setInterval(() => updateCountdown(diplomadoId_'.$theDiplomado['Id'].', eventTimestamp_'.$theDiplomado['Id'].'), 1000);
updateCountdown(diplomadoId_'.$theDiplomado['Id'].', eventTimestamp_'.$theDiplomado['Id'].');
</script>
  ';
  echo $diplomadoSlide;
  }
  $diplomadosSliderContainerFooter = '
  </div>
 <button class="slider-capacitaciones-btn prev-btn">&lt;</button>
 <button class="slider-capacitaciones-btn next-btn">&gt;</button>
</div>
  ';
  echo $diplomadosSliderContainerFooter;

  /*foreach ($diplomadosArray as $theDiplomado) {
      renderCoursePaymentModal($theDiplomado);
  }*/
}

function getOnclickForDiplomados($misDiplomados, $currentDiplomado, $misPendingDiplomados) {
    $isAttributeWritten = false;
    $onClick = ''; // Initialize $onClick to avoid undefined variable issues
    write_log("aaaaaaaaaaaaaaa");

    foreach ($misDiplomados as $possibleDiplomado) {
        write_log($possibleDiplomado['Id']);
        write_log($currentDiplomado['Id']);
        if ($possibleDiplomado['Id'] == $currentDiplomado['Id']) {
            $onClick = 'alert(\'Ya estás inscrito a este curso.\')';
            $isAttributeWritten = true;
        }
    }

    foreach ($misPendingDiplomados as $possiblePendingDiplomado) {
      write_log($possiblePendingDiplomado['Id']);
      if ($possiblePendingDiplomado['Id'] == $currentDiplomado['Id']) {
          $onClick = 'alert(\'Ya solicitaste inscribirte a este curso, estamos revisando tu solicitud.\')';
          $isAttributeWritten = true;
      }
  }
  if (!$isAttributeWritten && $currentDiplomado['precio_inscripcion'] == 0.00) {
    $onClick = 'registerUserToFreeCourse(\'' . $currentDiplomado['Id'] . '\')';
    $isAttributeWritten = true;
  }

    // Fallback if $onClick is not set in the loop
    if (!$isAttributeWritten) {
      $onClick = 'openSubscribeModal(\'' . $currentDiplomado['Id'] . '\')';
    }
    return $onClick;
}

function renderCoursePaymentModal($currentDiplomado, $theUser) {
    $diplomadosModalHeader = '
    <div id="subscribe-events-modal'.$currentDiplomado['Id'].'" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
      <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative; display: flex; flex-direction: column; align-items: center; text-align: center;">
        <span 
          onclick="closeSubscribeModal(\''.$currentDiplomado['Id'].'\')" 
          style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #555;">
          &times;
        </span>';
    
    $completeProffileContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Completa tu perfil</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
      <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Debes completar tu perfil antes de inscribirte en este curso, envía tu cedula de identidad o la de tu tutor legal.
          </p>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Podrás inscribirte al evento una vez envies tu documento de identidad.
          </p>
          <br>
        <form role="form" autocomplete="off" action="complete_proffile.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;" enctype="multipart/form-data">
          <div class="form-group">
            <label for="cedula">Número de Cédula:</label>
            <input 
                type="text" 
                class="form-control" 
                id="cedula" 
                name="cedula_numero" 
                maxlength="11" 
                inputmode="numeric" 
                required 
                placeholder="Ingresa tu cédula"
            />
            <script>
                // Enforce numeric input only
                const cedulaInput = document.getElementById(\'cedula\');
                cedulaInput.addEventListener(\'input\', () => {
                    // Remove all non-numeric characters
                    cedulaInput.value = cedulaInput.value.replace(/\D/g, \'\');
                });
            </script>
          </div>
          <!-- Captura Frontal de Cédula -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Captura frontal de cédula (imagen):
            <input type="file" name="captura_frontal_cedula" accept="application/image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>

          <!-- Captura Trasera de Cédula -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Captura trasera de cédula (imagen):
            <input type="file" name="captura_trasera_cedula" accept="application/image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>
          <br>
          <!-- Botón -->
          <button type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
            SUBIR DOCUMENTOS
          </button>
        </form>
      </div>
    </div>';
    $proffileUnderInspection = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Tu perfil esta siendo revisado</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
      <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Estamos revisando tus documentos de identidad, podrás registrarte a eventos cuando confirmemos la veracidad de los mismos.
          </p>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Recibirás un mensaje de correo electrónico una vez que concluya el proceso.
          </p>
          <br>     
      </div>
    </div>';
    $cedulaInvalid = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Documento de identidad inválido</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
      <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            No pudimos verificar la veracidad de tus documentos, por favor comunícate con nosotros.
          </p>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Nos pondremos en contacto tan pronto sea posible.
          </p>
          <br>     

          <div class="u-form u-radius-20 u-white u-form-1">
          <form action="https://api.web3forms.com/submit" class="u-clearfix u-form-spacing-15 u-form-vertical u-inner-form" source="email" name="form" style="padding: 23px;">
          <input type="hidden" name="access_key" value="4a39f8e1-64d6-4301-95d7-10bf58aa9293">
          <div class="u-form-group u-form-name">
            <label for="name-4c18" class="u-label">Nombre de usuario</label>
            <input type="text" placeholder="usuario" id="name-4c18" name="usuario" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-radius-10" value="'.$_SESSION['username'].'" readonly required>
            <input type="text" placeholder="Asunto" id="name-4c18" name="asunto" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-radius-10" value="Cedula fue marcada como invalida" readonly hidden>
          </div>
          <div class="u-form-group u-form-name">
            <label for="name-4c18" class="u-label">Numero de teléfono</label>
            <input type="tel" placeholder="Escribe tu numero de teléfono" id="name-4c18" name="telefono" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-radius-10" required>
          </div>
          <div class="u-form-email u-form-group">
            <label for="email-4c18" class="u-label">Correo electrónico</label>
            <input type="email" placeholder="Coloca tu direccion de correo electrónico" id="email-4c18" name="email" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-radius-10" required="">
          </div>
          <div class="u-form-group u-form-message">
            <label for="message-4c18" class="u-label">Mensaje</label>
            <textarea placeholder="Escribe tu Mensaje" rows="4" cols="50" id="message-4c18" name="message" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-radius-10" required=""></textarea>
          </div>
          <div class="u-align-right u-form-group u-form-submit">
            <a href="#" class="u-active-custom-color-3 u-border-5 u-border-active-custom-color-3 u-border-custom-color-1 u-border-hover-custom-color-3 u-btn u-btn-round u-btn-submit u-button-style u-custom-color-1 u-hover-custom-color-3 u-radius-10 u-btn-1">Enviar</a>
            <input type="submit" value="submit" class="u-form-control-hidden">
          </div>
          <div class="u-form-send-message u-form-send-success">¡Gracias! Tu mensaje ha sido enviado.</div>
          <div class="u-form-send-error u-form-send-message">No podemos enviar tu mensaje. Por favor corrije los errores.</div>
        </form>
        </div>
      </div>
    </div>';

    $diplomadoIdInpur = '<input type="hidden" name="diplomadoId" value="'.$currentDiplomado['Id'].'">';

    $subscribeDiplomadoContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Inscribir curso</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
        <form role="form" autocomplete="off" action="subscribe_user_course.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;" enctype="multipart/form-data">
          <!-- Metodo de pago -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
          Selecciona tu metodo de pago preferido
          <select id="metodo_de_pago_'.$currentDiplomado['Id'].'" name="metodo_de_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" amountRd="'.$currentDiplomado['precio_inscripcion'].'" onchange="toggleFields(\''.$currentDiplomado['Id'].'\')">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Transferencia">Transferencia bancaria (adjuntar comprobante)</option>
            <option value="Tarjeta">Tarjeta de débito/crédito</option>
          </select>
        </label>

        <!-- Precio -->
          <div style="position: relative; text-align: center; justify-content: center; flex-direction: unset !important; bottom: 1% !important;" class="vetcap-badge">
            <img style="width: 70px; height: auto;" src="../assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon">
            <span>RD$'.$currentDiplomado['precio_inscripcion'].'</span>
          </div>

        <div id="paypal-button-container-'.$currentDiplomado['Id'].'" class="">
        </div>

          <!-- Comprobante de Pago -->
           <div id="comprobante_pago_field_container_'.$currentDiplomado['Id'].'" class="hidden">
           

<br>

               
'.$diplomadoIdInpur.'
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Comprobante de pago (imagenn):
            <input type="file" name="comprobante_pago" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>
          </div>

          <!-- Botón -->
          <button id="inscribir_button_'.$currentDiplomado['Id'].'" class="hidden" type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
            INSCRIBIR
          </button>
        </form>
      </div>
    </div>';

    if (!$theUser->isUserCedulaUploaded($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' needs to complete his proffile");
      echo $diplomadosModalHeader;
      echo $completeProffileContent;
      write_log("tarannn");
    } elseif ($theUser->isUserCedulaWaitingForValidation($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' have cedula waiting for validation");
      echo $diplomadosModalHeader;
      echo $proffileUnderInspection;
      write_log("tarannn");
    } elseif ($theUser->isUserCedulaInvalid($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' have an invalid cedula");
      echo $diplomadosModalHeader;
      echo $cedulaInvalid;
      write_log("tarannn");
    } elseif ($theUser->isUserCedulaValidated($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' can register to events");
      echo $diplomadosModalHeader;
      echo $subscribeDiplomadoContent;
      write_log("tarannnn");
    }

    $diplomadoModalFooter = '</div>
    </div>
    </div>';
    echo $diplomadoModalFooter;
}
function printAllEvents($eventos) {
  ?>
    <?php if (!empty($eventos)) : ?>
                <?php foreach ($eventos as $evento) : ?>
                  <?php write_log("Retrieved records: " . print_r($eventos, true));
                  ?>
                  <section class="vetcap-section">
  <div class="vetcap-container">
    <!-- Left Section -->
    <div class="vetcap-left">
      <img src="https://www.vetcaprd.com/<?= $evento['foto_evento'] ?>" alt="Illustration" class="vetcap-image vetcap-logo" />
      <div class="vetcap-badge">
        <img style="width: 70px; height: auto;" src="https://www.vetcaprd.com//assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon" />
        <span>RD$<?= htmlspecialchars($evento['precio_inscripcion']) ?></span>
      </div>
    </div>
    <!-- Right Section -->
    <div class="vetcap-right">
    <?php
            if (isset($evento['foto_titulo'])) {
              echo '<img style="max-width: 330px;" src="https://www.vetcaprd.com/'.$evento['foto_titulo'].'" alt="Vetcap Tour Logo" class="vetcap-logo" />';
            } else {
              write_log("foto titulo");
              echo '<h2 style="font-size: 50px; font-family: HelveticaBold;" class="course-title">'.$evento['nombre'].'</h2>';
            }
        ?>
      <p style="color: #2d5b2d;" class="vetcap-description">
      <?= htmlspecialchars($evento['descripcion']) ?>
      </p>
      <div id="<?php echo 'countdown-'.$evento['Id']?>" class="marginnn" style="margin-right: 0px;">
                  
                    <h2 style="color: #2d4a34; font-size: 31px; font-family: HelveticaBold; white-space: nowrap !important;">
                    <?php 
                    $eventTimestamp = $evento['fecha_evento'];
                    $dateTimeEvent = new DateTime($eventTimestamp);

                    // Format the date and time
                    $formattedDateEvent = $dateTimeEvent->format('j/n/Y | g:ia');
                    
                    // Convert "am/pm" to uppercase (optional)
                    $formattedDateEvent = strtoupper($formattedDateEvent);
                    
                    echo $formattedDateEvent; // Outputs: 28/2/2025 | 6:30PM
                    ?></h2>
  <div class="time-unit timeer">
    <span class="number" id="<?php echo 'days-'.$evento['Id']?>">00</span>
    <span class="label">DÍAS</span>
  </div>
  <div class="time-unit">
    <span class="number" id="<?php echo 'hours-'.$evento['Id']?>">00</span>
    <span class="label">HRS</span>
  </div>
  <div class="time-unit">
    <span class="number" id="<?php echo 'minutes-'.$evento['Id']?>">00</span>
    <span class="label">MINS</span>
  </div>
  <div class="time-unit">
    <span class="number" id="<?php echo 'seconds-'.$evento['Id']?>">00</span>
    <span class="label">SEGS</span>
  </div>
</div>
<script>
  let eventtId_<?php echo str_replace("-", "_", $evento['Id']); ?> = "<?= $evento['Id']?>";
  let eventTimestamp_<?php echo str_replace("-", "_", $evento['Id']); ?> = "<?= $evento['fecha_evento']?>";
  // Update every second
  console.log(eventtId_<?php echo str_replace("-", "_", $evento['Id']); ?>);
  console.log(eventTimestamp_<?php echo str_replace("-", "_", $evento['Id']); ?>);
  
  const timerInterval_<?php echo str_replace("-", "_", $evento['Id']); ?> = setInterval(() => updateCountdown(eventtId_<?php echo str_replace("-", "_", $evento['Id']); ?>, eventTimestamp_<?php echo str_replace("-", "_", $evento['Id']); ?>), 1000);
updateCountdown(eventtId_<?php echo str_replace("-", "_", $evento['Id']); ?>, eventTimestamp_<?php echo str_replace("-", "_", $evento['Id']); ?>);
</script>
<br>
      <?php 
    $isAttributeWritten = false;
    $onClick = 'location.href=\''.DIR.'VetCapMembers/login.php\'" type="button"'; // Initialize $onClick to avoid undefined variable issues
    write_log("aaaaaaaaaaaaaaa");
?>
      <button onclick="<?php echo $onClick; ?>" class="btnnn btn-filled">INSCRIBIRME</button>
    </div>
  </div>
</section>
<br><br>                    
                <?php endforeach; ?>                
            <?php endif; ?>
</section>

  <?php
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
function generateShortGUID() {
    return bin2hex(random_bytes(8)); // Generates a 16-character unique ID
}

?>
