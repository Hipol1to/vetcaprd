</main>
<script>
  const scrollingImages = document.querySelector('.scrolling-images');
  let position = 0;
  const scrollSpeed = 1; // Adjust scrolling speed

  function scrollAnimation() {
    position -= scrollSpeed; // Move left
    if (Math.abs(position) >= scrollingImages.scrollWidth / 2) {
      position = 0; // Reset when halfway for seamless loop
    }
    scrollingImages.style.transform = `translateX(${position}px)`;
    requestAnimationFrame(scrollAnimation);
  }

  // Wait for images to load before starting animation
  window.onload = () => {
    scrollAnimation();
  };
</script>
<footer class="footer" style="background-color: #2E4D31; color: white; padding: 40px 20px; text-align: center;">
  <div class="footer-container" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; max-width: 1200px; margin: auto;">
    <div class="logo" style="flex: 1; text-align: left;">
      <img src="./assets/img/color-logos/vetcap-logo.png" alt="VETCAP Logo" style="max-width: 250px;"/>
    </div>
    <div class="partners" style="flex: 2; text-align: center;">
      <h3>PRINCIPAL PARTNERS</h3>
      <div style="margin-right: 10px;" class="sponsor-logos">
        <img src="./assets/img/espavet_white_logo.png" alt="Espavet Logo" />
        <img src="./assets/img/vibix_white_logo.png" alt="Vibix Logo" />
        <img src="./assets/img/mallen_white_logo.png" alt="Mallen Mascotas Logo" />
        <img src="./assets/img/animal_food_line-white_logo.png" alt="Animal Food Line Logo" />
      </div>
      <br>
      <h3>OFICIAL PARTNERS</h3>
      <div class="sponsor-logos">
        <img src="./assets/img/noctua_group_white_logo.png" alt="Noctua Group Logo" />
        <img src="./assets/img/colegio-white-logo.png" alt="Vetboca Logo" />
        <img src="./assets/img/patas-parriba-white-logo.png" alt="Vetboca Logo" />
        <img src="./assets/img/ccoagro-white-logo.png" alt="Ccoagro Logo" />
      </div>
    </div>
    <div class="contact" style="flex: 1; text-align: left; font-size: 30px;">
      <a href="#" style="color: orange; font-weight: bold;">&#128100; Iniciar Sesión</a>
      <h3>CONTÁCTANOS</h3>
      <p style="color:white; font-size:20px;">&#9993; <a href="mailto:info@vetcaprd.com" style="color: white;">info@vetcaprd.com</a></p>
      <p style="color:white; font-size:20px;">&#9742; +1 (809) 344-5048</p>
      <div class="social-icons">
        <a href="#"><i class="tiktok-icon"></i></a>
        <a href="#"><i class="youtube-icon"></i></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom" style="border-top: 1px solid white; margin-top: 20px; padding-top: 10px;">
    <p style="color:white; font-size:20px;">COPYRIGHT ® 2024 ENCIOSYSTEMS INC. TODOS LOS DERECHOS RESERVADOS.</p>
    <div class="links">
      <a href="#" style="color: white;">CONDICIONES DE USO</a> |
      <a href="#" style="color: white;">POLÍTICAS DE COOKIES</a>
    </div>
  </div>
</footer>


    <div id="back-top">
      <a
        title="Go to Top"
        href="#"
        ><i style="color: white !important;" class="fas fa-long-arrow-alt-up"></i
      ></a>
    </div>
    <script src="./assets/js/slider.js"></script>
    <script src="./assets/js/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/jquery.slicknav.min.js"></script>
    <script src="./assets/js/main.js"></script>
  </body>
</html>
