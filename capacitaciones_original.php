<?php
      require_once('includes/config.php');
      require('layout/header.php'); 
      $diplomados = getAllCourses($db);
       ?>
<section class="vetcap-education-section">
  <div style="margin-bottom:0px;" class="vetcap-header">
    <h1 style="margin-bottom: 0px !important; font-family: Horizon; text-align:left;" class="vetcap-title">CURSOS,<br>TALLERES <a style="color: orange;">&</a><br>DIPLOMADOS</h1>
    <div class="vetcap-logos">
      <img style="width: 300px;" src="./assets/img/vetcap-new-logo-normal.png" alt="Fundación Vetcap" class="vetcap-logo" />
      <img style="width: 200px;" src="./assets/img/colegio_de_medicos_logo.png" alt="COLVET" class="vetcap-logo" />
    </div>
  </div>
  <br>
  <br>
  <div class="vetcap-description">
    <p style="font-family:Helvetica;">
    <strong>
      Vetcap estará organizando una amplia variedad de diplomados, cursos y talleres diseñados
      para fortalecer el conocimiento y las habilidades de profesionales y estudiantes en el ámbito veterinario.
      Cada programa cuenta con el aval oficial del Colegio Médico Veterinario (COLVET), lo que asegura una formación
      de alta calidad y con respaldo profesional. Con estas oportunidades de educación continua, Vetcap se compromete
      a impulsar la excelencia en la práctica veterinaria en la República Dominicana.
      </strong>
    </p>
    <p style="font-family:Helvetica;"><strong>¡Prepárate para ser parte de una experiencia educativa única y con certificación reconocida!</strong></p>
  </div>
</section>
<div class="vetcap-partners">
    <div class="vetcap-partner-logos">
      <h2 style="font-family:HelveticaBold;" class="vetcap-partners-title">NUESTROS SPONSORS</h2>
      <img style="max-height:50px;" src="./assets/img/espavet_white_logo.png" alt="ESPAVET" />
      <img style="max-height:50px;" src="./assets/img/vibix_white_logo.png" alt="VIBIX" />
      <img style="max-height:50px;" src="./assets/img/mallen_white_logo.png" alt="MALLÉN MASCOTAS" />
      <img style="max-height:50px;" src="./assets/img/animal_food_line-white_logo.png" alt="ANIMAL FOOD LINE" />
      <img style="max-height:50px;" src="./assets/img/noctua_group_white_logo.png" alt="NOCTUA GROUP" />
      <img style="max-height:50px;" src="./assets/img/colegio-white-logo.png" alt="COLEGIO DE MEDICOS" />
      <img style="max-height:50px;" src="./assets/img/vetboca-white-logo.png" alt="VETBOCA" />
      <img style="max-height:50px;" src="./assets/img/patas-parriba-white-logo.png" alt="PATAS PARRIBA" />
      <img style="max-height:50px;" src="./assets/img/ccoagro-white-logo.png" alt="CCOAGRO" />
    </div>
  </div>




  <section class="slider-capacitaciones-section">
  <h1 class="title">Diplomados</h1>
  <?php
    renderDiplomadosSliderWithoutPayments($diplomados);
   ?>
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

<!-- <section class="call-to-action-section">
  <div class="cta-content">
    <div class="image-container">
      <img src="./assets/img/ellos_te_necesitan.png" alt="Animals" class="cta-image" />
    </div>
    <div class="text-container">
      <h1 class="cta-title">ELLOS TE NECESITAN</h1>
      <p class="cta-quote">
        "CAPACITARTE HOY ES EL PRIMER PASO PARA SER EL VETERINARIO QUE EL MUNDO
        NECESITA MAÑANA."
      </p>
      <p class="cta-hashtag">#VETERINARIOSUNIDOS</p>
      <button class="cta-button">LEER ARTÍCULO</button>
    </div>
  </div>
</section> -->

<script src="./assets/js/capacitacionesSlider.js"></script>
<script src="./assets/js/counterCapacitaciones.js"></script>

      
<?php 
//include header template
require('layout/footer.php'); 
?>