<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in()){
    header('Location: login.php'); 
    exit(); 
}



//include header template
require('layout/header.php'); 
try {
  $query = $db->prepare("SELECT * FROM `eventos` ORDER BY fecha_evento ASC");
  $query->execute();
  // Fetch only the first row
  $nextEvent = $query->fetch(PDO::FETCH_ASSOC);
  $eventos = $query->fetchAll(PDO::FETCH_ASSOC);
  error_log("------STARTING SESSION LOG------");
  error_log(print_r($nextEvent, true));
  
} catch (Exception $e) {
  die("Error fetching data: " . $e->getMessage());
}
try {
  $myEventsQuery = $db->prepare("SELECT * FROM eventos LEFT JOIN usuario_eventos ON eventos.Id = usuario_eventos.evento_id WHERE usuario_eventos.usuario_id = :userId");
  $myEventsQuery->bindParam(':userId', $_SESSION['memberID']);
  $myEventsQuery->execute();
  $misEventos = $myEventsQuery->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  die("Error fetching data: " . $e->getMessage());
}
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
      error_log("Verifiying if user has events: ".$userHasEvents);
            foreach ($misEventos as $theEvent) {
              $userHasEvents = true;
              error_log("Does user has events?: ".$userHasEvents);
              array_push($userEventosList, $theEvent['Id']);
              echo '<!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: row; align-items: start; gap: 20px; margin-bottom: 20px;">
        <div class="event-image-container" style="flex: 1; max-width: 150px;">
          <img 
            src="'.$theEvent['foto_evento'].'" 
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
        <a class="btn-danger" style="cursor: pointer; text-decoration: none; font-weight: 550; text-align: left; color: white; padding: 10px 20px; background-color:rgb(238, 76, 76); border-radius: 5px; display: inline-block;" 
       onclick="unsubscribeEvent(\''.$theEvent['Id'].'\')">
        Desinscribir
    </a>
      </div>';
            }
            if (!$userHasEvents) {
              echo '<p style="text-align: center; margin-bottom: 20px;">Aún no estás suscrito a ningún evento.</p>';
            }      
      ?>
    </div>
  </div>
</div>




<br><br>
<div class="promo-bar">
  <div class="text-section">
    <div class="logo-info">LOBO CORPORATION | FUNDACIÓN VETCAP</div>
    <div class="collection-title">HIVE <a style="color:white;">& HOWL</a></div>
    <div class="collection-subtitle">COLLECTION</div>
  </div>
  <div class="image-section">
    <img src="../assets/img/vetcap_lobo.png" alt="Cap image">
  </div>
  <div class="hashtag-section">
    <h2>#VETCAPXLOBO</h2>
  </div>
  <div class="button-section">
    <button class="rounded-button">SHOP NOW</button>
  </div>
</div>



<section style="padding-top: 30px; padding-bottom: 10px;" class="about-area section-bg section-padding">
        <h2 style="font-size: 70px; font-family: HelveticaBold; text-align: center; color: #2d4a34; margin-bottom: 0%;">PROXIMO EVENTO</h2>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
              <div class="about-img about-img1">
                <img src="<?php  echo $nextEvent['foto_evento']; ?>" alt="" class="event-pic"/>
              </div>
            </div>
            <div
              class="offset-xl-1 offset-lg-0 offset-sm-1 col-xxl-5 col-xl-5 col-lg-6 col-md-9 col-sm-11"
            >
              <div class="about-caption about-caption1">
                <div class="section-tittle m-0">
                  <!-- second section !-->
                  <img src="./assets/img/centro_de_cultura_logo.png" style="width: 300px;" alt="">
                  <h2 style="font-size: 50px; font-family: HelveticaBold;"><?php echo $nextEvent['nombre']; ?></h2>
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
  console.log(nextEventId);
  console.log(nextEventTimestamp);
  
  const timerInterval = setInterval(() => updateCountdown(nextEventId, nextEventTimestamp), 1000);
updateCountdown(nextEventId, nextEventTimestamp);
</script>
<br>
<div class="disvi"><button onclick="openSubscribeModal('<?php echo $nextEvent['Id']; ?>')"  class="rounded-button marginnn er-buston" style="width: auto !important; margin-left: 20px;width: 70px; height: auto;">INSCRIBIRME</button><img  src="./assets/img/money_logo.png" class="money-pic" alt=""><a class="money-free">GRATIS</a></div>


                  <p class="mb-30">
                  </p>
                  <p></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



<br><br><br>
<hr />

<?php if (!empty($eventos)) : ?>
  <?php error_log("taran");
        $eventosList = [["modalName", 0]];
    ?>
                <?php foreach ($eventos as $evento) : ?>
                  <?php error_log("Retrieved records: " . print_r($eventos, true));
                        array_push($eventosList, [$evento['Id'], 0]);
                        error_log("Eventos list: " . print_r($eventosList, true));
                  ?>
                  <section class="vetcap-section">
  <div class="vetcap-container">
    <!-- Left Section -->
    <div class="vetcap-left">
      <img src="<?= $evento['foto_evento'] ?>" alt="Illustration" class="vetcap-image vetcap-logo" />
      <div class="vetcap-badge">
        <img style="width: 70px; height: auto;" src="../assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon" />
        <span>RD$<?= htmlspecialchars($evento['precio_inscripcion']) ?></span>
      </div>
    </div>
    <!-- Right Section -->
    <div class="vetcap-right">
    <?php
            if (isset($evento['foto_titulo'])) {
              echo '<img style="max-width: 330px;" src="'.$evento['foto_titulo'].'" alt="Vetcap Tour Logo" class="vetcap-logo" />';
            } else {
              error_log("foto titulo");
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
  let eventtId_<?php echo $evento['Id']; ?> = "<?= $evento['Id']?>";
  let eventTimestamp_<?php echo $evento['Id']; ?> = "<?= $evento['fecha_evento']?>";
  // Update every second
  console.log(eventtId_<?php echo $evento['Id']; ?>);
  console.log(eventTimestamp_<?php echo $evento['Id']; ?>);
  
  const timerInterval_<?php echo $evento['Id']; ?> = setInterval(() => updateCountdown(eventtId_<?php echo $evento['Id']; ?>, eventTimestamp_<?php echo $evento['Id']; ?>), 1000);
updateCountdown(eventtId_<?php echo $evento['Id']; ?>, eventTimestamp_<?php echo $evento['Id']; ?>);
</script>
<br>
      <button onclick="location.href='http://localhost/vesca/eventos.php';" id="conocer-mas" style="color: black" class="btnn btn-outline">CONOCER MÁS</button>
      <?php 
    $isAttributeWritten = false;
    $onClick = ''; // Initialize $onClick to avoid undefined variable issues
    error_log("aaaaaaaaaaaaaaa");

    foreach ($misEventos as $possibleEvent) {
        error_log($possibleEvent['Id']);
        error_log($evento['Id']);
        if ($possibleEvent['Id'] == $evento['Id']) {
            $onClick = 'alert(\'Ya estás suscrito a este evento.\')';
            $isAttributeWritten = true;
        }
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
        <form role="form" autocomplete="off" action="complete_proffile.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;">
          <div class="form-group">
            <label for="cedula">Número de Cédula:</label>
            <input type="number" class="form-control" id="cedula" name="cedula_numero" required>
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
$subscribeEventContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Inscribir evento</h2>
    
    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
        <form role="form" autocomplete="off" action="" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;">
          <!-- Metodo de pago -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
          Selecciona tu metodo de pago preferido
          <select id="metodo_de_pago_'.$evento['Id'].'" name="metodo_de_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" amountRd="'.$evento['precio_inscripcion'].'" onchange="toggleFields(\''.$evento['Id'].'\')">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Transferencia">Transferencia bancaria (adjuntar comprobante)</option>
            <option value="Tarjeta">Tarjeta de débito/crédito</option>
          </select>
        </label>

        <div id="paypal-button-container-'.$evento['Id'].'" class="">
        </div>

          <!-- Comprobante de Pago -->
           <div id="comprobante_pago_field_container_'.$evento['Id'].'" class="hidden">
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Comprobante de pago (imagenn):
            <input type="file" name="comprobante_pago" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>
          </div>

          <!-- Precio -->
          <div style="position: relative; text-align: center; justify-content: center; flex-direction: unset !important; bottom: 1% !important;" class="vetcap-badge">
            <img style="width: 70px; height: auto;" src="../assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon">
            <span>$RD$7,500</span>
          </div>

          <!-- Botón -->
          <button type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
            INSCRIBIR
          </button>
        </form>
  <!-- <script src="../assets/js/trx.js"></script> -->
      </div>
    </div>';

    if (isset($_GET['photoUploaded']) && isset($_SESSION['cedulaHavePath']) && $_SESSION['cedulaHavePath'] == 1) {
      error_log("The user: '".$_SESSION['username']."' just uploaded the photos");
      $subscribeEventContent = '<h2 style="color: #2d4a34; margin-bottom: 20px;">Inscribir evento</h2>

    <!-- Events List -->
    <div class="events-list" style="display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center;">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 600px;">
        <form role="form" autocomplete="off" action="" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px; width: 100%;">
          <!-- Metodo de pago -->
          <label style="color: #2d4a34; width: 100%; text-align: left;">
          Selecciona tu metodo de pago preferido
          <select id="metodo_de_pago_'.$evento['Id'].'" name="metodo_de_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" amountRd="'.$evento['precio_inscripcion'].'" onchange="toggleFields()">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Transferencia">Transferencia bancaria (adjuntar comprobante)</option>
            <option value="Tarjeta">Tarjeta de débito/crédito</option>
          </select>
        </label>

        <div id="paypal-button-container-'.$evento['Id'].'" class="">

          <!-- Comprobante de Pago -->
           <div id="comprobante_pago_field_container_'.$evento['Id'].'" class="hidden">
          <label style="color: #2d4a34; width: 100%; text-align: left;">
            Comprobante de pago (imagen):
            <input type="file" name="comprobante_pago" accept="image/*" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </label>
          </div>

          <!-- Precio -->
          <div style="position: relative; text-align: center; justify-content: center; flex-direction: unset !important; bottom: 1% !important;" class="vetcap-badge">
            <img style="width: 70px; height: auto;" src="../assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon">
            <span>$RD$7,500</span>
          </div>

          <!-- Botón -->
          <button type="submit" name="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
            INSCRIBIR
          </button>
        </form>
  <!-- <script src="../assets/js/trx.js"></script> -->
  <script>document.getElementById(\'subscribe-events-modal\').style.display = \'flex\';</script>
      </div>
    </div>';

    error_log("tarann");
    //echo $eventsModalHeader;
    //echo $subscribeEventContent;
    } elseif (!$user->isUserCedulaUploaded($_SESSION['username'])) {
      error_log("The user: '".$_SESSION['username']."' needs to complete his proffile");
      //echo $eventsModalHeader;
      //echo $completeProffileContent;
      error_log("tarannn");
    } else {
      error_log("The user: '".$_SESSION['username']."' can register to events");
      echo $eventsModalHeader;
      echo $subscribeEventContent;
      error_log("tarannnn");
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






<div class="promo-bar-container">
  <!-- Logo Section -->
  <div class="promo-bar-logo-section">
    <img
      class="promo-bar-logo"
      src="../assets/img/mallen-mascotas-logo.png"
      alt="Mallén Mascotas Logo"
    />
  </div>

  <!-- Middle Image Section -->
  <div class="promo-bar-middle-images">
    <img 
      src="../assets/img/royal-canin.png" 
      alt="Dog and Cat" 
    />
  </div>

  <!-- Subtitle and Button Section -->
   <div class="promo-bar-action-section">
    <span class="promo-bar-subtitle">Breed health nutrition</span>
  </div>
  <div class="promo-bar-action-section">
    <button class="promo-bar-rounded-button">
      <i class="promo-bar-button-icon"></i> SHOP NOW
    </button>
  </div>
</div>







<section class="slider-capacitaciones-section">
  <h1 class="title">Diplomados</h1>
  <div class="slider-capacitaciones-container">
    
    <div class="slider-capacitaciones">
      <div class="slide">
        <div class="diplomado-container">
    <div class="image-box">
      <div class="image-placeholder">
        <span class="month">MARZO</span>
      </div>
      <div class="disvi"><button class="rounded-button marginnnn er-bustonn" style="margin-top: 20px; ">INSCRIBIRME</button></div>
    </div>
    <div class="info-box">
      <h2 class="course-title">Diplomado de Avicultura</h2>
      <p class="mode"><span>Modalidad</span> Virtual | Presencial</p>
      <p class="duration">
        <span>Duración</span>
        <br />
        Inicio: 1/3/2025
        <br />
        Fin: 1/6/2025
      </p>
      <p class="price">RD$19,999</p>
      <p class="contact">
        Para más información, contáctanos al
        <br />
        <strong>(809) 344-5048</strong>
      </p>
    </div>
    <div id="countdown" class="countdown">
    <div class="time-unit">
      <span class="number" id="days">00</span>
      <span class="label">DÍAS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="hours">00</span>
      <span class="label">HRS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="minutes">00</span>
      <span class="label">MINS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="seconds">00</span>
      <span class="label">SEGS</span>
    </div>
  </div>
  </div>
  
      </div>
      <div class="slide">
        <div class="diplomado-container">
    <div class="image-box">
      <div class="image-placeholder">
        <span class="month">MARZO</span>
      </div>
      <div class="disvi"><button class="rounded-button marginnnn er-bustonn" style="margin-top: 20px; ">INSCRIBIRME</button></div>
    </div>
    <div class="info-box">
      <h2 class="course-title">Curso intensivo de Clínica Básica</h2>
      <p class="mode"><span>Modalidad</span> Virtual | Presencial</p>
      <p class="duration">
        <span>Duración</span>
        <br />
        Inicio: 1/3/2025
        <br />
        Fin: 1/6/2025
      </p>
      <p class="price">RD$4,999</p>
      <p class="contact">
        Para más información, contáctanos al
        <br />
        <strong>(809) 344-5048</strong>
      </p>
    </div>
    <div id="countdown" class="countdown">
    <div class="time-unit">
      <span class="number" id="days">00</span>
      <span class="label">DÍAS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="hours">00</span>
      <span class="label">HRS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="minutes">00</span>
      <span class="label">MINS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="seconds">00</span>
      <span class="label">SEGS</span>
    </div>
  </div>
  </div>
      </div>
      <div class="slide">
        <div class="diplomado-container">
    <div class="image-box">
      <div class="image-placeholder">
        <span class="month">JULIO</span>
      </div>
      <div class="disvi"><button class="rounded-button marginnnn er-bustonn" style="margin-top: 20px; ">INSCRIBIRME</button></div>
    </div>
    <div class="info-box">
      <h2 class="course-title">Diplomado de Medicina Interna</h2>
      <p class="mode"><span>Modalidad</span> Virtual | Presencial</p>
      <p class="duration">
        <span>Duración</span>
        <br />
        Inicio: 1/3/2025
        <br />
        Fin: 1/6/2025
      </p>
      <p class="price">RD$19,999</p>
      <p class="contact">
        Para más información, contáctanos al
        <br />
        <strong>(809) 344-5048</strong>
      </p>
    </div>
    <div id="countdown" class="countdown">
    <div class="time-unit">
      <span class="number" id="days">00</span>
      <span class="label">DÍAS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="hours">00</span>
      <span class="label">HRS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="minutes">00</span>
      <span class="label">MINS</span>
    </div>
    <div class="time-unit">
      <span class="number" id="seconds">00</span>
      <span class="label">SEGS</span>
    </div>
  </div>
  </div>
      </div>
    </div>
    <button class="slider-capacitaciones-btn prev-btn">&lt;</button>
    <button class="slider-capacitaciones-btn next-btn">&gt;</button>
  </div>
</section>
<script src="https://www.sandbox.paypal.com/sdk/js?client-id=Ae15xLTKadxt1n17OTKnYK9GKc6TTcqvBM5CHt1IXAAKKwlTtx_RJ82ndJssVjy8ioL6Hw3bxz2teIqU&currency=USD&locale=es_DO"
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



      <?php 
//include header template
require('layout/footer.php'); 
?>