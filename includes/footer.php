  <footer>
    <div class="footer-div">
      <div class="container">
          <div class="col">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-sm-12 col-12 p-mo">
                  <div class="left-side-footer">
                      <h2>Contact us. <img src="./img/down-arrow.svg" alt="img" class="img-fluid"></h2>
                      <div class="footer-menu">
                        <ul>
                            <li>
                              <a href="index.php" class="footer-menu">Home</a>
                            </li>
                            <li>
                              <a href="aboutus.php" class="footer-menu">about</a>
                            </li>
                            <li>
                              <a href="service.php" class="footer-menu">services</a>
                            </li>
                            <li>
                              <a href="privacy.html" class="footer-menu">Privacy policy</a>
                            </li>
                        </ul>
                      </div>
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-sm-12 col-12 p-mo">
                  <div class="right-side-footer">
                      <div class="right-side-footer-div">
                        <img src="./img/f-logo.svg" alt="img" class="img-fluid">
                        <div>
                          <p>Registration Number 76591</p>
                          <p class="p-copy">©2026 Relevant Management FZCO</p>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
    <img src="./img/pattern.png" alt="img" class="img-fluid d-lg-block d-md-block d-none w-100">
    <img src="./img/pattern-mo.png" alt="img" class="img-fluid d-lg-none d-md-none d-block w-100">
  </footer>
  </div>
    <script src="uiframe/js/jquery.min.js"></script>
    <script src="uiframe/js/bootstrap.bundle.min.js"></script>
    <script src="uiframe/js/popper.min.js"></script>
    <script src="uiframe/js/slick.js"></script>
    <script src="uiframe/js/owl.carousel.js"></script>
    <script src="uiframe/js/swiper-bundle.min.js"></script>
    <script src="uiframe/js/flickity.pkgd.min.js"></script>   
    <script src="uiframe/js/aos.js"></script>
    <script src="./uiframe/js/home-js.js"></script>
    <script>
        $(document).ready(function () {
            $(".navbar-toggler").click(function () {
                $(this).toggleClass("is-active");
                $(".navbar-expand-lg").toggleClass("header-is-active");
            });
        });
    </script>
    <script>
      window.addEventListener('scroll', function() {
          var content = document.querySelector('header');
          var scrollPosition = window.scrollY;
          if (scrollPosition > 10) {
              content.classList.add("header-scroll")
          } else {
              content.classList.remove("header-scroll")
          }
      });
    </script>
    <script>
      $(document).ready(function () {
          var owl = $('.owl-carousel');
          owl.owlCarousel({
              items: 1,
              loop: true,
              margin: 20,
              autoplay: true,
          });
      });
    </script>
    <script>
      AOS.init();
    </script>
  </body>
  </html>
  