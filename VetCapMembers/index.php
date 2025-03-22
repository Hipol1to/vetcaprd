<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in()){
    header('Location: login.php'); 
    exit(); 
}




//include header template
require('layout/header.php'); 
$eventosList = [["modalName", 0]];
$eventos = getAllEvents($db);
$nextEvent = $_SESSION['nextEvent'];

$misEventos = getUserEvents($db);
$misPendingEventos = getUserPendingEvents($db);

$misDiplomados = getUserCourses($db);
$diplomados = getAllCourses($db);
$misPendingCourses = getUserPendingCourses($db);

?>
 <style>
    /* Correctly hides elements */
    .hidden {
      display: none;
    }
  </style>
<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
    <p style="margin: 0;">
    <a class="btn-danger" style="text-decoration: none; font-weight: 550; text-align: left; color: white; padding: 10px 20px; background-color:rgb(238, 76, 76); border-radius: 5px; display: inline-block;" 
       href="logout.php" 
       onclick="return confirm('¿Estás seguro que quieres cerrar sesión?');">
        Cerrar sesión
    </a>
    <?php
if ($user->is_logged_in() && isset($_SESSION['rol']) && $_SESSION['rol'] == "administrador") {
  $goToAdminPortalButton = '
    <a class="btn-info" style="text-decoration: none; font-weight: 550; text-align: left; color: black; padding: 10px 20px; border-radius: 5px; display: inline-block;" 
       href="../VetCapAdmins/index.php" 
        >
        Ir al portal de administradores
    </a>
  ';
  echo $goToAdminPortalButton;
}
 ?>
</p>


    <h2 style="font-size: 30px; font-family: HelveticaBold; text-align: right; color: #2d4a34; margin-bottom: 0;">
        Bienvenido/a <?php echo htmlspecialchars($_SESSION['name']) ?>
    </h2>
</div>
<style>
    @media (max-width: 768px) {
        div {
            flex-direction: column;
            align-items: flex-start; /* Align text and link on mobile devices */
        }
        h2 {
            text-align: left; /* Align heading to the left for smaller screens */
            font-size: 24px; /* Adjust font size for mobile screens */
        }
        p {
            margin-bottom: 10px; /* Add space between the link and heading */
        }
    }
</style>

<section class="events-button-section" style="text-align: center; margin-top: 40px;">


<h3 style="margin-bottom: 0px !important; text-align: center; font-size: 3rem;" class="vetcap-title">Consulta tus eventos en todo momento.</h3>
<div class="vetone-right-description">
    <p style="font-size: 1.5rem">
      Revisa tus eventos e inscribe  aquellos que te interesan.
    </p>
  </div>

  <button 
    id="view-events-button" 
    style="padding: 10px 20px; font-size: 16px; background-color: #2d4a34; color: white; border: none; border-radius: 5px; cursor: pointer;"
    onclick="openMyEventsModal()">
    Ver mis Eventos
  </button>
  <button 
    id="view-events-button" 
    style="padding: 10px 20px; font-size: 16px; background-color: #2d4a34; color: white; border: none; border-radius: 5px; cursor: pointer;"
    onclick="openMyCoursesModal()">
    Ver mis Cursos
  </button>
</section>

<!-- Modal -->
<div id="my-events-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
  <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative;">
    <span 
      onclick="closeMyEventsModal()" 
      style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #555;">
      &times;
    </span>
    <h2 style="color: #2d4a34; text-align: center; margin-bottom: 20px;">Eventos Suscritos</h2>
    
    <!-- Events List -->
    <div class="events-list">
      <?php
      $userEventosList = ["eventName"];
      $userHasEvents = false;
      write_log("Verifiying if user has events: ".$userHasEvents);
            foreach ($misEventos as $theEvent) {
              $userHasEvents = true;
              write_log("Does user has events?: ".$userHasEvents);
              array_push($userEventosList, $theEvent['Id']);
              echo '<!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: row; align-items: start; gap: 20px; margin-bottom: 20px;">
        <div class="event-image-container" style="flex: 1; max-width: 150px;">
          <img 
            src="https://www.vetcaprd.com/'.$theEvent['foto_evento'].'" 
            alt="Event Photo" 
            style="width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
          />
        </div>
        <div class="event-details-container" style="flex: 3;">
          <h2 class="event-title" style="color: #2d4a34; font-size: 1.5rem; margin-bottom: 10px;">'.$theEvent['nombre'].'</h2>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            '.$theEvent['descripcion'].'
          </p>
          <p class="event-price" style="color: #007BFF; font-size: 1rem; font-weight: bold;">Precio de Suscripción: RD$'.$theEvent['precio_inscripcion'].'</p>
          <p class="event-date" style="color: #555; font-size: 1rem;">Fecha y Hora: '.$theEvent['fecha_evento'].'</p>
        </div>
        
        
      </div>';
      $desinscribirButton = '<a class="btn-danger" style="cursor: pointer; text-decoration: none; font-weight: 550; text-align: left; color: white; padding: 10px 20px; background-color:rgb(238, 76, 76); border-radius: 5px; display: inline-block;" 
       onclick="unsubscribeEvent(\''.$theEvent['Id'].'\')">
        Desinscribir
    </a>';
            }
            if (!$userHasEvents) {
              echo '<p style="text-align: center; margin-bottom: 20px;">Aún no estás suscrito a ningún evento.</p>';
            }      
            
      ?>
    </div>
    <?php
    if (isset($misPendingEventos[0])) {
      $pendingEventsHeader ='<h2 style="color: #2d4a34; text-align: center; margin-bottom: 20px;">Eventos en revisión</h2>
    
    <!-- Events List -->
    <div class="events-list">';
    echo $pendingEventsHeader;
    echo '<p style="text-align: center; margin-bottom: 20px;">Estamos revisando tu solicitud de inscripción para estos eventos.</p>';




    foreach ($misPendingEventos as $thePendingEvent) {
      $userHasPendingEvents = true;
      write_log("Does user has pending events?: ".$userHasPendingEvents);
      echo '<!-- Event Container (Repeat this block for each event) -->
<div class="event-container" style="display: flex; flex-direction: row; align-items: start; gap: 20px; margin-bottom: 20px;">
<div class="event-image-container" style="flex: 1; max-width: 150px;">
  <img 
    src="https://www.vetcaprd.com/'.$thePendingEvent['foto_evento'].'" 
    alt="Event Photo" 
    style="width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
  />
</div>
<div class="event-details-container" style="flex: 3;">
  <h2 class="event-title" style="color: #2d4a34; font-size: 1.5rem; margin-bottom: 10px;">'.$thePendingEvent['nombre'].'</h2>
  <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
    '.$thePendingEvent['descripcion'].'
  </p>
  <p class="event-price" style="color: #007BFF; font-size: 1rem; font-weight: bold;">Precio de Suscripción: RD$'.$thePendingEvent['precio_inscripcion'].'</p>
  <p class="event-date" style="color: #555; font-size: 1rem;">Fecha y Hora: '.$thePendingEvent['fecha_evento'].'</p>
</div>
</div>';
    }




    $pendingEventsFooter = '</div>';
    echo $pendingEventsFooter;
    }
     ?>
  </div>
</div>









<!-- Modal -->
<div id="my-courses-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
  <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative;">
    <span 
      onclick="closeMyEventsModal()" 
      style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #555;">
      &times;
    </span>
    <h2 style="color: #2d4a34; text-align: center; margin-bottom: 20px;">Capacitaciones Suscritas</h2>
    
    <!-- Events List -->
    <div class="events-list">
      <?php
      $userCoursesList = ["eventName"];
      $userHasCourses = false;
      write_log("Verifiying if user has events: ".$userHasCourses);
            foreach ($misDiplomados as $theCourse) {
              $userHasCourses = true;
              write_log("Does user has events?: ".$userHasCourses);
              array_push($userCoursesList, $theCourse['Id']);
              echo '<!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: row; align-items: start; gap: 20px; margin-bottom: 20px;">
        <div class="event-image-container" style="flex: 1; max-width: 150px;">
          <img 
            src="https://www.vetcaprd.com/'.$theCourse['foto_diplomado'].'" 
            alt="Foto capacitación" 
            style="width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
          />
        </div>
        <div class="event-details-container" style="flex: 3;">
          <h2 class="event-title" style="color: #2d4a34; font-size: 1.5rem; margin-bottom: 10px;">'.$theCourse['nombre'].'</h2>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            '.$theCourse['descripcion'].'
          </p>
          <p class="event-price" style="color: #007BFF; font-size: 1rem; font-weight: bold;">Precio de Suscripción: RD$'.$theCourse['precio_inscripcion'].'</p>
          <p class="event-date" style="color: #555; font-size: 1rem;">Fecha y Hora: '.$theCourse['fecha_inicio_diplomado'].'</p>
        </div>
        
        
      </div>';
      $desinscribirCourseButton = '<a class="btn-danger" style="cursor: pointer; text-decoration: none; font-weight: 550; text-align: left; color: white; padding: 10px 20px; background-color:rgb(238, 76, 76); border-radius: 5px; display: inline-block;" 
       onclick="unsubscribeEvent(\''.$theCourse['Id'].'\')">
        Desinscribir
    </a>';
            }
            if (!$userHasCourses) {
              echo '<p style="text-align: center; margin-bottom: 20px;">Aún no estás suscrito a ningúna capacitación.</p>';
            }      
            
      ?>
    </div>
    <?php
    if (isset($misPendingCourses[0])) {
      $pendingCoursesHeader ='<h2 style="color: #2d4a34; text-align: center; margin-bottom: 20px;">Eventos en revisión</h2>
    
    <!-- Events List -->
    <div class="events-list">';
    echo $pendingCoursesHeader;
    echo '<p style="text-align: center; margin-bottom: 20px;">Estamos revisando tu solicitud de inscripción para estas capcitaciones.</p>';




    foreach ($misPendingCourses as $thePendingCourse) {
      $userHasPendingCourses = true;
      write_log("Does user has pending events?: ".$userHasPendingCourses);
      echo '<!-- Event Container (Repeat this block for each event) -->
<div class="event-container" style="display: flex; flex-direction: row; align-items: start; gap: 20px; margin-bottom: 20px;">
<div class="event-image-container" style="flex: 1; max-width: 150px;">
  <img 
    src="https://www.vetcaprd.com/'.$thePendingCourse['foto_diplomado'].'" 
    alt="Event Photo" 
    style="width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
  />
</div>
<div class="event-details-container" style="flex: 3;">
  <h2 class="event-title" style="color: #2d4a34; font-size: 1.5rem; margin-bottom: 10px;">'.$thePendingCourse['nombre'].'</h2>
  <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
    '.$thePendingCourse['descripcion'].'
  </p>
  <p class="event-price" style="color: #007BFF; font-size: 1rem; font-weight: bold;">Precio de Suscripción: RD$'.$thePendingCourse['precio_inscripcion'].'</p>
  <p class="event-date" style="color: #555; font-size: 1rem;">Fecha y Hora: '.$thePendingCourse['fecha_inicio_diplomado'].'</p>
</div>
</div>';
    }




    $pendingCoursesFooter = '</div>';
    echo $pendingCoursesFooter;
    }
     ?>
  </div>
</div>








<script></script>


<section id="nextEventSection" style="padding-top: 30px; padding-bottom: 10px;" class="hidden about-area section-bg section-padding">
        <h2 style="font-size: 50px; font-family: Horizon; text-align: center; color: #2d4a34; margin-bottom: 0%;">PROXIMO EVENTO</h2>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
              <div class="about-img about-img1">
                <img src="https://www.vetcaprd.com/<?php  echo $nextEvent['foto_evento']; ?>" alt="" class="event-pic"/>
              </div>
            </div>
            <div
              class="offset-xl-1 offset-lg-0 offset-sm-1 col-xxl-5 col-xl-5 col-lg-6 col-md-9 col-sm-11"
            >
              <div class="about-caption about-caption1">
                <div class="section-tittle m-0">
                  <!-- second section 
                  <img src="https://www.vetcaprd.com//assets/img/centro_de_cultura_logo.png" style="width: 300px;" alt=""> !-->
                  <h2 style="font-size: 30px; font-family: Horizon;"><?php echo $nextEvent['nombre']; ?></h2>
                  <p style="color: #2d5b2d;" class="capitalize-first vetcap-description">
      <?= htmlspecialchars($nextEvent['descripcion']) ?>
      </p>
                  
                  <div id="<?php echo 'countdown-'.$nextEvent['Id']?>" class="marginnn" style="margin-right: 100px;">
                  
                    <h2 style="font-size: 31px; font-family: HelveticaBold; white-space: nowrap !important;">
                    <?php 
                    $timestamp = $nextEvent['fecha_evento'];
                    $dateTime = new DateTime($timestamp);

                    // Format the date and time
                    $formatted = $dateTime->format('j/n/Y | g:ia');
                    
                    // Convert "am/pm" to uppercase (optional)
                    $formatted = strtoupper($formatted);
                    
                    echo $formatted; // Outputs: 28/2/2025 | 6:30PM
                    ?></h2>
  <div class="time-unit timeer">
    <span class="number" id="<?php echo 'days-'.$nextEvent['Id']?>">00</span>
    <span class="label">DÍAS</span>
  </div>
  <div class="time-unit">
    <span class="number" id="<?php echo 'hours-'.$nextEvent['Id']?>">00</span>
    <span class="label">HRS</span>
  </div>
  <div class="time-unit">
    <span class="number" id="<?php echo 'minutes-'.$nextEvent['Id']?>">00</span>
    <span class="label">MINS</span>
  </div>
  <div class="time-unit">
    <span class="number" id="<?php echo 'seconds-'.$nextEvent['Id']?>">00</span>
    <span class="label">SEGS</span>
  </div>
</div>
<script>
  let nextEventId = "<?= $nextEvent['Id']?>";
  let nextEventTimestamp = "<?= $nextEvent['fecha_evento']?>";
  // Update every second
  console.log("wer");
  console.log(nextEventId);
  console.log(nextEventTimestamp);
  
  const timerInterval = setInterval(() => updateCountdown(nextEventId, nextEventTimestamp), 1000);
updateCountdown(nextEventId, nextEventTimestamp);
</script>
<br>
<?php
$isAttributeWritten = false;
$onClick = '';
foreach ($misEventos as $possibleEvent) {
  write_log($possibleEvent['Id']);
  write_log($nextEvent['Id']);
  if ($possibleEvent['Id'] == $nextEvent['Id']) {
      $onClick = 'onclick="alert(\'Ya estás suscrito a este evento.\')"';
      $isAttributeWritten = true;
  }
}
foreach ($misPendingEventos as $possiblePendingEvent) {
  write_log($possiblePendingEvent['Id']);
  write_log($nextEvent['Id']);
  if ($possiblePendingEvent['Id'] == $nextEvent['Id']) {
      $onClick = 'onclick="alert(\'Ya solicitaste inscribirte a este evento, estamos revisando tu solicitud.\')"';
      $isAttributeWritten = true;
  }
}

if ($nextEvent['precio_inscripcion'] == 0.00 && !$isAttributeWritten) {
  $onClick = 'onclick="registerUserToFreeEvent(\''.$nextEvent['Id'].'\')"';
} elseif (!$isAttributeWritten) {
  $onClick = 'onclick="openSubscribeModal(\''.$nextEvent['Id'].'\')"';
}
$nextEventSubscribeButton = '<div class="disvi"><button '.$onClick.'  class="rounded-button marginnn er-buston" style="width: auto !important; margin-left: 20px;width: 70px; height: auto;">INSCRIBIRME</button>';
$nextEventPriceText = $nextEvent['precio_inscripcion'] == 0.00 ? "GRATIS" : "RD$".$nextEvent['precio_inscripcion'];
echo $nextEventSubscribeButton;
 ?>

<img  src="https://www.vetcaprd.com//assets/img/money_logo.png" class="money-pic" alt=""><a class="money-free"><?php echo $nextEventPriceText; ?></a></div>


                  <p class="mb-30">
                  </p>
                  <p></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


<?php
write_log("telomando".$nextEvent['Id']);
array_push($eventosList, [$nextEvent['Id'], 0]);
$eventsModalHeader = '
    <div id="subscribe-events-modal'.$nextEvent['Id'].'" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
      <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative; display: flex; flex-direction: column; align-items: center; text-align: center;">
        <span 
          onclick="closeSubscribeModal(\''.$nextEvent['Id'].'\')" 
          style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #555;">
          &times;
          </span>';
    
$completeProffileContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Completa tu perfil</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
      <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Debes completar tu perfil antes de inscribirte en este evento, envía tu cedula de identidad o la de tu tutor legal.
          </p>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Podrás inscribirte al evento una vez envies tu documento de identidad.
          </p>
          <br>
        <form role="form" autocomplete="off" action="complete_proffile.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;" enctype="multipart/form-data">
          <div class="form-group">
            <label for="cedula">Número de Cédula:</label>
            <label for="cedula">Cédula:</label>
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
    $valueToSend = $nextEvent['Id'];
    write_log($valueToSend);
    $theValue = encryptValue($valueToSend);
    //write_log($theValue);
    //$thecryptedValue = decryptValue($theValue);
    //write_log($thecryptedValue);
    $eventIdInpur = '<input type="hidden" name="eventId" value="'.$nextEvent['Id'].'">';

$subscribeEventContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Inscribir evento</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
        <form role="form" autocomplete="off" action="subscribe_user_event.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;" enctype="multipart/form-data">
          <!-- Metodo de pago -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
          Selecciona tu metodo de pago preferido
          <select id="metodo_de_pago_'.$nextEvent['Id'].'" name="metodo_de_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" amountRd="'.$nextEvent['precio_inscripcion'].'" onchange="toggleFields(\''.$nextEvent['Id'].'\')">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Transferencia">Transferencia bancaria (adjuntar comprobante)</option>
            <option value="Tarjeta">Tarjeta de débito/crédito</option>
          </select>
        </label>


        <!-- Precio -->
          <div style="position: relative; text-align: center; justify-content: center; flex-direction: unset !important; bottom: 1% !important;" class="vetcap-badge">
            <img style="width: 70px; height: auto;" src="../assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon">
            <span>RD$'.$nextEvent['precio_inscripcion'].'</span>
          </div>


        <div id="paypal-button-container-'.$nextEvent['Id'].'" class="">
        </div>

        

          <!-- Comprobante de Pago -->
           <div id="comprobante_pago_field_container_'.$nextEvent['Id'].'" class="hidden">



           <label for="addMonto">Monto (RD$):</label>
                <input type="number" class="form-control" id="addMonto" name="addMonto" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

<br>


                <label for="addCuentaRemitente">Número de cuenta remitente:</label>
                <input type="text" class="form-control" id="addCuentaRemitente" name="addCuentaRemitente" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

<br>

                <label for="editTipoCuentaRemitente">Tipo de cuenta remitente:</label>
                <select id="editTipoCuentaRemitente" name="editTipoCuentaRemitente" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                  <option value="" disabled="" selected="">Tipo de Cuenta</option>
                    <option value="Cuenta de ahorros">Cuenta de ahorros</option>
                    <option value="Cuenta corriente">Cuenta corriente</option>
                </select>

<br>
<br>


                <label for="addEntidadBancariaRemitente">Entidad bancaria remitente</label>
  <select id="addEntidadBancariaRemitente" name="addEntidadBancariaRemitente" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
    <option value="Banreservas" disabled selected>Entidad Bancaria Remitente</option>
    <option value="Banreservas">Banreservas</option>
    <option value="Banco Popular Dominicano">Banco Popular Dominicano</option>
    <option value="Banco BHD">Banco BHD</option>
    <option value="Asociación Popular de Ahorros y Préstamos">Asociación Popular de Ahorros y Préstamos</option>
    <option value="Scotiabank">Scotiabank</option>
    <option value="Banco Santa Cruz">Banco Santa Cruz</option>
    <option value="Asociación Cibao de Ahorros y Préstamos">Asociación Cibao de Ahorros y Préstamos</option>
    <option value="Banco Promerica">Banco Promerica</option>
    <option value="Banesco">Banesco</option>
    <option value="Banco Caribe">Banco Caribe</option>
    <option value="Banco Agrícola">Banco Agrícola</option>
    <option value="Asociación La Nacional de Ahorros y Préstamos">Asociación La Nacional de Ahorros y Préstamos</option>
    <option value="Citibank">Citibank</option>
    <option value="Banco BDI">Banco BDI</option>
    <option value="Banco Vimenca">Banco Vimenca</option>
    <option value="Banco López de Haro">Banco López de Haro</option>
    <option value="Bandex">Bandex</option>
    <option value="Banco Ademi">Banco Ademi</option>
    <option value="Banco Lafise">Banco Lafise</option>
    <option value="Motor Crédit Banco de Ahorro y Crédito">Motor Crédit Banco de Ahorro y Crédito</option>
    <option value="Alaver Asociación de Ahorros y Préstamos">Alaver Asociación de Ahorros y Préstamos</option>
    <option value="Banfondesa">Banfondesa</option>
    <option value="Banco Adopem">Banco Adopem</option>
    <option value="Asociación Duarte">Asociación Duarte</option>
    <option value="JMMB Bank">JMMB Bank</option>
    <option value="Asociación Mocana">Asociación Mocana</option>
    <option value="ABONAP">ABONAP</option>
    <option value="Banco Unión">Banco Unión</option>
    <option value="Banco BACC">Banco BACC</option>
    <option value="Asociación Romana">Asociación Romana</option>
    <option value="Asociación Peravia">Asociación Peravia</option>
    <option value="Banco Confisa">Banco Confisa</option>
    <option value="Leasing Confisa">Leasing Confisa</option>
    <option value="Qik Banco Digital">Qik Banco Digital</option>
    <option value="Banco Fihogar">Banco Fihogar</option>
    <option value="Asociación Maguana de Ahorros y Préstamos">Asociación Maguana de Ahorros y Préstamos</option>
    <option value="Banco Atlántico">Banco Atlántico</option>
    <option value="Bancotui">Bancotui</option>
    <option value="Banco Activo">Banco Activo</option>
    <option value="Banco Gruficorp">Banco Gruficorp</option>
    <option value="Corporación de Crédito Nordestana">Corporación de Crédito Nordestana</option>
    <option value="Banco Óptima de Ahorro y Crédito">Banco Óptima de Ahorro y Crédito</option>
    <option value="Banco Cofaci">Banco Cofaci</option>
    <option value="Bonanza Banco">Bonanza Banco</option>
    <option value="Corporación de Crédito Monumental">Corporación de Crédito Monumental</option>
    <option value="Banco Empire">Banco Empire</option>
    <option value="Corporación de Crédito Oficorp">Corporación de Crédito Oficorp</option>
</select>

<br>
<br>


            <label for="addCuentaRemitente">Número de cuenta destinatario:</label>
                <input type="text" class="form-control" id="addCuentaDestinatario" name="addCuentaRemitente" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

<br>
'.$eventIdInpur.'

                <label for="editTipoCuentaRemitente">Tipo de Cuenta destinatario:</label>
                <select id="editTipoCuentaRemitente" name="editTipoCuentaDestinatario" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                  <option value="" disabled="" selected="">Tipo de Cuenta</option>
                    <option value="Cuenta de ahorros">Cuenta de ahorros</option>
                    <option value="Cuenta corriente">Cuenta corriente</option>
                </select>

<br>
<br>


                <label for="addEntidadBancariaRemitente">Entidad Bancaria destinatario</label>
  <select id="addEntidadBancariaRemitente" name="addEntidadBancariaDestinatario" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
    <option value="Banreservas" disabled selected>Entidad Bancaria Remitente</option>
    <option value="Banreservas">Banreservas</option>
    <option value="Banco Popular Dominicano">Banco Popular Dominicano</option>
    <option value="Banco BHD">Banco BHD</option>
    <option value="Asociación Popular de Ahorros y Préstamos">Asociación Popular de Ahorros y Préstamos</option>
    <option value="Scotiabank">Scotiabank</option>
    <option value="Banco Santa Cruz">Banco Santa Cruz</option>
    <option value="Asociación Cibao de Ahorros y Préstamos">Asociación Cibao de Ahorros y Préstamos</option>
    <option value="Banco Promerica">Banco Promerica</option>
    <option value="Banesco">Banesco</option>
    <option value="Banco Caribe">Banco Caribe</option>
    <option value="Banco Agrícola">Banco Agrícola</option>
    <option value="Asociación La Nacional de Ahorros y Préstamos">Asociación La Nacional de Ahorros y Préstamos</option>
    <option value="Citibank">Citibank</option>
    <option value="Banco BDI">Banco BDI</option>
    <option value="Banco Vimenca">Banco Vimenca</option>
    <option value="Banco López de Haro">Banco López de Haro</option>
    <option value="Bandex">Bandex</option>
    <option value="Banco Ademi">Banco Ademi</option>
    <option value="Banco Lafise">Banco Lafise</option>
    <option value="Motor Crédit Banco de Ahorro y Crédito">Motor Crédit Banco de Ahorro y Crédito</option>
    <option value="Alaver Asociación de Ahorros y Préstamos">Alaver Asociación de Ahorros y Préstamos</option>
    <option value="Banfondesa">Banfondesa</option>
    <option value="Banco Adopem">Banco Adopem</option>
    <option value="Asociación Duarte">Asociación Duarte</option>
    <option value="JMMB Bank">JMMB Bank</option>
    <option value="Asociación Mocana">Asociación Mocana</option>
    <option value="ABONAP">ABONAP</option>
    <option value="Banco Unión">Banco Unión</option>
    <option value="Banco BACC">Banco BACC</option>
    <option value="Asociación Romana">Asociación Romana</option>
    <option value="Asociación Peravia">Asociación Peravia</option>
    <option value="Banco Confisa">Banco Confisa</option>
    <option value="Leasing Confisa">Leasing Confisa</option>
    <option value="Qik Banco Digital">Qik Banco Digital</option>
    <option value="Banco Fihogar">Banco Fihogar</option>
    <option value="Asociación Maguana de Ahorros y Préstamos">Asociación Maguana de Ahorros y Préstamos</option>
    <option value="Banco Atlántico">Banco Atlántico</option>
    <option value="Bancotui">Bancotui</option>
    <option value="Banco Activo">Banco Activo</option>
    <option value="Banco Gruficorp">Banco Gruficorp</option>
    <option value="Corporación de Crédito Nordestana">Corporación de Crédito Nordestana</option>
    <option value="Banco Óptima de Ahorro y Crédito">Banco Óptima de Ahorro y Crédito</option>
    <option value="Banco Cofaci">Banco Cofaci</option>
    <option value="Bonanza Banco">Bonanza Banco</option>
    <option value="Corporación de Crédito Monumental">Corporación de Crédito Monumental</option>
    <option value="Banco Empire">Banco Empire</option>
    <option value="Corporación de Crédito Oficorp">Corporación de Crédito Oficorp</option>
</select>


<br>
<br>

          <label style="color: #2d4a34; width: 100%; text-align: left;" for="addFechaDePago">Fecha de Pago:</label>
            <input type="text" class="datepicker" id="addFechaDePago" name="addFechaDePago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">



<br>
<br>
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Comprobante de pago (imagenn):
            <input type="file" name="comprobante_pago" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>
          </div>

          <!-- Botón -->
          <button id="inscribir_button_'.$nextEvent['Id'].'" class="hidden" type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
            INSCRIBIR
          </button>
        </form>
  <!-- <script src="../assets/js/trx.js"></script> -->
      </div>
    </div>';

    if (!$user->isUserCedulaUploaded($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' needs to complete his proffile");
      echo $eventsModalHeader;
      echo $completeProffileContent;
      write_log("tarannn");
    } elseif ($user->isUserCedulaWaitingForValidation($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' have cedula waiting for validation");
      echo $eventsModalHeader;
      echo $proffileUnderInspection;
      write_log("tarannn");
    } elseif ($user->isUserCedulaInvalid($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' have an invalid cedula");
      echo $eventsModalHeader;
      echo $cedulaInvalid;
      write_log("tarannn");
    } elseif ($user->isUserCedulaValidated($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' can register to events");
      echo $eventsModalHeader;
      echo $subscribeEventContent;
      write_log("tarannnn");
    }
    write_log("is user cedula validated?: ".$user->isUserCedulaValidated($_SESSION['username']));
    /*elseif (!$user->isUserCedulaValidated($_SESSION['username'])) {
      echo $completeProffileContent;
    } else {
      echo $subscribeEventContent;
    }*/
    $eventModalFooter = '</div>
    </div>
	</div>';
  echo $eventModalFooter;
?>



<br><br><br>
<hr />

<?php if (!empty($eventos)) : ?>
  <?php write_log("taran");
    ?>
                <?php foreach ($eventos as $evento) : ?>
                  <?php write_log("Retrieved records: " . print_r($eventos, true));
                        array_push($eventosList, [$evento['Id'], 0]);
                        write_log("Eventos list: " . print_r($eventosList, true));
                  ?>
                  <section class="vetcap-section">
  <div id="eventosContainer" class="hidden vetcap-container">
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
      <button onclick="location.href='https://www.vetcaprd.com//eventos.php';" id="conocer-mas" style="color: black" class="btnn btn-outline">CONOCER MÁS</button>
      <?php 
    $isAttributeWritten = false;
    $onClick = ''; // Initialize $onClick to avoid undefined variable issues
    write_log("aaaaaaaaaaaaaaa");

    foreach ($misEventos as $possibleEvent) {
        write_log($possibleEvent['Id']);
        write_log($evento['Id']);
        if ($possibleEvent['Id'] == $evento['Id']) {
            $onClick = 'alert(\'Ya estás suscrito a este evento.\')';
            $isAttributeWritten = true;
        }
    }

    foreach ($misPendingEventos as $possiblePendingEvent) {
      write_log($possiblePendingEvent['Id']);
      write_log($possiblePendingEvent['Id']);
      if ($possiblePendingEvent['Id'] == $evento['Id']) {
          $onClick = 'alert(\'Ya solicitaste inscribirte a este evento, estamos revisando tu solicitud.\')';
          $isAttributeWritten = true;
      }
  }
  if (!$isAttributeWritten && $evento['precio_inscripcion'] == 0.00) {
    $onClick = 'registerUserToFreeEvent(\'' . $evento['Id'] . '\')';
    $isAttributeWritten = true;
  }

    // Fallback if $onClick is not set in the loop
    if (!$isAttributeWritten) {
      $onClick = 'openSubscribeModal(\'' . $evento['Id'] . '\')';
    }
?>
      <button onclick="<?php echo $onClick; ?>" class="btnnn btn-filled">INSCRIBIRME</button>
    </div>
  </div>
</section>




<?php

$eventsModalHeader = '
    <div id="subscribe-events-modal'.$evento['Id'].'" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
      <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative; display: flex; flex-direction: column; align-items: center; text-align: center;">
        <span 
          onclick="closeSubscribeModal(\''.$evento['Id'].'\')" 
          style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #555;">
          &times;
          </span>';
    
          $completeProffileContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Completa tu perfil</h2>
    
          <!-- Events List -->
          <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
            <!-- Event Container (Repeat this block for each event) -->
            <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
            <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
                  Debes completar tu perfil antes de inscribirte en este evento, envía tu cedula de identidad o la de tu tutor legal.
                </p>
                <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
                  Podrás inscribirte al evento una vez envies tu documento de identidad.
                </p>
                <br>
              <form role="form" autocomplete="off" action="complete_proffile.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="cedula">Número de Cédula:</label>
                  <label for="cedula">Cédula:</label>
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
    $valueToSend = $evento['Id'];
    write_log($valueToSend);
    $theValue = encryptValue($valueToSend);
    //write_log($theValue);
    //$thecryptedValue = decryptValue($theValue);
    //write_log($thecryptedValue);
    $eventIdInpur = '<input type="hidden" name="eventId" value="'.$evento['Id'].'">';

$subscribeEventContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Inscribir evento</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
        <form role="form" autocomplete="off" action="subscribe_user_event.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;" enctype="multipart/form-data">
          <!-- Metodo de pago -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
          Selecciona tu metodo de pago preferido
          <select id="metodo_de_pago_'.$evento['Id'].'" name="metodo_de_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" amountRd="'.$evento['precio_inscripcion'].'" onchange="toggleFields(\''.$evento['Id'].'\')">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Transferencia">Transferencia bancaria (adjuntar comprobante)</option>
            <option value="Tarjeta">Tarjeta de débito/crédito</option>
          </select>
        </label>


        <!-- Precio -->
          <div style="position: relative; text-align: center; justify-content: center; flex-direction: unset !important; bottom: 1% !important;" class="vetcap-badge">
            <img style="width: 70px; height: auto;" src="../assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon">
            <span>RD$'.$evento['precio_inscripcion'].'</span>
          </div>


        <div id="paypal-button-container-'.$evento['Id'].'" class="">
        </div>

        

          <!-- Comprobante de Pago -->
           <div id="comprobante_pago_field_container_'.$evento['Id'].'" class="hidden">



           <label for="addMonto">Monto (RD$):</label>
                <input type="number" class="form-control" id="addMonto" name="addMonto" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

<br>


                <label for="addCuentaRemitente">Número de cuenta remitente:</label>
                <input type="text" class="form-control" id="addCuentaRemitente" name="addCuentaRemitente" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

<br>

                <label for="editTipoCuentaRemitente">Tipo de cuenta remitente:</label>
                <select id="editTipoCuentaRemitente" name="editTipoCuentaRemitente" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                  <option value="" disabled="" selected="">Tipo de Cuenta</option>
                    <option value="Cuenta de ahorros">Cuenta de ahorros</option>
                    <option value="Cuenta corriente">Cuenta corriente</option>
                </select>

<br>
<br>


                <label for="addEntidadBancariaRemitente">Entidad bancaria remitente</label>
  <select id="addEntidadBancariaRemitente" name="addEntidadBancariaRemitente" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
    <option value="Banreservas" disabled selected>Entidad Bancaria Remitente</option>
    <option value="Banreservas">Banreservas</option>
    <option value="Banco Popular Dominicano">Banco Popular Dominicano</option>
    <option value="Banco BHD">Banco BHD</option>
    <option value="Asociación Popular de Ahorros y Préstamos">Asociación Popular de Ahorros y Préstamos</option>
    <option value="Scotiabank">Scotiabank</option>
    <option value="Banco Santa Cruz">Banco Santa Cruz</option>
    <option value="Asociación Cibao de Ahorros y Préstamos">Asociación Cibao de Ahorros y Préstamos</option>
    <option value="Banco Promerica">Banco Promerica</option>
    <option value="Banesco">Banesco</option>
    <option value="Banco Caribe">Banco Caribe</option>
    <option value="Banco Agrícola">Banco Agrícola</option>
    <option value="Asociación La Nacional de Ahorros y Préstamos">Asociación La Nacional de Ahorros y Préstamos</option>
    <option value="Citibank">Citibank</option>
    <option value="Banco BDI">Banco BDI</option>
    <option value="Banco Vimenca">Banco Vimenca</option>
    <option value="Banco López de Haro">Banco López de Haro</option>
    <option value="Bandex">Bandex</option>
    <option value="Banco Ademi">Banco Ademi</option>
    <option value="Banco Lafise">Banco Lafise</option>
    <option value="Motor Crédit Banco de Ahorro y Crédito">Motor Crédit Banco de Ahorro y Crédito</option>
    <option value="Alaver Asociación de Ahorros y Préstamos">Alaver Asociación de Ahorros y Préstamos</option>
    <option value="Banfondesa">Banfondesa</option>
    <option value="Banco Adopem">Banco Adopem</option>
    <option value="Asociación Duarte">Asociación Duarte</option>
    <option value="JMMB Bank">JMMB Bank</option>
    <option value="Asociación Mocana">Asociación Mocana</option>
    <option value="ABONAP">ABONAP</option>
    <option value="Banco Unión">Banco Unión</option>
    <option value="Banco BACC">Banco BACC</option>
    <option value="Asociación Romana">Asociación Romana</option>
    <option value="Asociación Peravia">Asociación Peravia</option>
    <option value="Banco Confisa">Banco Confisa</option>
    <option value="Leasing Confisa">Leasing Confisa</option>
    <option value="Qik Banco Digital">Qik Banco Digital</option>
    <option value="Banco Fihogar">Banco Fihogar</option>
    <option value="Asociación Maguana de Ahorros y Préstamos">Asociación Maguana de Ahorros y Préstamos</option>
    <option value="Banco Atlántico">Banco Atlántico</option>
    <option value="Bancotui">Bancotui</option>
    <option value="Banco Activo">Banco Activo</option>
    <option value="Banco Gruficorp">Banco Gruficorp</option>
    <option value="Corporación de Crédito Nordestana">Corporación de Crédito Nordestana</option>
    <option value="Banco Óptima de Ahorro y Crédito">Banco Óptima de Ahorro y Crédito</option>
    <option value="Banco Cofaci">Banco Cofaci</option>
    <option value="Bonanza Banco">Bonanza Banco</option>
    <option value="Corporación de Crédito Monumental">Corporación de Crédito Monumental</option>
    <option value="Banco Empire">Banco Empire</option>
    <option value="Corporación de Crédito Oficorp">Corporación de Crédito Oficorp</option>
</select>

<br>
<br>


            <label for="addCuentaRemitente">Número de cuenta destinatario:</label>
                <input type="text" class="form-control" id="addCuentaDestinatario" name="addCuentaDestinatario" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

<br>
'.$eventIdInpur.'

                <label for="editTipoCuentaRemitente">Tipo de Cuenta destinatario:</label>
                <select id="editTipoCuentaRemitente" name="editTipoCuentaDestinatario" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                  <option value="" disabled="" selected="">Tipo de Cuenta</option>
                    <option value="Cuenta de ahorros">Cuenta de ahorros</option>
                    <option value="Cuenta corriente">Cuenta corriente</option>
                </select>

<br>
<br>


                <label for="addEntidadBancariaRemitente">Entidad Bancaria destinatario</label>
  <select id="addEntidadBancariaRemitente" name="addEntidadBancariaDestinatario" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
    <option value="Banreservas" disabled selected>Entidad Bancaria Remitente</option>
    <option value="Banreservas">Banreservas</option>
    <option value="Banco Popular Dominicano">Banco Popular Dominicano</option>
    <option value="Banco BHD">Banco BHD</option>
    <option value="Asociación Popular de Ahorros y Préstamos">Asociación Popular de Ahorros y Préstamos</option>
    <option value="Scotiabank">Scotiabank</option>
    <option value="Banco Santa Cruz">Banco Santa Cruz</option>
    <option value="Asociación Cibao de Ahorros y Préstamos">Asociación Cibao de Ahorros y Préstamos</option>
    <option value="Banco Promerica">Banco Promerica</option>
    <option value="Banesco">Banesco</option>
    <option value="Banco Caribe">Banco Caribe</option>
    <option value="Banco Agrícola">Banco Agrícola</option>
    <option value="Asociación La Nacional de Ahorros y Préstamos">Asociación La Nacional de Ahorros y Préstamos</option>
    <option value="Citibank">Citibank</option>
    <option value="Banco BDI">Banco BDI</option>
    <option value="Banco Vimenca">Banco Vimenca</option>
    <option value="Banco López de Haro">Banco López de Haro</option>
    <option value="Bandex">Bandex</option>
    <option value="Banco Ademi">Banco Ademi</option>
    <option value="Banco Lafise">Banco Lafise</option>
    <option value="Motor Crédit Banco de Ahorro y Crédito">Motor Crédit Banco de Ahorro y Crédito</option>
    <option value="Alaver Asociación de Ahorros y Préstamos">Alaver Asociación de Ahorros y Préstamos</option>
    <option value="Banfondesa">Banfondesa</option>
    <option value="Banco Adopem">Banco Adopem</option>
    <option value="Asociación Duarte">Asociación Duarte</option>
    <option value="JMMB Bank">JMMB Bank</option>
    <option value="Asociación Mocana">Asociación Mocana</option>
    <option value="ABONAP">ABONAP</option>
    <option value="Banco Unión">Banco Unión</option>
    <option value="Banco BACC">Banco BACC</option>
    <option value="Asociación Romana">Asociación Romana</option>
    <option value="Asociación Peravia">Asociación Peravia</option>
    <option value="Banco Confisa">Banco Confisa</option>
    <option value="Leasing Confisa">Leasing Confisa</option>
    <option value="Qik Banco Digital">Qik Banco Digital</option>
    <option value="Banco Fihogar">Banco Fihogar</option>
    <option value="Asociación Maguana de Ahorros y Préstamos">Asociación Maguana de Ahorros y Préstamos</option>
    <option value="Banco Atlántico">Banco Atlántico</option>
    <option value="Bancotui">Bancotui</option>
    <option value="Banco Activo">Banco Activo</option>
    <option value="Banco Gruficorp">Banco Gruficorp</option>
    <option value="Corporación de Crédito Nordestana">Corporación de Crédito Nordestana</option>
    <option value="Banco Óptima de Ahorro y Crédito">Banco Óptima de Ahorro y Crédito</option>
    <option value="Banco Cofaci">Banco Cofaci</option>
    <option value="Bonanza Banco">Bonanza Banco</option>
    <option value="Corporación de Crédito Monumental">Corporación de Crédito Monumental</option>
    <option value="Banco Empire">Banco Empire</option>
    <option value="Corporación de Crédito Oficorp">Corporación de Crédito Oficorp</option>
</select>


<br>
<br>

          <label style="color: #2d4a34; width: 100%; text-align: left;" for="addFechaDePago">Fecha de Pago:</label>
            <input type="text" class="datepicker" id="addFechaDePago" name="addFechaDePago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">



<br>
<br>
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Comprobante de pago (imagenn):
            <input type="file" name="comprobante_pago" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>
          </div>

          <!-- Botón -->
          <button id="inscribir_button_'.$evento['Id'].'" class="hidden" type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
            INSCRIBIR
          </button>
        </form>
  <!-- <script src="../assets/js/trx.js"></script> -->
      </div>
    </div>';

    if (!$user->isUserCedulaUploaded($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' needs to complete his proffile");
      echo $eventsModalHeader;
      echo $completeProffileContent;
      write_log("tarannn");
    } elseif ($user->isUserCedulaWaitingForValidation($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' have cedula waiting for validation");
      echo $eventsModalHeader;
      echo $proffileUnderInspection;
      write_log("tarannn");
    } elseif ($user->isUserCedulaInvalid($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' have an invalid cedula");
      echo $eventsModalHeader;
      echo $cedulaInvalid;
      write_log("tarannn");
    } elseif ($user->isUserCedulaValidated($_SESSION['username'])) {
      write_log("The user: '".$_SESSION['username']."' can register to events");
      echo $eventsModalHeader;
      echo $subscribeEventContent;
      write_log("tarannnn");
    }
    /*elseif (!$user->isUserCedulaValidated($_SESSION['username'])) {
      echo $completeProffileContent;
    } else {
      echo $subscribeEventContent;
    }*/
    $eventModalFooter = '</div>
    </div>
	</div>';
  echo $eventModalFooter;
                         ?>







<script>  
  function openSubscribeModal(eventId) {
    document.getElementById('subscribe-events-modal'+eventId).style.display = 'flex';
  }

  function closeSubscribeModal(eventId) {
    document.getElementById('subscribe-events-modal'+eventId).style.display = 'none';
  }</script>
<br><br>                    
                <?php endforeach; ?>                
            <?php endif; ?>
</section>






<section class="u-align-center u-clearfix u-container-align-center u-valign-middle u-section-4" id="block-4">
      <div class="u-carousel u-expanded-width u-gallery u-gallery-slider u-layout-carousel u-lightbox u-no-transition u-show-text-on-hover u-gallery-1" id="carousel-2023" data-interval="2750" data-u-ride="carousel" data-pause="false">
        <ol class="u-absolute-hcenter u-carousel-indicators u-carousel-indicators-1">
          <li data-u-target="#carousel-2023" data-u-slide-to="0" class="u-active u-shape-circle" style="width: 10px; height: 10px;"></li>
          <li data-u-target="#carousel-2023" data-u-slide-to="1" class="u-shape-circle" style="width: 10px; height: 10px;"></li>
        </ol>
        <div class="u-carousel-inner u-gallery-inner" role="listbox">
          <div class="u-active u-carousel-item u-effect-fade u-gallery-item u-carousel-item-1" data-href="https://mallenmascotas.com/" data-target="_blank">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="../images/Banner-MM-VETCAP-1900x200_px.png">
            </div>
            <div class="u-align-center u-over-slide u-shading u-valign-bottom u-over-slide-1"></div>
          </div>
          <div class="u-carousel-item u-effect-fade u-gallery-item u-carousel-item-2">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="../images/banners-MMMesadetrabajo1300x.png">
            </div>
            <div class="u-align-center u-over-slide u-shading u-valign-bottom u-over-slide-2">
              <!-- <h3 class="u-gallery-heading">Sample Title</h3>
              <p class="u-gallery-text">Sample Text</p> -->
            </div>
          </div>
        </div>
        <a class="u-absolute-vcenter u-carousel-control u-carousel-control-prev u-hidden u-opacity u-opacity-70 u-spacing-10 u-text-white u-carousel-control-1" href="#carousel-2023" role="button" data-u-slide="prev">
          <span aria-hidden="true">
            <svg viewBox="0 0 451.847 451.847"><path d="M97.141,225.92c0-8.095,3.091-16.192,9.259-22.366L300.689,9.27c12.359-12.359,32.397-12.359,44.751,0
c12.354,12.354,12.354,32.388,0,44.748L173.525,225.92l171.903,171.909c12.354,12.354,12.354,32.391,0,44.744
c-12.354,12.365-32.386,12.365-44.745,0l-194.29-194.281C100.226,242.115,97.141,234.018,97.141,225.92z"></path></svg>
          </span>
          <span class="sr-only">
            <svg viewBox="0 0 451.847 451.847"><path d="M97.141,225.92c0-8.095,3.091-16.192,9.259-22.366L300.689,9.27c12.359-12.359,32.397-12.359,44.751,0
c12.354,12.354,12.354,32.388,0,44.748L173.525,225.92l171.903,171.909c12.354,12.354,12.354,32.391,0,44.744
c-12.354,12.365-32.386,12.365-44.745,0l-194.29-194.281C100.226,242.115,97.141,234.018,97.141,225.92z"></path></svg>
          </span>
        </a>
        <a class="u-absolute-vcenter u-carousel-control u-carousel-control-next u-hidden u-opacity u-opacity-70 u-spacing-10 u-text-white u-carousel-control-2" href="#carousel-2023" role="button" data-u-slide="next">
          <span aria-hidden="true">
            <svg viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744
L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284
c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"></path></svg>
          </span>
          <span class="sr-only">
            <svg viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744
L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284
c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"></path></svg>
          </span>
        </a>
      </div>
    </section>







<section id="diplomadosSection" class="hidden slider-capacitaciones-section">
  <h1 class="title">Diplomados</h1>
  <?php
  $_SESSION['eventosListForPayment'] = $eventosList;
    renderDiplomadosSlider($diplomados, $misPendingCourses, $misDiplomados, $user);
    $eventosList = $_SESSION['eventosListForPayment'];
   ?>
</section>
<script src="https://www.sandbox.paypal.com/sdk/js?client-id=AdA9xIixISOAmAq-vAW_iBFx12xb3MoR5Ww4K1DK3pD5SATmbq17-_f6acn4zEUGSexNGIIs3Lj5oun0&currency=USD&locale=es_DO"
  data-shipping-preference="NO_SHIPPING"></script>
  <script src="../assets/js/trx.js"></script>
  <script>
    let isTrxRunning = false;
    window.isTrxRunning = [[]];
    <?php
          for ($i=0; $i < count($eventosList); $i++) { 
            echo "window.isTrxRunning.push(['".$eventosList[$i][0]."', ".$eventosList[$i][1]."]);";
          }
     ?>
  </script> 
<script src="../assets/js/membersUtils.js"></script>

<script src="../assets/js/capacitacionesSlider.js"></script>
<?php
if (isset($nextEvent)) {
$hideSection = '<script>
let laSeccionElement = document.getElementById("nextEventSection");
laSeccionElement.classList.remove("hidden");
</script>';
echo $hideSection;
}
if (isset($eventos)) {
$hideSection = '<script>
let eventosContainerElement = document.getElementById("eventosContainer");
eventosContainerElement.classList.remove("hidden");
</script>';
echo $hideSection;
}
if (isset($diplomados)) {
$hideSection = '<script>
let diplomadosSectionElement = document.getElementById("diplomadosSection");
diplomadosSectionElement.classList.remove("hidden");
</script>';
echo $hideSection;
}
 ?>

      <?php 
//include header template
require('layout/footer.php'); 
?>