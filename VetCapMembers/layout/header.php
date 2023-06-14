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
    <header>
  <div class="header-area">
    <div class="main-header"></div>
    <div class="menu-jevi header-bottom header-sticky">
      
      <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap position-relative">
          <div class="left-side d-flex align-items-center">
            <div class="logo">
              <a href="../index.html">
                <img src="../assets/img/logo.jpg" alt="" width="110" />
              </a>
              <a href="../index.html">
                <img src="../assets/img/vetcap-title.png" alt="" width="310" />
              </a>
            </div>
            <div class="main-menu d-none d-lg-block">
              <nav>
                <ul id="navigation">
                  <li>
                    <a href="../index.html">Inicio</a>
                  </li>
                  <li>
                    <a href="../capacitaciones.html">Capacitaciones</a>
                  </li>
                  <li>
                    <a href="../vetcamps.html">VetCamps</a>
                  </li>
                  <li>
                    <a href="../sobre-nosotros.html">Sobre nosotros</a>
                  </li>
                  <li>
                    <a href="../contactanos.html">Contactanos</a>
                  </li>
                  <li><a href=""><img src="../assets/img/user-icon.png" alt=""></a></li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="header-right-btn d-flex f-right align-items-center">
            <!-- Your header right buttons or social icons here -->
          </div>

          <div class="col-12">
                <div class="mobile_menu d-block d-lg-none">
                  <div class="slicknav_menu">
                    <a
                      href="#"
                      aria-haspopup="true"
                      role="button"
                      tabindex="0"
                      class="slicknav_btn slicknav_collapsed"
                      style="outline: none"
                      ><span class="slicknav_menutxt">MENU</span
                      ></span
                    ></a>
                    <ul
                      class="slicknav_nav slicknav_hidden"
                      aria-hidden="true"
                      role="menu"
                      style="display: none"
                    >
                      <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/index.html"
                          role="menuitem"
                          tabindex="-1"
                          >Home</a
                        >
                      </li>
                      <li>
                        <a href="../nosotros.html" role="menuitem" tabindex="-1"
                          >About</a
                        >
                      </li>
                      <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/programs.html"
                          role="menuitem"
                          tabindex="-1"
                          >Programs</a
                        >
                      </li>
                      <li class="slicknav_collapsed slicknav_parent">
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/#"
                          role="menuitem"
                          aria-haspopup="true"
                          tabindex="-1"
                          class="slicknav_item slicknav_row"
                          style="outline: none"
                          ><a
                            href="https://preview.colorlib.com/theme/universityedu/blog.html"
                            tabindex="-1"
                            >Blog</a
                          >
                          <span class="slicknav_arrow">+</span></a
                        >
                        <ul
                          class="submenu slicknav_hidden"
                          role="menu"
                          aria-hidden="true"
                          style="display: none"
                        >
                          <li>
                            <a
                              href="https://preview.colorlib.com/theme/universityedu/blog.html"
                              role="menuitem"
                              tabindex="-1"
                              >Blog</a
                            >
                          </li>
                          <li>
                            <a
                              href="https://preview.colorlib.com/theme/universityedu/blog_details.html"
                              role="menuitem"
                              tabindex="-1"
                              >Blog Details</a
                            >
                          </li>
                          <li>
                            <a
                              href="https://preview.colorlib.com/theme/universityedu/elements.html"
                              role="menuitem"
                              tabindex="-1"
                              >Elements</a
                            >
                          </li>
                        </ul>
                      </li>
                      <li>
                        <a
                          href="https://preview.colorlib.com/theme/universityedu/contact.html"
                          role="menuitem"
                          tabindex="-1"
                          >Contact</a
                        >
                      </li>
                    </ul>
                  </div>
                </div>
              </div>



              
        </div>
      </div>
    </div>
  </div>
</header>

    
   

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
