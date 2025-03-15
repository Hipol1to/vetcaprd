      <?php
      require_once('includes/config.php');
      require('layout/header.php'); 
      $eventosList = [["modalName", 0]];
      $eventos = getAllEvents($db);
      $nextEvent = $_SESSION['nextEvent'];
       ?>
      <section class="slider-area-001 position-relative" style="">
  <div class="slider-active-001">
    <div class="slider-item-001 hero-overly slider-bg-001 slider-heighto active-001" style="height: 55vh;">
      <div class="container-001">
        <div class="centered-container-001">
          <h2 class="responsive-title" style="color:white;">
                Vetcap está hecho por <br> los
                <a style="color:orange;">veterinarios</a> para los <br> veterinarios
              </h2>
         <a
                href="./sobre-nosotros.html"
                class="btn_1 hero-btn"
                data-animation="fadeInUp"
                data-delay=".8s"
                tabindex="0"
                style="animation-delay: 0.8s"
                >Sobre nosotros</a
              >
        </div>
      </div>
    </div>
    <div class="slider-item-001 hero-overly slider-heighto slider-bg-002" style="height: 55vh;">
      <div class="container-001">
        <div class="centered-container-001">
          <h2 class="responsive-title" style="color:white;">
                Vetcap está hecho por <br> los
                <a style="color:orange;">veterinarios</a> para los <br> veterinarios
              </h2>
         <a
                href="./sobre-nosotros.html"
                class="btn_1 hero-btn"
                data-animation="fadeInUp"
                data-delay=".8s"
                tabindex="0"
                style="animation-delay: 0.8s"
                >Sobre nosotros</a
              >
        </div>
      </div>
    </div>
    <div class="slider-item-001 hero-overly slider-heighto slider-bg-002" style="height: 55vh;">
      <div class="container-001">
        <div class="centered-container-001">
          <h2 class="responsive-title" style="color:white;">
                Vetcap está hecho por <br> los
                <a style="color:orange;">veterinarios</a> para los <br> veterinarios
              </h2>
         <a
                href="./sobre-nosotros.html"
                class="btn_1 hero-btn"
                data-animation="fadeInUp"
                data-delay=".8s"
                tabindex="0"
                style="animation-delay: 0.8s"
                >Sobre nosotros</a
              >
        </div>
      </div>
    </div>
    <div class="slider-item-001 hero-overly slider-heighto slider-bg-002" style="height: 55vh;">
      <div class="container-001">
        <div class="centered-container-001">
          <h2 class="responsive-title" style="color:white;">
                Vetcap está hecho por <br> los
                <a style="color:orange;">veterinarios</a> para los <br> veterinarios
              </h2>
         <a
                href="./sobre-nosotros.html"
                class="btn_1 hero-btn"
                data-animation="fadeInUp"
                data-delay=".8s"
                tabindex="0"
                style="animation-delay: 0.8s"
                >Sobre nosotros</a
              >
        </div>
      </div>
    </div>
  </div>
  <div class="slider-dots-001"></div>
</section>
<div class="scrolling-bar">
  <div class="scrolling-images">
  <img src="./assets/img/lobo-promo.png" alt="Image 2">  
  <img src="./assets/img/follow-us-promo.png" alt="Image 1">
    <img src="./assets/img/nuestros-sponsors-promo.png" alt="Image 3">
    <img src="./assets/img/mallen-promo.png" alt="Image 4">
    <img src="./assets/img/vibix-promo.png" alt="Image 5">
    <!-- Duplicate images for seamless loop -->
    <img src="./assets/img/follow-us-promo.png" alt="Image 1">
    <img src="./assets/img/lobo-promo.png" alt="Image 2">
    <img src="./assets/img/nuestros-sponsors-promo.png" alt="Image 3">
    <img src="./assets/img/mallen-promo.png" alt="Image 4">
    <img src="./assets/img/vibix-promo.png" alt="Image 5">
  </div>
</div>


    <section style="padding-top: 30px; padding-bottom: 10px;" class="about-area section-bg section-padding">
        <h2 style="font-size: 50px; font-family: Horizon; text-align: center; color: #2d4a34; margin-bottom: 0%;">PROXIMO EVENTO</h2>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
              <div class="about-img about-img1">
                <img src="http://localhost/vesca/<?php  echo str_replace("../", "", $nextEvent['foto_evento']);; ?>" alt="" class="event-pic"/>
              </div>
            </div>
            <div
              class="offset-xl-1 offset-lg-0 offset-sm-1 col-xxl-5 col-xl-5 col-lg-6 col-md-9 col-sm-11"
            >
              <div class="about-caption about-caption1">
                <div class="section-tittle m-0">
                  <!-- second section !-->
                  <!-- <img src="./assets/img/centro_de_cultura_logo.png" style="width: 300px;" alt=""> -->
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

<section class="vetone-section">
    <div class="vetone-left-container">
      <img class="vetone-left-image" src="./assets/img/vetone-piccc.png" alt="Group studying">
    </div>
    <div class="vetone-right-container">
      <h2 style="font-size: -10%;" class="vetone-right-headinga">AMAMOS</h2>
      <h2 class="vetone-right-heading">NUESTROS</h2>
      <h2 class="vetone-right-heading">PARTNERS</h2>
      <p style="color: black;" class="vetone-right-description">
      Conoce a quienes hacen esto posible:
      </p>
      <br>
      <img class="vetone-right-logo" src="./assets/img/color-logos/vibix-logo.png" alt="Vet One Logo"> <img style="margin-left: 50px;" class="vetone-right-logo" src="./assets/img/color-logos/espavet-logo.png" alt="Vet One Logo">
      <br>
      <img class="vetone-right-logo" src="./assets/img/color-logos/mallen-logo.png" alt="Vet One Logo"> <img style="margin-left: 50px;" class="vetone-right-logo" src="./assets/img/color-logos/animal-food-line-logo.png" alt="Vet One Logo">
      <hr style="height: 3px;
    width: 75%;
    color: #1d351d;">
      <img style="margin-left: 25px;" class="vetone-right-logowrr" src="./assets/img/color-logos/colegio-de-medicos-veterinarios-logo.png" alt="Vet One Logo"> <img style="margin-left: 25px;" class="vetone-right-logowr" src="./assets/img/color-logos/patas-parriba-logo.png" alt="Vet One Logo">
      <img style="margin-left: 20px;" class="vetone-right-logowr" src="./assets/img/color-logos/ccoagro-logo.png" alt="Vet One Logo"> 
      <br>
      <img style="margin-left: 50px;" class="vetone-right-logowr" src="./assets/img/color-logos/vetboca-logo.png" alt="Vet One Logo">  <img style="margin-left: 50px;" class="vetone-right-logowr" src="./assets/img/color-logos/noctua-logo.png" alt="Vet One Logo">
      <br>
    </div>
  </section>
  <section style="margin-bottom:0%" class="custom-follow-section">
    <div class="custom-follow-container">
        <p class="custom-follow-title">
            SIGUE<span class="custom-highlight">NOS</span>
</p>
<div class="custom-follow-text-container">
    <p class="custom-follow-text">No te pierdas de nada de lo que hacemos</p>
    <div class="custom-follow-arrow">-----------------------------------------------------------------------------&gt;</div>
</div>
        <div class="custom-social-icons">
            <img src="./assets/img/tiktok_logo.png" alt="TikTok" class="custom-social-icon">
            <img src="./assets/img/instagram_logo.png" alt="Instagram" class="custom-social-icon">
            <img src="./assets/img/youtube_logo.png" alt="YouTube" class="custom-social-icon">
            <span class="custom-social-handle">@vetcaprd</span>
        </div>
    </div>
</section>




<style>
  .scrolling-bar {
    width: 100%;
    height: 100px; /* Adjust based on your image height */
    overflow: hidden;
    position: relative;
    background-color: black;
  }

  .scrolling-images {
    display: flex;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    white-space: nowrap; /* Ensure images stay in one line */
  }

  .scrolling-images img {
    height: 100%;
    width: auto;
    flex-shrink: 0;
  }
</style>
  <?php 
//include header template
require('layout/footer.php'); 
?>