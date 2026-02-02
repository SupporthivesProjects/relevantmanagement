<?php include 'includes/header.php'; ?>

<main class="contact-page container-fluid">
  <div class="contact-cont container" data-aos="fade-up">
    <img src="img/mob-arrow.png" alt="" class="d-block d-md-none">
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
                <input type="text" placeholder="Full name" class="inp-box">
                <input type="text" placeholder="Email address" class="inp-box">
                <select name="services" class="services-box form-select">
                  <option value="" disabled selected hidden>
                    Service of interest
                  </option>
                  <option>End-to-end project management</option>
                  <option>Project planning & scheduling</option>
                  <option>Budget & cost control</option>
                  <option>Resources management</option>
                  <option>Stakeholder management</option>
                  <option>Risk & process control</option>
                </select>
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
                    <button class="cont-btn btn" data-bs-toggle="modal" data-bs-target="#contsuccess">
                      <a href="#">Confirm</a>
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
              <p class="term-txt" style="color:#9E8361;">
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
</main>

<div class="modal fade" id="contsuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content cont-modal">
        <img src="img/modal-tick.png" alt="">
        <div class="body-cont">
        <p class="btxt">successfully submitted!</p>
        <p style="text-align:center">Your message is now with our team. We appreciate you contacting Relevant Management FZCO and will respond as soon as possible.</p>
        </div>
         <button class="cont-btn btn" data-bs-dismiss="modal" style="width:250px;">
            <a href="#">Close</a>
          </button>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>