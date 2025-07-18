<?php
    require_once('includes/config.php');
      require('layout/header2.php'); 
       ?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="en"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Partners">
    <meta name="description" content="">
    <title>Patrocinadores</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Patrocinadores.css" media="screen">
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
    <meta property="og:title" content="Patrocinadores">
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
    <section class="u-clearfix u-section-1" id="sec-1287">
      <h1 class="u-align-center u-custom-font u-text u-text-custom-color-1 u-text-default u-title u-text-1">Patrocinadores&nbsp;</h1>
      <p class="u-align-center u-text u-text-2"> Estamos orgullosos de contar con una lista diversa de empresas nacionales e internacionales como parte de Vetcap. Trabajamos en estrecha colaboración con nuestros socios comerciales para brindar la mejor experiencia de educación y entretenimiento veterinario del país para todos. Implementamos una amplia gama de ideas y soluciones creativas durante las activaciones de patrocinadores que comparten la visión, el tono y el compromiso de convertirlo en un mejor veterinario.</p>
      <div class="custom-partners-logos">
        <img src="./assets/img/color-logos/espavet-logo.png" alt="ESPAVET" class="custom-partner-logo">
        <img src="./assets/img/color-logos/vibix-logo.png" alt="Vibix" class="custom-partner-logo">
        <img src="./assets/img/color-logos/mallen-logo.png" alt="Mallén Mascotas" class="custom-partner-logo">
        <img src="./assets/img/color-logos/animal-food-line-logo.png" alt="Animal Food Line" class="custom-partner-logo">
        <img style="max-width: 60px;" src="./assets/img/color-logos/colegio-de-medicos-veterinarios-logo.png" alt="VetBoca" class="custom-partner-logo">
        <img src="./assets/img/color-logos/patas-parriba-logo.png" alt="Noctua Group" class="custom-partner-logo">
        <img src="./assets/img/color-logos/ccoagro-logo.png" alt="Noctua Group" class="custom-partner-logo">
        <img src="./assets/img/color-logos/noctua-logo.png" alt="Noctua Group" class="custom-partner-logo">
        <img src="./assets/img/color-logos/vetboca-logo.png" alt="VetBoca" class="custom-partner-logo">
    </div>
    </section>
    <br>
    
    

   
    <br>


    <section class="partners-section">
    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/main-logos/carval-main-logo.png" alt="Carval Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title" style="color: #024d5a; font-family:Horizon">GRUPO CARVAL <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR PRINCIPAL</span></div>
            <div class="partner-desc">
            Carval es una organización comprometida con asegurar el bienestar de los seres vivos, ofreciendo soluciones integrales que satisfacen las necesidades de sus grupos de interés a través de la innovación y la excelencia en el servicio. Dentro de su portafolio de productos, Carval ofrece la línea de vacunas Vibix, diseñada para proteger a perros y gatos contra diversas enfermedades. Estas vacunas se adaptan a las necesidades individuales de cada mascota, sin importar su historia o procedencia.
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/relatos_carval/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://carvalcorp.com/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/main-logos/espavet-main-logo.png" alt="Espavet Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">ESPAVET SRL <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR PRINCIPAL</span></div>
            <div class="partner-desc">
            Espavet S.R.L. es una empresa ubicada en Santo Domingo, República Dominicana, que se especializa en la distribución de productos veterinarios, equipos y medicamentos para animales. Ofrecen una amplia gama de productos destinados al cuidado y bienestar de las mascotas y animales de granja. Un ejemplo es NexGard es una reconocida marca de antiparasitarios para perros, conocida por sus tabletas masticables que eliminan pulgas y garrapatas. 
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/espavet.rd/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://www.instagram.com/espavet.rd/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/main-logos/mallen-main-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">MALLÉN MASCOTAS <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR PRINCIPAL</span></div>
            <div class="partner-desc">
            Mallén Mascotas es una división de Mallén Veterinaria, parte del Grupo Mallén, una empresa con más de 50 años de experiencia en la representación, distribución y promoción de productos farmacéuticos y cosméticos en la República Dominicana. Desde 1995, Mallén Veterinaria se ha dedicado a mejorar la salud y el bienestar de los animales, ofreciendo un amplio portafolio de marcas internacionales reconocidas por su investigación y desarrollo de alta calidad.
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/mallenmascotasrd/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://mallenmascotas.com/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/main-logos/animal-foodline-main-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">ANIMAL FOOD LINE <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR PRINCIPAL</span></div>
            <div class="partner-desc">
            Animal Food Line S.A. es una empresa ubicada en Santo Domingo, República Dominicana, dedicada a la distribución de productos alimenticios para animales. Fundada en 1995, se especializa en la comercialización de alimentos y suministros para mascotas, así como productos relacionados con la nutrición animal. 
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/animalfoodline/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://www.instagram.com/animalfoodline/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img style="max-width: 50%;" src="./assets/img/color-logos/main-logos/colegio-main-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">COLVET <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR OFICIAL</span></div>
            <div class="partner-desc">
            El Colegio Dominicano de Médicos Veterinarios (Colvet) es una institución sin fines de lucro fundada en octubre de 2002, mediante la Ley 173-02. Su misión es regular y promover el ejercicio profesional de la medicina veterinaria en la República Dominicana, estableciendo normas de conducta y eficiencia para garantizar una práctica ética y profesional.
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/colvetcolvet/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://www.instagram.com/colvetcolvet/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/main-logos/vetboca-main-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">VETBOCA <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR OFICIAL</span></div>
            <div class="partner-desc">
            Vetboca es una clínica veterinaria ubicada en la Calle Independencia #25, frente a Vimenpaq, en Santiago de los Caballeros, República Dominicana. Ofrecen una variedad de servicios para el cuidado de mascotas, tales como consultas veterinarias, vacunaciones, desparasitaciones, peluquería y estética para perros y gatos, así como psicología canina para abordar comportamientos y necesidades emocionales de los animales. 
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/vetbocard/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://www.instagram.com/vetbocard/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/ccoagro-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">CCOAGRO <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR OFICIAL</span></div>
            <div class="partner-desc">
            CCOAGRO (Comercializadora y Consultoría Agropecuaria Folipasto S.R.L.) es una empresa dominicana dedicada a la distribución de insumos, equipos y soluciones para el sector agropecuario. Su misión es apoyar el desarrollo agrícola y ganadero en el país mediante la comercialización de productos de alta calidad y la prestación de servicios de consultoría especializada.
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/ccoagro.rd/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://www.instagram.com/ccoagro.rd/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/patas-parriba-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">PATAS PA'RRIBA <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR OFICIAL</span></div>
            <div class="partner-desc">
            Patas Pa'rriba - Pet Social Club es un centro integral para mascotas ubicado en Santiago, República Dominicana. Ofrece servicios como Pet Hotel, Dog Park y Day Care, proporcionando espacios diseñados para el esparcimiento y cuidado de las mascotas. Su equipo de profesionales amantes de los animales garantiza atención personalizada.
            </div>
            <div class="icons">
                <a target="_blank" href="https://www.instagram.com/patasparriba_rd/"><img src="./assets/img/icons/ig-icon-black.png" alt="Instagram"></a>
                <a target="_blank" href="https://www.instagram.com/patasparriba_rd/"><img src="./assets/img/icons/web-icon-black.png" alt="Website"></a>
            </div>
        </div>
    </div>

    <div class="partner-card">
        <div class="partner-logo">
            <img src="./assets/img/color-logos/noctua-logo.png" alt="Mallen Mascotas Logo">
        </div>
        <div class="partner-info">
            <div class="partner-title">NOCTUA GROUP <span class="partner-title-small-text" style="color: black;">/ PATROCINADOR OFICIAL</span></div>
            <div class="partner-desc">
            Noctua Group es una empresa especializada en consultoría estratégica y desarrollo de proyectos con un enfoque innovador y sostenible. Su misión es brindar soluciones integrales a empresas y organizaciones a través de asesorías especializadas, optimización de procesos y gestión eficiente de recursos. Con una visión centrada en la innovación y la excelencia, Noctua Group trabaja en diversas industrias, ofreciendo estrategias personalizadas que impulsan el crecimiento y la competitividad de sus clientes.
            </div>
            <div class="icons">
                <img src="./assets/img/icons/ig-icon-black.png" alt="Instagram">
                <img src="./assets/img/icons/web-icon-black.png" alt="Website">
            </div>
        </div>
    </div>
</section>

<br>


<section class="u-align-center u-clearfix u-container-align-center u-valign-middle u-section-4" id="block-4">
      <div class="u-carousel u-expanded-width u-gallery u-gallery-slider u-layout-carousel u-lightbox u-no-transition u-show-text-on-hover u-gallery-1" id="carousel-2023" data-interval="2750" data-u-ride="carousel" data-pause="false">
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
          <!-- <div class="u-carousel-item u-effect-fade u-gallery-item u-carousel-item-2">
            <div class="u-back-slide" data-image-width="7917" data-image-height="834">
              <img class="u-back-image u-expanded" src="images/banners-MMMesadetrabajo1300x.png">
            </div>
            <div class="u-align-center u-over-slide u-shading u-valign-bottom u-over-slide-2">
              <h3 class="u-gallery-heading">Sample Title</h3>
              <p class="u-gallery-text">Sample Text</p>
            </div>
          </div> -->
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
      </a><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-6" src="images/9.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-7" src="images/5.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-8" src="images/7.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-9" src="images/8.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-10" src="images/6.png" alt="" data-image-width="500" data-image-height="500"><div class="u-border-2 u-border-white u-expanded-width-xs u-line u-line-horizontal u-line-1"></div><p style="font-family:Helvetica" class="u-custom-font u-text u-text-4"> <a style="font-family:Helvetica; color:white;" href="https://enciosystems.com/">Copyright ® 2025 EncioSystems Inc. Todos los derechos reservados.</a></p></footer>
    
  
</body></html>