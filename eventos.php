<?php
  require_once('includes/config.php');
  require('layout/header2.php'); 
  $eventos = getAllEvents($db);
  $nextEvent = $_SESSION['nextEvent'];
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="en"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Proximo Evento, Eventos Futuros​">
    <meta name="description" content="">
    <title>Eventos</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Eventos.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <link rel="stylesheet" href="indexcapa.css" media="screen">
    <meta name="generator" content="Nicepage 7.5.2, nicepage.com">
    <style>
     footer p {
    font-family: "HelveticaBold";
    color: white; 
    font-size: 16px;
    line-height: 30px;
    margin-bottom: 15px;
    font-weight: 150;
    line-height: 1.6;
}
    </style>
    
    
    
    
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Eventos">
    <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
  <body data-path-to-root="./" data-include-products="true" class="u-body u-xl-mode" data-lang="en"><header class="u-clearfix u-header u-header" id="header"><div class="u-clearfix u-sheet u-valign-middle-xs u-sheet-1">
        <nav class="u-menu u-menu-one-level u-offcanvas u-menu-1">
          <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px;">
            <a class="u-button-style u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-top-bottom-menu-spacing u-hamburger-link u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base u-hamburger-link-1" href="#">
              <svg class="u-svg-link" viewBox="0 0 24 24"><use xlink:href="#menu-hamburger"></use></svg>
              <svg class="u-svg-content" version="1.1" id="menu-hamburger" viewBox="0 0 16 16" x="0px" y="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><g><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
</g></svg>
            </a>
          </div>
          <div class="u-custom-menu u-nav-container">
            <ul class="u-nav u-unstyled u-nav-1"><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="capacitaciones.php" style="padding: 10px 22px;">Capacitaciones</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="eventos.php" style="padding: 10px 22px;">Eventos</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="patrocinadores.php" style="padding: 10px 22px;">Patrocinadores</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="sobre-nosotros.php" style="padding: 10px 22px;">Sobre Nosotros</a>
</li><li class="u-nav-item"><div style="float: right; display: flex; flex-wrap: nowrap; gap: 10%;">
                        <a href="./VetCapMembers/login.php"><img src="./assets/img/icons/user-black-icon.png" alt="" width="20px" />
                        <a id="theUserr" style="display: block; margin-left: -8.5px; margin-top: 4px; font-size:20px; white-space: nowrap; color: black; font-family: Helvetica" href="./VetCapMembers/login.php"><?php if (isset($_SESSION['name'])) {echo htmlspecialchars($_SESSION['name']); } else {echo 'Iniciar sesión';} ?></a></a>
                    </div>
</li></ul>
          </div>
          <div class="u-custom-menu u-nav-container-collapse">
            <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
              <div class="u-inner-container-layout u-sidenav-overflow">
                <div class="u-menu-close"></div>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="capacitaciones.php">Capacitaciones</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="eventos.php">Eventos</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="patrocinadores.php">Patrocinadores</a>
</li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="sobre-nosotros.php">Sobre Nosotros</a>
</li><li class="u-nav-item"><div style="float: right; display: flex; flex-wrap: nowrap; gap: 10%;">
                        <a href="./VetCapMembers/login.php"><img src="./assets/img/icons/white/user-white-icon.png" alt="" width="20px" />
                        <a id="theUserr" style="display: block; margin-left: -8.5px; margin-top: 4px; font-size:20px; white-space: nowrap; color: white; font-family: Helvetica" href="./VetCapMembers/login.php"><?php if (isset($_SESSION['name'])) {echo htmlspecialchars($_SESSION['name']); } else {echo 'Iniciar sesión';} ?></a></a>
                    </div>
</li></ul>
              </div>
            </div>
            <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
          </div>
        </nav>
        <img class="u-image u-image-contain u-image-default u-image-1" src="images/3.png" alt="" data-image-width="1918" data-image-height="720" data-href="./" data-page-id="72255026" title="LandingPage">
      </div></header>
    <section class="u-clearfix u-section-1" id="block-6">
      <h1 class="u-custom-font u-text u-text-custom-color-1 u-text-default u-title u-text-1">Proximo <span class="u-text-custom-color-3">Evento</span>
      </h1>
      <div class="container">
          <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
              <div class="about-img about-img1">
                <img src="https://www.vetcaprd.com//<?php  echo str_replace("../", "", $nextEvent['foto_evento']);; ?>" alt="" class="event-pic"/>
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
        





        <section class="u-align-center u-clearfix u-container-align-center u-valign-middle u-section-4" id="block-4">
      <div class="u-carousel u-expanded-width u-gallery u-gallery-slider u-layout-carousel u-lightbox u-no-transition u-show-text-on-hover u-gallery-1" id="carousel-2023" data-interval="750" data-u-ride="carousel" data-pause="false">
        <ol class="u-absolute-hcenter u-carousel-indicators u-carousel-indicators-1">
          <li data-u-target="#carousel-2023" data-u-slide-to="0" class="u-active u-shape-circle" style="width: 10px; height: 10px;"></li>
          <li data-u-target="#carousel-2023" data-u-slide-to="1" class="u-shape-circle" style="width: 10px; height: 10px;"></li>
        </ol>
        <div class="u-carousel-inner u-gallery-inner" role="listbox">
          <div class="u-active u-carousel-item u-effect-fade u-gallery-item u-carousel-item-1" data-href="https://mallenmascotas.com/" data-target="_blank">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="images/Banner-MM-VETCAP-1900x200_px.png">
            </div>
            <div class="u-align-center u-over-slide u-shading u-valign-bottom u-over-slide-1"></div>
          </div>
          <div class="u-carousel-item u-effect-fade u-gallery-item u-carousel-item-2">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="images/banners-MMMesadetrabajo1300x.png">
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







      <div class="u-border-1 u-border-custom-color-3 u-expanded-width u-line u-line-horizontal u-line-1"></div>
      <h1 class="u-custom-font u-text u-text-custom-color-1 u-text-default u-title u-text-2">Eventos Futuros </h1>
      <br>
      <?php

printAllEvents($eventos);

?>
    </section>
    
    
    <section class="u-align-center u-clearfix u-container-align-center u-valign-middle u-section-4" id="block-4">
      <div class="u-carousel u-expanded-width u-gallery u-gallery-slider u-layout-carousel u-lightbox u-no-transition u-show-text-on-hover u-gallery-1" id="carousel-2023" data-interval="750" data-u-ride="carousel" data-pause="false">
        <ol class="u-absolute-hcenter u-carousel-indicators u-carousel-indicators-1">
          <li data-u-target="#carousel-2023" data-u-slide-to="0" class="u-active u-shape-circle" style="width: 10px; height: 10px;"></li>
          <li data-u-target="#carousel-2023" data-u-slide-to="1" class="u-shape-circle" style="width: 10px; height: 10px;"></li>
        </ol>
        <div class="u-carousel-inner u-gallery-inner" role="listbox">
          <div class="u-active u-carousel-item u-effect-fade u-gallery-item u-carousel-item-1" data-href="https://mallenmascotas.com/" data-target="_blank">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="images/Banner-MM-VETCAP-1900x200_px.png">
            </div>
            <div class="u-align-center u-over-slide u-shading u-valign-bottom u-over-slide-1"></div>
          </div>
          <div class="u-carousel-item u-effect-fade u-gallery-item u-carousel-item-2">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="images/banners-MMMesadetrabajo1300x.png">
            </div>
            <div class="u-align-center u-over-slide u-shading u-valign-bottom u-over-slide-2">
              <h3 class="u-gallery-heading">Sample Title</h3>
              <p class="u-gallery-text">Sample Text</p>
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
    <footer class="u-align-center u-clearfix u-container-align-center u-custom-color-1 u-footer u-footer" id="footer"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-1" src="images/logodeVETCAP2025.png" alt="" data-image-width="320" data-image-height="320"><p class="u-custom-font u-text u-text-1">Principal Partner</p><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-2" src="images/31.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-3" src="images/21.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-4" src="images/12.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-5" src="images/4.png" alt="" data-image-width="500" data-image-height="500"><p class="u-custom-font u-text u-text-2">Official Partner</p><p class="u-custom-font u-text u-text-custom-color-3 u-text-3"> Contáctanos</p><a href="" class="u-active-none u-align-center u-btn u-btn-rectangle u-button-style u-hover-none u-none u-btn-1">
        <span class="u-icon"><svg class="u-svg-content" viewBox="0 0 405.333 405.333" x="0px" y="0px" style="width: 1em; height: 1em;"><path d="M373.333,266.88c-25.003,0-49.493-3.904-72.704-11.563c-11.328-3.904-24.192-0.896-31.637,6.699l-46.016,34.752    c-52.8-28.181-86.592-61.952-114.389-114.368l33.813-44.928c8.512-8.512,11.563-20.971,7.915-32.64    C142.592,81.472,138.667,56.96,138.667,32c0-17.643-14.357-32-32-32H32C14.357,0,0,14.357,0,32    c0,205.845,167.488,373.333,373.333,373.333c17.643,0,32-14.357,32-32V298.88C405.333,281.237,390.976,266.88,373.333,266.88z"></path></svg></span>&nbsp;​+1 (809) 344-5048
      </a><a href="mailto:info@vetcaprd.com" class="u-active-none u-btn u-btn-rectangle u-button-style u-hover-none u-none u-text-white u-btn-2">
        <span class="u-icon u-text-white"><svg class="u-svg-content" viewBox="0 0 24 16" x="0px" y="0px" style="width: 1em; height: 1em;"><path fill="currentColor" d="M23.8,1.1l-7.3,6.8l7.3,6.8c0.1-0.2,0.2-0.6,0.2-0.9V2C24,1.7,23.9,1.4,23.8,1.1z M21.8,0H2.2
	c-0.4,0-0.7,0.1-1,0.2L10.6,9c0.8,0.8,2.2,0.8,3,0l9.2-8.7C22.6,0.1,22.2,0,21.8,0z M0.2,1.1C0.1,1.4,0,1.7,0,2V14
	c0,0.3,0.1,0.6,0.2,0.9l7.3-6.8L0.2,1.1z M15.5,9l-1.1,1c-1.3,1.2-3.6,1.2-4.9,0l-1-1l-7.3,6.8c0.2,0.1,0.6,0.2,1,0.2H22
	c0.4,0,0.6-0.1,1-0.2L15.5,9z"></path></svg></span>&nbsp;info@vetcaprd.com
      </a><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-6" src="images/9.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-7" src="images/5.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-8" src="images/7.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-9" src="images/8.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-10" src="images/6.png" alt="" data-image-width="500" data-image-height="500"><div class="u-border-2 u-border-white u-expanded-width-xs u-line u-line-horizontal u-line-1"></div><p style="font-family:Helvetica" class="u-custom-font u-text u-text-4"> Copyright ® 2025 EncioSystems Inc. Todos los derechos reservados.</p></footer>
    
  
</body></html>