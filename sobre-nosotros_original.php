<?php
      require('layout/header.php'); 
       ?>



<section class="vetcap-banner-section">
  <div class="vetcap-banner-container">
    <div class="vetcap-left">
      <div class="vetcap-title-nosotros-container">
        <img src="./assets/img/bee-logo.png" alt="Vetcap Bee Logo" class="vetcap-bee-logo">
        <h1 class="vetcap-title-nosotros"><span class="vetcap-title-nosotros-line1">VET</span><br><span class="vetcap-title-nosotros-line2">CAP</span></h1>
      </div>
      <h2 class="vetcap-subtitle">#LACASADELOSVETS</h2>
    </div>
    <div class="vetcap-right">
      <img src="./assets/img/circle-collage.png" alt="Vetcap Circular Image" class="vetcap-circle-img">
    </div>
  </div>
</section>

<style>
 .vetcap-title-nosotros-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}
.vetcap-bee-logo {
  height: 180px;
  margin-bottom: 0;
}
.vetcap-title-nosotros {
  font-family: 'Horizon', sans-serif;
  font-size: 48px;
  color: #FFFFFF;
  line-height: 0.5;
}
.vetcap-title-nosotros-line1, .vetcap-title-nosotros-line2 {
  display: block;
}
.vetcap-title-nosotros-line1, .vetcap-title-nosotros-line2 {
  display: block;
}
.vetcap-banner-section {
  background-color: #2D4A2A;
  display: flex;
  justify-content: center;
  padding: 40px 20px;
}
.vetcap-banner-container {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  width: 100%;
}
.vetcap-left {
  flex: 1;
  padding-right: 20px;
}
.vetcap-right {
  flex: 1;
  display: flex;
  justify-content: flex-end;
}
.vetcap-bee-logo {
  height: 180px;
  margin-bottom: 20px;
}
.vetcap-title-nosotros {
  font-family: 'Horizon', sans-serif;
  font-size: 6rem;
  color: #FFFFFF !important;
}
.vetcap-subtitle {
  font-family: 'Helvetica';
  font-size: 3rem;
  font-weight: bold;
  color: #FFFFFF !important;
  margin-bottom: 20px;
}
.vetcap-description {
  font-family: 'Helvetica', sans-serif;
  font-size: 16px;
  color: #FFFFFF !important;
  line-height: 1.5;
}
.vetcap-circle-img {
  max-width: 400px;
  height: auto;
  border-radius: 50%;
}

@media (max-width: 768px) {
  .vetcap-banner-container {
    flex-direction: column;
    text-align: center;
  }
  .vetcap-left, .vetcap-right {
    flex: none;
    padding: 0;
  }
  .vetcap-title-nosotros {
    font-size: 36px;
  }
  .vetcap-subtitle {
    font-size: 20px;
  }
  .vetcap-circle-img {
    max-width: 100%;
    margin-top: 20px;
  }
}
</style>






<style>
.vetcap-section-unique {
  background-color:rgb(255, 255, 255);
  color: white;
  padding: 2rem;
  font-family: 'Helvetica', sans-serif;
}
.vetcap-title-unique {
  margin-bottom: 2%;
  color: #2D4A2A;
  font-family: 'Horizon', sans-serif;
  font-size: 2.5rem;
  font-weight: bold;
}
.vetcap-description-unique {
  font-family: 'Helvetica', sans-serif;
  color:rgb(0, 0, 0);
  margin-top: 1rem;
  font-size: 1.3rem;
  line-height: 1;
}
.vetcap-grid-unique {
  margin-top: 2rem;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  text-align: center;
}
.vetcap-grid-item-unique {
  font-family: 'Horizon', sans-serif;
  color: #2D4A2A;
  font-size: 2rem;
  font-weight: bold;
}
.vetcap-grid-item-unique p {
  font-size: 0.9rem;
  margin-top: 0.5rem;
}
.vetcap-contact-unique {
    color:rgb(0, 0, 0);
  margin-top: 2rem;
  font-size: 0.9rem;
}
.text-green-unique { color:rgb(0, 0, 0); }
.text-yellow-unique { color: #E69138; }

@media (min-width: 768px) {
  .vetcap-section-unique {
    padding: 3rem;
  }
  .vetcap-title-unique {
    font-size: 3rem;
  }
  .vetcap-grid-unique {
    grid-template-columns: repeat(4, 1fr);
  }
}
</style>

<section class="vetcap-section-unique">
  <h1 class="vetcap-title-unique">#THIS<span class="text-yellow-unique">IS</span>VETCAP</h1>
  <p class="vetcap-description-unique">La Fundación Vetcap se dedica a la capacitación y formación de profesionales y estudiantes de medicina veterinaria, utilizando una amplia gama de metodologías educativas para fortalecer y enriquecer su conocimiento en el campo. Nos enfocamos en el desarrollo integral de habilidades y competencias, ofreciendo una educación innovadora que integra diversas técnicas pedagógicas y un enfoque altamente profesional. Nuestro compromiso es proporcionar una formación de calidad que prepare a nuestros participantes para enfrentar los desafíos del ámbito veterinario con confianza y excelencia.</p>
  <p class="vetcap-description-unique">Al respaldar nuestra labor, contribuyen directamente al desarrollo intelectual y profesional de los médicos veterinarios en la República Dominicana, fortaleciendo el sector veterinario en el país. Su apoyo crea oportunidades de crecimiento tanto profesional como personal para aquellos veterinarios con recursos limitados, reflejando un firme compromiso social y humano. Más allá de la visibilidad comercial, esta colaboración fomenta una conexión auténtica con la comunidad, promoviendo empatía y reconocimiento genuinos hacia las marcas involucradas. A través de nuestros eventos nacionales, ofrecemos una plataforma efectiva para la promoción de marcas, asegurando una exposición destacada. Los participantes y asistentes a nuestras actividades actúan como embajadores naturales, difundiendo las marcas tanto de manera directa como indirecta.</p>
  <div class="vetcap-grid-unique">
    <div class="vetcap-grid-item-unique">+500<p class="text-green-unique">PARTICIPANTES IMPACTADOS</p></div>
    <div class="vetcap-grid-item-unique">+1M<p class="text-green-unique">IMPRESIONES <span class="text-yellow-unique">EN REDES</span></p></div>
    <div class="vetcap-grid-item-unique">+15<p class="text-green-unique">EVENTOS <span class="text-yellow-unique">VETERINARIOS</span></p></div>
    <div class="vetcap-grid-item-unique">+50<p class="text-green-unique">CHARLAS <span class="text-yellow-unique">IMPARTIDAS</span></p></div>
  </div>
  <p class="vetcap-contact-unique">Contactanos: info@vetcaprd.com / +1 (809) 344-5048</p>
</section>




<div class="promo-bar">
    
  <div class="hashtag-section">
    <h2>LOBO CORPORATION | FUNDACIÓN VETCAP</h2>
  </div>
  <div class="text-section">
    <div class="collectionn-title">HIVE <a style="color:white;">& HOWL</a></div>
  </div>
  <div class="image-section">
    <img width="50px" src="./assets/img/icons/lobo-icon-white.png" alt="Cap image">
    <img width="50px" src="./assets/img/icons/bee-icon-white.png" alt="Cap image">
  </div>
  <div class="button-section">
    <button class="rounded-button">SHOP NOW</button>
  </div>
</div>



      
<?php 
//include header template
require('layout/footer.php'); 
?>