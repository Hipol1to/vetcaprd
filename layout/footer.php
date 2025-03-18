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

    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="index.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 7.5.2, nicepage.com">    
    
    
    <footer class="u-align-center u-clearfix u-container-align-center u-custom-color-1 u-footer u-footer" id="footer"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-1" src="images/logodeVETCAP2025.png" alt="" data-image-width="320" data-image-height="320"><p class="u-custom-font u-text u-text-1">Principal Partner</p><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-2" src="images/31.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-3" src="images/21.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-4" src="images/12.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-5" src="images/4.png" alt="" data-image-width="500" data-image-height="500"><p class="u-custom-font u-text u-text-2">Official Partner</p><p class="u-custom-font u-text u-text-custom-color-3 u-text-3"> Contáctanos</p><a href="" class="u-active-none u-align-center u-btn u-btn-rectangle u-button-style u-hover-none u-none u-btn-1">
        <span class="u-icon"><svg class="u-svg-content" viewBox="0 0 405.333 405.333" x="0px" y="0px" style="width: 1em; height: 1em;"><path d="M373.333,266.88c-25.003,0-49.493-3.904-72.704-11.563c-11.328-3.904-24.192-0.896-31.637,6.699l-46.016,34.752    c-52.8-28.181-86.592-61.952-114.389-114.368l33.813-44.928c8.512-8.512,11.563-20.971,7.915-32.64    C142.592,81.472,138.667,56.96,138.667,32c0-17.643-14.357-32-32-32H32C14.357,0,0,14.357,0,32    c0,205.845,167.488,373.333,373.333,373.333c17.643,0,32-14.357,32-32V298.88C405.333,281.237,390.976,266.88,373.333,266.88z"></path></svg></span>&nbsp;​+1 (809) 344-5048
      </a><a href="mailto:info@vetcaprd.com" class="u-active-none u-btn u-btn-rectangle u-button-style u-hover-none u-none u-text-white u-btn-2">
        <span class="u-icon u-text-white"><svg class="u-svg-content" viewBox="0 0 24 16" x="0px" y="0px" style="width: 1em; height: 1em;"><path fill="currentColor" d="M23.8,1.1l-7.3,6.8l7.3,6.8c0.1-0.2,0.2-0.6,0.2-0.9V2C24,1.7,23.9,1.4,23.8,1.1z M21.8,0H2.2
	c-0.4,0-0.7,0.1-1,0.2L10.6,9c0.8,0.8,2.2,0.8,3,0l9.2-8.7C22.6,0.1,22.2,0,21.8,0z M0.2,1.1C0.1,1.4,0,1.7,0,2V14
	c0,0.3,0.1,0.6,0.2,0.9l7.3-6.8L0.2,1.1z M15.5,9l-1.1,1c-1.3,1.2-3.6,1.2-4.9,0l-1-1l-7.3,6.8c0.2,0.1,0.6,0.2,1,0.2H22
	c0.4,0,0.6-0.1,1-0.2L15.5,9z"></path></svg></span>&nbsp;info@vetcaprd.com
      </a><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-6" src="images/9.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-7" src="images/5.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-8" src="images/7.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-9" src="images/8.png" alt="" data-image-width="500" data-image-height="500"><img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-10" src="images/6.png" alt="" data-image-width="500" data-image-height="500"><div class="u-border-2 u-border-white u-expanded-width-xs u-line u-line-horizontal u-line-1"></div><p class="u-custom-font u-text u-text-default u-text-4"> Copyright ® 2025 EncioSystems Inc. Todos los derechos reservados.</p></footer>
    
  
</body></html>

    <div id="back-top">
      <a
        title="Go to Top"
        href="#"
        ><i style="color: white !important;" class="fas fa-long-arrow-alt-up"></i
      ></a>
    </div>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
