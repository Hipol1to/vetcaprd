<?php
      require_once('includes/config.php');
      require('layout/header.php'); 
      $diplomados = getAllCourses($db);
       ?>
<section class="vetcap-education-section">
  <div class="vetcap-header">
    <h1 style="margin-bottom: 0px !important;" class="vetcap-title">CURSOS<br>TALLERES &<br>DIPLOMADOS</h1>
    <div class="vetcap-logos">
      <img src="./assets/img/vetcap_logo_normal.png" alt="Fundación Vetcap" class="vetcap-logo" />
      <img src="./assets/img/colegio_de_medicos_logo.png" alt="COLVET" class="vetcap-logo" />
    </div>
  </div>
  <br>
  <br>
  <div class="vetcap-description">
    <p>
      Vetcap estará organizando una amplia variedad de diplomados, cursos y talleres diseñados
      para fortalecer el conocimiento y las habilidades de profesionales y estudiantes en el ámbito veterinario.
      Cada programa cuenta con el aval oficial del Colegio Médico Veterinario (COLVET), lo que asegura una formación
      de alta calidad y con respaldo profesional. Con estas oportunidades de educación continua, Vetcap se compromete
      a impulsar la excelencia en la práctica veterinaria en la República Dominicana.
    </p>
    <p><strong>¡Prepárate para ser parte de una experiencia educativa única y con certificación reconocida!</strong></p>
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
<section class="call-to-action-section">
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
</section>

<script src="./assets/js/capacitacionesSlider.js"></script>
<script src="./assets/js/counterCapacitaciones.js"></script>

      
<?php 
//include header template
require('layout/footer.php'); 
?>