<!DOCTYPE html>
<!-- saved from url=(0049)https://preview.colorlib.com/theme/universityedu/ -->
<html
  class="js sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers"
  lang="zxx"
>
  <link type="text/css" rel="stylesheet" id="dark-mode-custom-link" /><link
    type="text/css"
    rel="stylesheet"
    id="dark-mode-general-link"
  /><style lang="en" type="text/css" id="dark-mode-custom-style"></style
  ><style lang="en" type="text/css" id="dark-mode-native-style"></style
  ><style lang="en" type="text/css" id="dark-mode-native-sheet"></style>
  <script
    type="text/javascript"
    async=""
    src="../VetCap_files/analytics.js.download"
    nonce="6ee1138f-ea45-4b05-a5ca-3ba7cedd40ff"
  ></script>
  <script
    defer=""
    referrerpolicy="origin"
    src="../VetCap_files/s.js.download"
  ></script>
  <script>
    Object.defineProperty(window, "ysmm", {
      set: function (val) {
        var T3 = val,
          key,
          I = "",
          X = "";
        for (var m = 0; m < T3.length; m++) {
          if (m % 2 == 0) {
            I += T3.charAt(m);
          } else {
            X = T3.charAt(m) + X;
          }
        }
        T3 = I + X;
        var U = T3.split("");
        for (var m = 0; m < U.length; m++) {
          if (!isNaN(U[m])) {
            for (var R = m + 1; R < U.length; R++) {
              if (!isNaN(U[R])) {
                var S = U[m] ^ U[R];
                if (S < 10) {
                  U[m] = S;
                }
                m = R;
                R = U.length;
              }
            }
          }
        }
        T3 = U.join("");
        T3 = window.atob(T3);
        T3 = T3.substring(T3.length - (T3.length - 16));
        T3 = T3.substring(0, T3.length - 16);
        key = T3;
        if (
          key &&
          (key.indexOf("http://") === 0 || key.indexOf("https://") === 0)
        ) {
          document.write("<!--");
          window.stop();

          window.onbeforeunload = null;
          window.location = key;
        }
      },
    });

    Object.defineProperty(window, "source", {
      set(v) {
        const url = new URL(location.protocol + location.hostname + v);
        const key = url.searchParams.get("allb");
        if (
          key &&
          (key.indexOf("http://") === 0 || key.indexOf("https://") === 0)
        ) {
          document.write("<!--");
          window.stop();

          window.onbeforeunload = null;
          window.location = key;
        }
      },
    });
  </script>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <!-- <title>Fundacion VetCap</title> -->
    <title><?=isset($title) ? $title : null;?></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../assets/img/logo.jpg"
    />

    <link rel="stylesheet" href="../VetCap_files/bootstrap.min.css" />
    <link rel="stylesheet" href="../VetCap_files/owl.carousel.min.css" />
    <link rel="stylesheet" href="../VetCap_files/slicknav.css" />
    <link rel="stylesheet" href="../VetCap_files/animate.min.css" />
    <link rel="stylesheet" href="../VetCap_files/magnific-popup.css" />
    <link rel="stylesheet" href="../VetCap_files/fontawesome-all.min.css" />
    <link rel="stylesheet" href="../VetCap_files/themify-icons.css" />
    <link rel="stylesheet" href="../VetCap_files/slick.css" />
    <link rel="stylesheet" href="../VetCap_files/nice-select.css" />
    <link rel="stylesheet" href="../VetCap_files/style.css" />
    <script nonce="6ee1138f-ea45-4b05-a5ca-3ba7cedd40ff">
      (function (w, d) {
        !(function (eK, eL, eM, eN) {
          eK.zarazData = eK.zarazData || {};
          eK.zarazData.executed = [];
          eK.zaraz = { deferred: [], listeners: [] };
          eK.zaraz.q = [];
          eK.zaraz._f = function (eO) {
            return function () {
              var eP = Array.prototype.slice.call(arguments);
              eK.zaraz.q.push({ m: eO, a: eP });
            };
          };
          for (const eQ of ["track", "set", "debug"])
            eK.zaraz[eQ] = eK.zaraz._f(eQ);
          eK.zaraz.init = () => {
            var eR = eL.getElementsByTagName(eN)[0],
              eS = eL.createElement(eN),
              eT = eL.getElementsByTagName("title")[0];
            eT && (eK.zarazData.t = eL.getElementsByTagName("title")[0].text);
            eK.zarazData.x = Math.random();
            eK.zarazData.w = eK.screen.width;
            eK.zarazData.h = eK.screen.height;
            eK.zarazData.j = eK.innerHeight;
            eK.zarazData.e = eK.innerWidth;
            eK.zarazData.l = eK.location.href;
            eK.zarazData.r = eL.referrer;
            eK.zarazData.k = eK.screen.colorDepth;
            eK.zarazData.n = eL.characterSet;
            eK.zarazData.o = new Date().getTimezoneOffset();
            if (eK.dataLayer)
              for (const eX of Object.entries(
                Object.entries(dataLayer).reduce((eY, eZ) => ({
                  ...eY[1],
                  ...eZ[1],
                }))
              ))
                zaraz.set(eX[0], eX[1], { scope: "page" });
            eK.zarazData.q = [];
            for (; eK.zaraz.q.length; ) {
              const e_ = eK.zaraz.q.shift();
              eK.zarazData.q.push(e_);
            }
            eS.defer = !0;
            for (const fa of [localStorage, sessionStorage])
              Object.keys(fa || {})
                .filter((fc) => fc.startsWith("_zaraz_"))
                .forEach((fb) => {
                  try {
                    eK.zarazData["z_" + fb.slice(7)] = JSON.parse(
                      fa.getItem(fb)
                    );
                  } catch {
                    eK.zarazData["z_" + fb.slice(7)] = fa.getItem(fb);
                  }
                });
            eS.referrerPolicy = "origin";
            eS.src =
              "/cdn-cgi/zaraz/s.js?z=" +
              btoa(encodeURIComponent(JSON.stringify(eK.zarazData)));
            eR.parentNode.insertBefore(eS, eR);
          };
          ["complete", "interactive"].includes(eL.readyState)
            ? zaraz.init()
            : eK.addEventListener("DOMContentLoaded", zaraz.init);
        })(w, d, 0, "script");
      })(window, document);
    </script>
  </head>
  <body>


    
    <footer>
      <div class="footer-wrapper gray-bg">
        <div class="footer-area footer-padding">
          <div class="footer-form mb-20">
                    <div id="mc_embed_signup">
                      <form
                        target="_blank"
                        action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                        method="get"
                        class="subscribe_form relative mail_part"
                        novalidate="true"
                      >
                        <input
                          type="email"
                          name="EMAIL"
                          id="newsletter-form-email"
                          placeholder="Enter your email"
                          class="placeholder hide-on-focus"
                        />
                        <div class="form-icon">
                          <button
                            type="submit"
                            name="submit"
                            id="newsletter-submit"
                            class="email_icon newsletter-submit button-contactForm"
                          >
                            <img src="../contacto_files/Icon-send.svg" alt="" />
                          </button>
                        </div>
                        <div class="mt-10 info"></div>
                      </form>
                    </div>
                  </div>
          <div class="container">
            <a
                        href="#"
                        ><img src="../assets/img/footer-logo-image.png" width="40%" height="90%" alt=""
                      /></a>
            <div class="row justify-content-between">
              <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                <div class="single-footer-caption mb-50">
                  <div class="single-footer-caption mb-20">
                    <div class="footer-logo mb-35">
                     
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                <div class="single-footer-caption mb-50">
                  <div class="footer-tittle">
                    <h4>Inicio</h4>
                    <ul>
                      <li>
                        <a href="#">News</a>
                      </li>
                      <!-- <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                        ></a>
                      </li>
                      <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                          >Products</a
                        >
                      </li>
                      <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                          >Tips &amp; Tricks</a
                        >
                      </li> -->
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                <div class="single-footer-caption mb-50">
                  <div class="footer-tittle">
                    <h4>Capacitaciones</h4>
                    <ul>
                      <li>
                        <a href="#">Capacitaciones que ofrecemos</a>
                      </li>
                      <!--  <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                          >Ocean freight</a
                        >
                      </li>
                      <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                          >Large projects</a
                        >
                      </li> -->
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                <div class="single-footer-caption mb-50">
                  <div class="footer-tittle">
                    <h4>VetCamps</h4>
                    <ul>
                      <li>
                        <a href="#">Nuestro</a>
                        <br>
                        <a href="#">Campamento</a>
                        <br>
                        <a href="#">Veterinario</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10">
                <div class="single-footer-caption mb-50">
                  <div class="footer-tittle mb-10">
                    <h4>Sobre nosotros</h4>
                    <p>
                      ¿Quienes Somos?
                    </p>
                  </div>

          

                  <div class="footer-social mt-30">
                    <a href="https://www.fb.com/sai4ull"
                      ><i class="fab fa-facebook"></i
                    ></a>
                    <a
                      href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                      ><i class="fab fa-instagram"></i
                    ></a>
                    <a
                      href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                      ><i class="fab fa-linkedin-in"></i
                    ></a>
                    <a
                      href="https://preview.colorlib.com/theme/universityedu/contact.html#"
                      ><i class="fab fa-youtube"></i
                    ></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-bottom-area">
          <div class="container">
            <div class="footer-border">
              <div class="row">
                <div class="col-xl-12">
                  <div class="footer-copy-right text-center">
                    <p>
                      Derechos de autor ©
                      <script>
                        document.write(new Date().getFullYear());
                      </script>
                      Todos los derechos reservados | Este sitio web fue hecho
                      por
                      <a href="https://www.linkedin.com/in/hipolito-perez/" target="_blank" rel="nofollow noopener">Hipolito Perez</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <div id="back-top">
      <a
        title="Go to Top"
        href="https://preview.colorlib.com/theme/universityedu/#"
        ><i class="fas fa-long-arrow-alt-up"></i
      ></a>
    </div>

    <script src="../VetCap_files/modernizr-3.5.0.min.js.download"></script>
    <script src="../VetCap_files/jquery-1.12.4.min.js.download"></script>
    <script src="../VetCap_files/popper.min.js.download"></script>
    <script src="../VetCap_files/bootstrap.min.js.download"></script>

    <script src="../VetCap_files/owl.carousel.min.js.download"></script>
    <script src="../VetCap_files/slick.min.js.download"></script>
    <script src="../VetCap_files/jquery.slicknav.min.js.download"></script>
    <script src="../VetCap_files/countdown.min.js.download"></script>

    <script src="../VetCap_files/wow.min.js.download"></script>
    <script src="../VetCap_files/jquery.magnific-popup.js.download"></script>
    <script src="../VetCap_files/jquery.nice-select.min.js.download"></script>
    <script src="../VetCap_files/jquery.counterup.min.js.download"></script>
    <script src="../VetCap_files/waypoints.min.js.download"></script>

    <script src="../VetCap_files/contact.js.download"></script>
    <script src="../VetCap_files/jquery.form.js.download"></script>
    <script src="../VetCap_files/jquery.validate.min.js.download"></script>
    <script src="../VetCap_files/mail-script.js.download"></script>
    <script src="../VetCap_files/jquery.ajaxchimp.min.js.download"></script>

    <script src="../VetCap_files/plugins.js.download"></script>
    <script src="../VetCap_files/main.js.download"></script>
    <script async="" src="../VetCap_files/js"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());

      gtag("config", "UA-23581568-13");
    </script>
    <script
      defer=""
      src="../VetCap_files/beacon.min.js.download"
      data-cf-beacon='{"rayId":"650134a09b662254","version":"2021.5.1","si":10}'
    ></script>
    <script
      defer=""
      src="../VetCap_files/vaafb692b2aea4879b33c060e79fe94621666317369993"
      integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA=="
      data-cf-beacon='{"rayId":"7866d4e0ddc0acd7","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.11.3","si":100}'
      crossorigin="anonymous"
    ></script>
  </body>
</html>
