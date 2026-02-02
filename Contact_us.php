<?php include 'includes/header.php'; ?>
<style>
.footer-div,footer{
  background: var(--Base-Off-White, #FAFAFA) !important;
}
</style>
<main class="contact-page container-fluid">
  <img src="img/Pattern-left.png" alt="" class="d-none d-md-block" style="width:80px;height;100%;">
  <div class="contact-cont container" data-aos="fade-up">
    <img src="img/line-desktop.png" alt="" class="d-none d-md-block" style="height:80px;margin-bottom:24px;">
    <img src="img/mob-arrow.png" alt="" class="d-block d-md-none" style="margin-bottom:24px;">
          <p class="g-txt">
            Contact us
          </p>
          <p class="h-txt">
            how can we help
          </p>
          <div class="cont-form w-100">
            <div class="n-a">
                <input type="text" placeholder="Full name" class="inp-box">
                <input type="text" placeholder="Email address" class="inp-box">
            </div>
            <div class="n-a">
                <input type="text" placeholder="Phone number" class="inp-box">
                <input type="text" placeholder="Company name" class="inp-box">
                <div class="dropdown services-box">
                  <!-- <button
                    class="btn dropdown-toggle service-btn w-100"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Service of interest
                  </button> -->
                  <button
  class="btn dropdown-toggle service-btn w-100"
  type="button"
  data-bs-toggle="dropdown"
  aria-expanded="false">

  <span class="btn-text">Service of interest</span>

  <img
    src="img/arrow.png"
    class="service-arrow"
  />
</button>

                  <ul class="dropdown-menu w-100 service-menu">
                    <li><a class="dropdown-item" href="#">End-to-end project management</a></li>
                    <li><a class="dropdown-item" href="#">Project planning & scheduling</a></li>
                    <li><a class="dropdown-item" href="#">Budget & cost control</a></li>
                    <li><a class="dropdown-item" href="#">Resources management</a></li>
                    <li><a class="dropdown-item" href="#">Stakeholder management</a></li>
                    <li><a class="dropdown-item" href="#">Risk & process control</a></li>
                  </ul>
                </div>
                <!-- end -->
            </div>
            <div class="n-a">
                <textarea name="" id="" class="comment-box" placeholder="Comments"></textarea>
            </div>
            <div class="n-a">
                <div class="recapcha-line">
                  <div class="term-bx">
                  <input type="checkbox" name="" id="" class="term-chk">
                  <label for="" class="term-txt">I have read and agree to the <a href="#" style="color:#9E8361;text-decoration:none;">Privacy Policy</a> .</label>
                  </div>
                  <div class="re-btn">
                    <img src="img/reCAPTCHA.png" alt="" class="recapcha">
                    <button class="cont-btn btn btn-gold btn-31 aos-init aos-animate" data-bs-toggle="modal" data-bs-target="#contsuccess">
                      <a href="#" class="text">Confirm</a>
                    </button>
                  </div>
                </div>
            </div>
          </div>
          <img src="img/mob-pattern.png" alt="" class="d-block d-md-none" style="margin-bottom:40px;">
          <div class="add-info w-100" data-aos="fade-up">
            <div class="add-line">
              <img src="img/Line.png" alt="">
              <p class="g-txt">
            Additional information
          </p>
          <img src="img/Line.png" alt="">
            </div>
            <div class="add-main w-100">
            <div class="add-cont">
              <p class="btxt">Contact Address</p>
              <p class="term-txt" style="color:#9E8361;text-align:center;">
                Relevant Management FZCO, Unit 78340-001, Building A1, 
                IFZA Business Park, Dubai Digital Park, Dubai Silicon Oasis, Dubai, UAE
              </p>
            </div>
            <div class="add-cont">
              <p class="btxt">Contact email</p>
              <p class="term-txt">
              <a href="" style="color:#9E8361;">Contact@relevantmanagement.com</a>  
              </p>
            </div>
          </div>
          </div>
     </div>
     <img src="img/Pattern-right.png" alt="" class="d-none d-md-block" style="width:80px;height;100%;">
</main>

<div class="modal fade" id="contsuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content cont-modal">
        <img src="img/modal-tick.png" alt="">
        <div class="body-cont">
        <p class="btxt">successfully submitted!</p>
        <p style="text-align:center;color:#666666">Your message is now with our team. We appreciate you contacting Relevant Management FZCO and will respond as soon as possible.</p>
        </div>
         <button class="cont-btn btn" data-bs-dismiss="modal" style="width:250px;height:48px;">
            <a href="#">Close</a>
          </button>
    </div>
  </div>
</div>



<!-- <script>
  document.querySelectorAll('.service-menu .dropdown-item')
    .forEach(item => {
      item.addEventListener('click', function (e) {
        e.preventDefault();

        const dropdown = this.closest('.dropdown');
        const button = dropdown.querySelector('.service-btn');

        button.textContent = this.textContent;
      });
    });
</script> -->
<script>
  document.querySelectorAll('.service-menu .dropdown-item')
    .forEach(item => {
      item.addEventListener('click', function (e) {
        e.preventDefault();

        const dropdown = this.closest('.dropdown');
        dropdown.querySelector('.btn-text').textContent = this.textContent;
      });
    });
</script>

<?php include 'includes/footer.php'; ?>