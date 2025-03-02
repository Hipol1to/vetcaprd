<footer class="footer px-4">
        <div><a href="https://coreui.io">EncioSystems  </a><a href="https://coreui.io/product/free-bootstrap-admin-template/"></a> © <a id="year"></a>.</div>
        <script>document.getElementById("year").innerHTML = new Date().getFullYear();</script>
      </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="vendors/simplebar/js/simplebar.min.js"></script>
    <script>
      const header = document.querySelector('header.header');

      document.addEventListener('scroll', () => {
        if (header) {
          header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
      });
    </script>
  </body>
</html>