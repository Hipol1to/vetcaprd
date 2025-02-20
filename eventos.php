<?php
  require_once('includes/config.php');
  require('layout/header.php'); 
  $eventos = getAllEvents($db);
  $nextEvent = $_SESSION['nextEvent'];
?>
      <section style="padding-top: 30px; padding-bottom: 10px;" class="about-area section-bg section-padding">
        <h2 style="font-size: 70px; font-family: HelveticaBold; text-align: center; color: #2d4a34; margin-bottom: 0%;">PROXIMO EVENTO</h2>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
              <div class="about-img about-img1">
                <img src="<?php  echo str_replace("../", "", $nextEvent['foto_evento']);; ?>" alt="" class="event-pic"/>
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
<?php
$isAttributeWritten = false;
$onClick = 'onclick="location.href=\''.DIR.'VetCapMembers/login.php\'" type="button"';
$nextEventSubscribeButton = '<div class="disvi"><button '.$onClick.'  class="rounded-button marginnn er-buston" style="width: auto !important; margin-left: 20px;width: 70px; height: auto;">INSCRIBIRME</button>';
$nextEventPriceText = $nextEvent['precio_inscripcion'] == 0.00 ? "GRATIS" : "RD$".$nextEvent['precio_inscripcion'];
echo $nextEventSubscribeButton;
 ?>

<img  src="./assets/img/money_logo.png" class="money-pic" alt=""><a class="money-free"><?php echo $nextEventPriceText; ?></a></div>


                  <p class="mb-30">
                  </p>
                  <p></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="vetcap-partners">
    <div class="vetcap-partner-logos">
      <h2 class="vetcap-partners-title">MEET OUR PARTNERS</h2>
      <img src="./assets/img/espavet_white_logo.png" alt="ESPAVET" />
      <img src="./assets/img/mallen_white_logo.png" alt="MALLÉN MASCOTAS" />
      <img src="./assets/img/animal_food_line-white_logo.png" alt="ANIMAL FOOD LINE" />
      <img src="./assets/img/ramvet_white_logo.png" alt="RAMVET" />
      <img src="./assets/img/vibix_white_logo.png" alt="VIBIX" />
      <img src="./assets/img/noctua_group_white_logo.png" alt="NOCTUA" />
    </div>
  </div>


  <section class="vetcap-section">
  <div class="vetcap-container">
    <!-- Left Section -->
    <div class="vetcap-left">
      <img src="./assets/img/vetcap_tour_template.png" alt="Illustration" class="vetcap-image vetcap-logo" />
      <div class="vetcap-badge">
        <img style="width: 70px; height: auto;" src="./assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon" />
        <span>GRATIS</span>
      </div>
    </div>

    <!-- Right Section -->
    <div class="vetcap-right">
      <img src="./assets/img/vetcap-tour-logo.png" alt="Vetcap Tour Logo" class="vetcap-logo" />
      <br>
      <br>
      <p class="vetcap-description">
        UNA SERIE DE CHARLAS GRATUITAS A NIVEL NACIONAL, DIRIGIDAS TANTO A
        ESTUDIANTES COMO A MÉDICOS VETERINARIOS.
      </p>
      <p class="vetcap-description">
        EL OBJETIVO DEL VETCAP TOUR ES ACERCAR LA CAPACITACIÓN A DIFERENTES
        REGIONES DEL PAÍS, BRINDANDO ACCESO A FORMACIÓN CONTINUA DE MANERA
        ACCESIBLE.
      </p>
      <div id="vetcap-tour-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <section class="vetcap-tour-section">
      <div class="vetcap-header">
        <img src="./assets/img/vetcap-tour-logo.png" alt="Vetcap Tour Logo" class="vetcap-logoo" />
        <div>
        <p class="vetcap-descriptionn">
          UNA SERIE DE CHARLAS GRATUITAS A NIVEL NACIONAL, DIRIGIDAS TANTO A ESTUDIANTES COMO A MÉDICOS VETERINARIOS.
        </p>
        <p class="vetcap-descriptionn">
          EL OBJETIVO DEL VETCAP TOUR ES ACERCAR LA CAPACITACIÓN A DIFERENTES REGIONES DEL PAÍS, BRINDANDO ACCESO A FORMACIÓN CONTINUA DE MANERA ACCESIBLE.
        </p>
        </div>
      </div>
      <div class="vetcap-events">
        <!-- Event Cards (Same as before) -->
        <div class="event-card">
          <img src="./assets/img/vetcap-tour-blue-bus.png" alt="Blue Bus" class="bus-icon" />
          <h3>UNIVERSIDAD ISA</h3>
          <p>Santiago de los Caballeros, RD</p>
          <p>21/2/2025 | 10:30AM</p>
          <button class="btnee btnee-filled">REGISTRARME</button>
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
        <!-- Event 2 -->
    <div class="event-card">
      <img src="./assets/img/vetcap-tour-gray-bus.png" alt="Gray Bus" class="bus-icon" />
      <h3>UNIVERSIDAD CENTRAL DEL ESTE</h3>
      <p>San Pedro de Macorís, RD</p>
      <p>04/4/2025</p>
      <button class="btnee btnee-outline">NOTIFICARME</button>
    </div>

    <!-- Event 3 -->
    <div class="event-card">
      <img src="./assets/img/vetcap-tour-gray-bus.png" alt="Gray Bus" class="bus-icon" />
      <h3>UNIVERSIDAD NACIONAL PEDRO HENRÍQUEZ UREÑA</h3>
      <p>Santo Domingo, RD</p>
      <p>16/5/2025</p>
      <button class="btnee btnee-outline">NOTIFICARME</button>
    </div>

    <!-- Event 4 -->
    <div class="event-card">
      <img src="./assets/img/vetcap-tour-gray-bus.png" alt="Gray Bus" class="bus-icon" />
      <h3>UNIVERSIDAD TECNOLÓGICA DE SANTIAGO - UTESA</h3>
      <p>Santiago de los Caballeros, RD</p>
      <p>06/6/2025</p>
      <button class="btnee btnee-outline">NOTIFICARME</button>
    </div>
      </div>
    </section>
  </div>
</div>
      <button  id="conocer-mas-vetcap_tour" style="color: black" class="btnn btn-outline">CONOCER MÁS</button>
        <button class="btnnn btn-filled">INSCRIBIRME</button>
    </div>
  </div>
</section>









      <div class="promo-bar">
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

<section class="vetcap-section">
  <div class="vetcap-container">
    <!-- Left Section -->
    <div class="vetcap-left">
      <img src="./assets/img/vetcap_tour_template.png" alt="Illustration" class="vetcap-image vetcap-logo" />
      <div class="vetcap-badge">
        <img style="width: 70px; height: auto;" src="./assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon" />
        <span>RD$5,500</span>
      </div>
    </div>

    <!-- Right Section -->
    <div class="vetcap-right">
      <img src="./assets/img/vetgames-logo.png" alt="Vetcap Tour Logo" class="vetcap-logo" />
      <br>
      <br>
      <p class="vetcap-description">
        Los Vetgames 2025, organizados por Vetcap, serán una competencia nacional en la que equipos de 2 a 5 personas, entre estudiantes y profesionales veterinarios, se enfrentarán en una serie de preguntas sobre temas clave de medicina veterinaria. Con etapas regionales en Santiago y Santo Domingo, cada equipo competirá por un prize pool de RD$100,000 y la oportunidad de llegar a la gran final en el Vetcamp 2025. 
      </p>
      <div id="vetgames-modal" class="modal">
  <div class="modal-content">
    <span class="close closee">&times;</span>
    <section class="vetcap-tour-section">
      <div class="vetcap-header">
        <img src="./assets/img/vetgames-logo.png" alt="Vetcap Tour Logo" class="vetcap-logoo" />
        <div>
          <br>
        <p style="font-size: 1.3rem; line-height: 1.3;" class="vetcap-descriptionn">
          Los Vetgames son una competencia nacional creada por Vetcap para celebrarse entre julio y agosto del 2025. La competencia está diseñada para equipos de 2 a 5 personas, ya sean estudiantes o profesionales, y se asemeja a programas como “Dame la pasta”, “Preguntados” o “Quiero ser millonario”. Los equipos responderán preguntas en diferentes categorías para acumular puntos y avanzar en el torneo.</p>

<p style="font-size: 1.3rem; line-height: 1.3;" class="vetcap-descriptionn">
La competencia está dividida en dos regiones: Región Norte (Sede: Santiago de los Caballeros) y Región Sureste (Sede: Santo Domingo), con un máximo de 25 equipos por región, sumando 50 equipos en total. Los mejores equipos de cada región se enfrentarán en una gran final que tendrá lugar en el Vetcamp 2025, con la oportunidad de ganar premios en efectivo. El prize pool es de RD$100,000 y está dividido de la siguiente manera: Campeón nacional RD$44,000, Subcampeón nacional RD$32,000, y Subcampeones regionales RD$12,000 cada uno.</p>

  <p style="font-size: 1.3rem; line-height: 1.3;" class="vetcap-descriptionn">
Las preguntas abarcan temas de fisiología, nutrición, anatomía, patología y laboratorio, enfocados en especies como perros, gatos, bovinos, equinos, pollos y cerdos. Las preguntas están clasificadas en tres niveles de dificultad: Blue (20s con opciones), Green (40s con opción múltiple), y Red (60s sin opciones). Los equipos tendrán 40 segundos para responder cada pregunta, y la divulgación de respuestas conllevará expulsión inmediata del torneo.</p>

<p style="font-size: 1.3rem; line-height: 1.3;" class="vetcap-descriptionn">
El costo de inscripción es de RD$5,500 por equipo, y los participantes deben elegir un nombre, logo de animal y camisetas obligatorias. Además, los ganadores regionales recibirán acceso gratuito al Vetcamp 2025, donde se coronará al equipo campeón nacional.
        </p>
        </div>
      </div>
      
    </section>
  </div>
</div>
      <button  id="conocer-mas-vetgames" style="color: black" class="btnn btn-outline">CONOCER MÁS</button>
        <button class="btnnn btn-filled">INSCRIBIRME</button>
    </div>
  </div>
</section>


<div class="promo-bar-container">
  <!-- Logo Section -->
  <div class="promo-bar-logo-section">
    <img
      class="promo-bar-logo"
      src="./assets/img/mallen-mascotas-logo.png"
      alt="Mallén Mascotas Logo"
    />
  </div>

  <!-- Middle Image Section -->
  <div class="promo-bar-middle-images">
    <img 
      src="./assets/img/royal-canin.png" 
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



<section class="vetcap-section">
  <div class="vetcap-container">
    <!-- Left Section -->
    <div class="vetcap-left">
      <img src="./assets/img/vetcap_tour_template.png" alt="Illustration" class="vetcap-image vetcap-logo" />
      <div class="vetcap-badge">
        <img style="width: 70px; height: auto;" src="./assets/img/money_logo.png" alt="Gratis Icon" class="badge-icon" />
        <span>$RD$7,500</span>
      </div>
    </div>

    <!-- Right Section -->
    <div class="vetcap-right">
      <img style="max-width: 330px;" src="./assets/img/vetcamp-logo-2025.png" alt="Vetcap Tour Logo" class="vetcap-logo" />
      <br>
      <br>
      <p style="color: #2d5b2d;" class="vetcap-description">
        El VetCamp es un campamento educativo diseñado para estudiantes y profesionales de veterinaria. Mediante talleres, charlas y actividades con expertos del sector, los participantes desarrollan habilidades clave y amplían su red profesional, contribuyendo a su preparación en el campo veterinario.
      </p>
      <div id="vetcamp-modal" class="modal">
  <div class="modal-content">
    <span class="close closeee">&times;</span>
    <section class="vetcamp-sectionn">
  <div class="vetcamp-container">
    <div class="vetcamp-text">
      <div class="vetcamp-headerr">
        <img style="max-width: 330px;" src="./assets/img/vetcamp-logo-2025.png" alt="Vetcap Tour Logo" class="vetcap-logo" />
        <p class="vetcamp-descriptionn">
          El VetCamp de la Fundación Vetcap es un campamento educativo especializado, dirigido a estudiantes y profesionales de veterinaria en la República Dominicana que desean complementar su formación académica con experiencias prácticas y profundizar en diversas áreas de la medicina veterinaria. Este programa incluye una combinación de talleres interactivos, charlas impartidas por expertos, y actividades de aprendizaje práctico, todas diseñadas para proporcionar una comprensión sólida de temas clave en el campo veterinario, tales como medicina interna, cirugía, anestesia, y manejo de especies. 
        </p>
      </div>

      <div class="vetcamp-contentt">
        <p>
          A través del VetCamp, los participantes también tienen la oportunidad de conectarse con profesionales experimentados y otros estudiantes interesados en el desarrollo profesional, ampliando así su red de contactos en el ámbito veterinario. Este campamento no solo mejora sus conocimientos y habilidades técnicas, sino que también fomenta un ambiente de colaboración y aprendizaje continuo, esencial para su crecimiento y éxito en la carrera veterinaria.
        </p>
      </div>
    </div>

    <div class="vetcamp-galleryy">
      <div class="vetcamp-image"><img src="./assets/img/vetcamp-conocer-mas/1.png" alt="VetCamp Speaker">
        <div class="vetcamp-image"><img src="./assets/img/vetcamp-conocer-mas/4.png" alt="VetCamp Workshop"></div>
        <div class="vetcamp-image"><img style="width: 205%;" src="./assets/img/vetcamp-conocer-mas/6.png" alt="VetCamp Networking"></div></div>
      <div class="vetcamp-image"><img src="./assets/img/vetcamp-conocer-mas/2.png" alt="VetCamp Audience">
        <div class="vetcamp-image"><img src="./assets/img/vetcamp-conocer-mas/5.png" alt="VetCamp Networking"></div></div>
      <div class="vetcamp-image"><img style="width: 92%;" src="./assets/img/vetcamp-conocer-mas/3.png" alt="VetCamp Event">
        <div class="vetcamp-image"><img src="./assets/img/vetcamp-conocer-mas/7.png" alt="VetCamp Networking"></div></div>
      
      
    </div>
  </div>
</section>
  </div>
</div>
      <button  id="conocer-mas-vetcamp" style="color: black" class="btnn btn-outline">CONOCER MÁS</button>
        <button class="btnnn btn-filled">INSCRIBIRME</button>
    </div>
  </div>
</section>




<section style="background-color: black;" class="vetcap-section">
  <div class="vetcap-container">
    <!-- Left Section -->
    <div class="vetcap-left">
      <img src="./assets/img/golden-vet-logo.png" alt="Illustration" class="vetcap-image vetcap-logo" />
      <p style="font-size: 3.3rem; line-height: 0.8; font-family: Nimbus; color: #f8af12; margin-top: 10px;">Golden Vet</p>
        <p style="font-size: 2.3rem; line-height: 0.8; font-family: Nimbus; margin-bottom: 22px; color: white;">Awards</p>
        <p style="font-size: 2.3rem; line-height: 0.8; font-family: Nimbus; color: white !important;">20<a style="font-size: 2.3rem; line-height: 0.8; font-family: Nimbus; color: #f8af12 !important;">25</a></p>
    </div>

    <!-- Right Section -->
    <div class="vetcap-right">
      <p style="color: white; font-size: 1rem;" class="vetcap-description">
        Los Golden Vet Awards son una iniciativa de la Fundación VetCap destinada a reconocer y celebrar la excelencia en el sector veterinario de la República Dominicana. Estos premios destacan a profesionales y empresas que han realizado contribuciones significativas al desarrollo y fortalecimiento de la medicina veterinaria en el país.
Las categorías de los Golden Vet Awards abarcan diversas áreas de la práctica veterinaria, permitiendo una evaluación integral de los aportes realizados por individuos y organizaciones.</p>

<p style="color: white; font-size: 1rem;" class="vetcap-description">
La ceremonia de premiación se lleva a cabo en un evento formal, donde se reúnen líderes del sector, profesionales, educadores y empresas para celebrar los logros de los galardonados. Este evento no solo sirve como reconocimiento, sino también como una plataforma para el networking y el intercambio de ideas que promueven el crecimiento continuo de la medicina veterinaria en la República Dominicana.
      </p>
      <div id="vetcamp-modal" class="modal">
  <div class="modal-content">
    <span class="close closeee">&times;</span>
  </div>
</div>
      <button  id="notificarme-golden-vet" style="color: black; line-height: 1.3;" class="btnn btn-outlinee">NOTIFICARME CUANDO ESTÉ DISPONIBLE</button>
    </div>
  </div>
</section>
<script src="./assets/js/modalEventos.js"></script>
    <script src="./assets/js/modalVetGames.js"></script>
    <script src="./assets/js/modalVetCamp.js"></script>



<?php 
//include header template
require('layout/footer.php'); 
?>