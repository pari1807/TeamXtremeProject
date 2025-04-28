<div class="newsletter">
  <div class="content">

    <span>get latest histudy updates</span>
    <h1>Subscribe Our Newsletter</h1>

    <p>
      Get the latest updates on learning trends, expert tips, and new courses. <br> Stay ahead with insights designed to power your success in education and beyond. <br> Join our community and unlock endless learning opportunities!
    </p>

    <div class="input-field">
      <input type="email" name="" placeholder="Enter Your E-Mail">
      <button class="btn">Subscribe</button>
    </div>

    <p>No ads, No trials, No commitments</p>

    <div class="box-container">

      <div class="box">
        <div class="box-counter">
          <p class="counter" data-speed="5000">5000</p><i class="bx bx-plus"></i>
        </div>
        <h3>Successfully Trained</h3>
        <p>Learners & Counting</p>
      </div>

      <div class="box">
        <div class="box-counter">
          <p class="counter" data-speed="1000">1000</p><i class="bx bx-plus"></i>
        </div>
        <h3>Certification Students</h3>
        <p>Online Course</p>
      </div>

    </div>

  </div>
</div>


<footer>
    <div class=content>
        <div class="box">
        <img src="/TeamXtremeProject/image/logo.png" alt="logo">
        <p>We're always in search for <br> talented and motivated people.</p>
        <p>join our growing community to <br>
           make a difference together.</p>
        <a href="contact.php" class="btn"> contact with us</a>
        </div>
    <div class="box">
    <h3>useful links</h3>
    <a href="">online coaching</a>
    <a href="">marketplace</a>
    <a href="">kindergarten</a>
    <a href="">university</a>
    <a href="">GYM coaching</a>
</div>

<div class="box">
    <h3>our company</h3>
    <a href="contact.php">contact us</a>
    <a href="">become teacher</a>
    <a href="">blog</a>
    <a href="">instructor</a>
    <a href="">events</a>
</div>

<div class="box">
    <h3>get contact</h3>
    <p>Phone: (406) 555-0120</p>
    <p>E-mail: rainbow@example.com</p>
    <p>Location: North America, USA</p>
    <div class="icons">
        <i class="bx bxl-facebook"></i>
        <i class="bx bxl-twitter"></i>
        <i class="bx bxl-instagram"></i>
        <i class="bx bxl-linkedin"></i>
    </div>
</div>

<div class="bottom">
    <p>Copyright © 2025 code with selena. All Rights Reserved</p>
</div>
    </div>
</footer>

<script>
(() => {
  const counters = document.querySelectorAll('.counter');

  counters.forEach((item) => {
    const target = parseInt(item.textContent.trim(), 10);
    item.textContent = '0';

    let count = 0;
    const speed = parseInt(item.dataset.speed, 10) || 2000;
    const increment = Math.max(1, Math.floor(target / (speed / 10)));

    const interval = setInterval(() => {
      count += increment;
      if (count >= target) {
        item.textContent = target;
        clearInterval(interval);
      } else {
        item.textContent = count;
      }
    }, 10); // update every 10ms
  });
})();
</script>


