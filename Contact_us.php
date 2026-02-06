<?php 
include 'contact_handler.php';
include 'includes/header.php'; 
?>
<style>
  .footer-div,
  footer {
    background: var(--Base-Off-White, #FAFAFA) !important;
  }
</style>
<main class="contact-page container-fluid">
  <img src="img/Pattern-left.png" alt="" class="d-none d-md-block" style="width:80px;height:100%;">
  <div class="contact-cont container" data-aos="fade-up">
    <img src="img/line-desktop.png" alt="" class="d-none d-md-block" style="height:80px;margin-bottom:24px;">
    <img src="img/mob-arrow.png" alt="" class="d-block d-md-none" style="margin-bottom:24px;">
    <p class="g-txt">
      Contact us
    </p>
    <p class="h-txt">
      how can we help
    </p>
    <form class="cont-form w-100" id="contactForm" method="POST" action="">
      <input type="hidden" name="service_of_interest" id="service_of_interest">
      <div class="n-a">
        <input type="text" placeholder="Full name" name="full_name" class="inp-box" required>
        <input type="email" placeholder="Email address" name="email" class="inp-box" required>
      </div>
      <div class="n-a">
        <input type="tel" placeholder="Phone number" name="phone" class="inp-box" required>
        <input type="text" placeholder="Company name" name="company" class="inp-box">
        <div class="dropdown services-box">
          <button
            class="btn dropdown-toggle service-btn w-100"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">

            <span class="btn-text" id="selectedService">Service of interest</span>

            <img
              src="img/arrow.png"
              class="service-arrow" />
          </button>

          <ul class="dropdown-menu w-100 service-menu">
            <li><a class="dropdown-item" href="#" data-value="End-to-end project management">End-to-end project management</a></li>
            <li><a class="dropdown-item" href="#" data-value="Project planning &amp; scheduling">Project planning &amp; scheduling</a></li>
            <li><a class="dropdown-item" href="#" data-value="Budget &amp; cost control">Budget &amp; cost control</a></li>
            <li><a class="dropdown-item" href="#" data-value="Resources management">Resources management</a></li>
            <li><a class="dropdown-item" href="#" data-value="Stakeholder management">Stakeholder management</a></li>
            <li><a class="dropdown-item" href="#" data-value="Risk &amp; process control">Risk &amp; process control</a></li>
          </ul>
        </div>
      </div>
      <div class="n-a">
        <textarea name="message" class="comment-box" placeholder="Comments" required></textarea>
      </div>
      <div class="n-a">
        <div class="recapcha-line">
          <div class="term-bx">
            <input type="checkbox" id="terms" name="terms" class="term-chk">
            <label for="terms" class="term-txt" id="terms-text">I have read and agree to the <a href="privacy.php" style="color:#9E8361;text-decoration:none;">Privacy Policy</a> .</label>
          </div>
          <div class="re-btn">
            <div class="h-captcha recapcha" data-sitekey="6d544706-a634-41da-a362-eb48f08a7876" style="height:74px; transform: scale(0.7);"></div>
            <button class="cont-btn btn btn-gold btn-31 aos-init aos-animate " type="submit" name="submit_contact">
              <a  class="text">Confirm</a>
            </button>
          </div>
        </div>
      </div>
    </form>
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
  <img src="img/Pattern-right.png" alt="" class="d-none d-md-block" style="width:80px;height:100%;">
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

<div class="modal fade" id="conterror" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content cont-modal">
      <img src="img/modal-cross.png" alt="">
      <div class="body-cont">
        <p class="btxt">an error occurred</p>
        <p id="errorMessage" style="text-align:center;color:#666666">There was an error with the submission. Please check your details and try again.</p>
      </div>
      <button class="cont-btn btn" data-bs-dismiss="modal" style="width:250px;height:48px;">
        <a href="#">Try Again</a>
      </button>
    </div>
  </div>
</div>

<div class="modal fade" id="contwarning" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content cont-modal">
      <img src="img/modal-tick.png" alt="">
      <div class="body-cont">
        <p class="btxt">partially sent</p>
        <p id="warningMessage" style="text-align:center;color:#666666"></p>
      </div>
      <button class="cont-btn btn" data-bs-dismiss="modal" style="width:250px;height:48px;">
        <a href="#">Close</a>
      </button>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.service-menu .dropdown-item').forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      var value = this.getAttribute('data-value');
      document.getElementById('selectedService').innerText = value;
      document.getElementById('service_of_interest').value = value;
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>

<script>
  document.getElementById('contactForm').addEventListener('submit', function(e) {
    var termsCheckbox = document.getElementById('terms');

    if (!termsCheckbox.checked) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Privacy Policy Agreement Required!',
        html: 'You must agree to our <a href="privacy.php" target="_blank" style="color: #007bff; text-decoration: underline;">Privacy Policy</a> to submit this form.',
        confirmButtonColor: '#ffc107',
        confirmButtonText: 'I Understand'
      });
      return false;
    }

    Swal.fire({
      title: 'Sending...',
      html: 'Please wait while we process your message',
      didOpen: function() {
        Swal.showLoading();
      },
      showConfirmButton: false,
      allowOutsideClick: false,
      allowEscapeKey: false,
      allowEnterKey: false
    });
  });

  window.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($_SESSION['form_success'])): ?>
      var successModalEl = document.getElementById('contsuccess');
      var successModal = new window.bootstrap.Modal(successModalEl);
      successModal.show();
      document.getElementById('contactForm').reset();
      document.getElementById('selectedService').innerText = 'Service of interest';
      <?php unset($_SESSION['form_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['form_error'])): ?>
      <?php if ($_SESSION['form_error'] === 'terms'): ?>
        Swal.fire({
          icon: 'warning',
          title: 'Privacy Policy Agreement Required!',
          html: 'You must agree to our <a href="privacy.php" target="_blank" style="color: #007bff; text-decoration: underline;">Privacy Policy</a> to submit this form.',
          confirmButtonColor: '#ffc107',
          confirmButtonText: 'I Understand'
        });
      <?php else: ?>
        document.getElementById('errorMessage').innerText = '<?php echo addslashes($_SESSION['form_error']); ?>';
        var errorModalEl = document.getElementById('conterror');
        var errorModal = new window.bootstrap.Modal(errorModalEl);
        errorModal.show();
      <?php endif; ?>
      <?php unset($_SESSION['form_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['form_warning'])): ?>
      var warningMsg = '';
      <?php if ($_SESSION['form_warning'] === 'partial_user'): ?>
        warningMsg = 'Your message was received, but we couldn\'t send you a confirmation email. We will still get back to you soon!';
      <?php elseif ($_SESSION['form_warning'] === 'partial_admin'): ?>
        warningMsg = 'We sent you a confirmation email, but there was an issue with our internal notification. Please call us if urgent.';
      <?php endif; ?>
      document.getElementById('warningMessage').innerText = warningMsg;
      var warningModalEl = document.getElementById('contwarning');
      var warningModal = new window.bootstrap.Modal(warningModalEl);
      warningModal.show();
      document.getElementById('contactForm').reset();
      document.getElementById('selectedService').innerText = 'Service of interest';
      <?php unset($_SESSION['form_warning']); ?>
    <?php endif; ?>
  });
</script>

<?php include 'includes/footer.php'; ?>