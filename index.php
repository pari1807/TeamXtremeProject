<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmarks = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmarks->execute([$user_id]); 
$total_bookmarks = $select_bookmarks->rowCount();


?>
<style>
    <?php include 'css/user_style.css'; ?>
</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HiStudy Home Page</title>

    <!-- Boxicons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<!--------------------Home Section--------------------->
<!-- Home / Hero Section -->
<section class="hero">

  <div class="box-container">

    <div class="box">
      <img src="image/banner-01.png" alt="Banner Image">
    </div>

    <div class="box">
      <h1>Build the skills to drive your career</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Cumque impedit ullam omnis adipisci eum. Molestias quos maxime dignissimos, 
        atque, nam explicabo cum quibusdam facere, officiis saepe exercitationem 
        illum modi dicta!
      </p>
      <a href="courses.php" class="btn">View Courses</a>
    </div>

  </div>

</section>

<!-------------------------categories--------------------------->
<div class="categories">
  <div class="heading">
    <span>categories</span>
    <br><br><br>
    <h1>explore top courses categories <br>that change yourself</h1>
  </div>

  <div class="box-container">
    <!-- Web Design Category -->
    <div class="box">
      <img src="image/web-design.png" alt="Web Design">
      <h3>web design</h3>
      <a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>

    <!-- Graphic Design Category -->
    <div class="box">
      <img src="image/design.png" alt="Graphic Design">
      <h3>graphic design</h3>
      <a href="courses.php">30 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>

    <!-- Personal Development Category -->
    <div class="box">
      <img src="image/personal.png" alt="Personal Development">
      <h3>personal development</h3>
      <a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>

    <!-- Sales Marketing Category -->
    <div class="box">
      <img src="image/pantone.png" alt="Sales Marketing">
      <h3>sales marketing</h3>
      <a href="courses.php">251 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>

    <!-- Art & Humanities Category -->
    <div class="box">
      <img src="image/paint-palette.png" alt="Art & Humanities">
      <h3>art & humanities</h3>
      <a href="courses.php">15 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>

    <!-- Mobile Application Category -->
    <div class="box">
      <img src="image/smartphone.png" alt="Mobile Application">
      <h3>mobile application</h3>
      <a href="courses.php">35 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>

    <!-- Finance & Accounting Category -->
    <div class="box">
      <img src="image/infographic.png" alt="Finance & Accounting">
      <h3>finance & accounting</h3>
      <a href="courses.php">25 courses <i class="bx bx-right-arrow-alt"></i> </a>
    </div>
  </div>
</div>

<!-------------------------icons section --------------------------->
<div class="icon-section">

    <div class="box">
      <img src="image/icons-01.png" alt="Fast Performance Icon">
      <h3>Fast Performance</h3>
      <p>Experience lightning-fast load times and seamless navigation throughout the platform.</p>
    </div>

    <div class="box">
      <img src="image/icons-02.png" alt="Secure Learning Icon">
      <h3>Secure Learning</h3>
      <p>Your data and progress are protected with industry-leading security measures.</p>
    </div>

    <div class="box">
      <img src="image/icons-03.png" alt="Expert Instructors Icon">
      <h3>Expert Instructors</h3>
      <p>Learn from top educators and professionals with real-world experience.</p>
    </div>

    <div class="box">
      <img src="image/icons-04.png" alt="Flexible Access Icon">
      <h3>Flexible Access</h3>
      <p>Study anytime, anywhere, and on any device with our fully responsive platform.</p>
    </div>

  </div>


<!-------------------------courses section --------------------------->
<div class="courses">

  <div class="heading">
    <span>Top Popular Courses</span>
    <h1>HiStudy course students <br> can join with us</h1>
  </div>

  <div class="box-container">

    <?php
    $select_courses = $conn->prepare("SELECT * FROM playlist WHERE status = ? ORDER BY date DESC LIMIT 6");
    $select_courses->execute(['active']);

    if ($select_courses->rowCount() > 0) {
      while ($fetch_courses = $select_courses->fetch(PDO::FETCH_ASSOC)) {
        $course_id = $fetch_courses['id'];

        $select_tutor = $conn->prepare("SELECT * FROM tutors WHERE id = ?");
        $select_tutor->execute([$fetch_courses['tutor_id']]);
        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="box">

      <div class="tutor">
        <img src="uploaded_files/IZUZ8vtCrn.png" alt="Tutor Image">
        <div>
          <h3>Paritosh</h3>
          <span><?= htmlspecialchars($fetch_courses['date']); ?></span>
        </div>
      </div>

      <img src="<?php 
        $thumb_path = 'uploaded_files/' . $fetch_courses['thumb'];
        if (!empty($fetch_courses['thumb']) && file_exists($thumb_path)) {
          echo $thumb_path;
        } else {
          echo 'uploaded_files/default-course.jpg'; // fallback image
        }
      ?>" class="thumb" alt="Course Image">
      <h3 class="title"><?= htmlspecialchars($fetch_courses['title']); ?></h3>
      <a href="playlist.php?get_id=<?= $course_id; ?>" class="btn">View Course</a>

    </div>

    <?php
      }
    } else {
      echo '<p class="empty">No courses added yet!</p>';
    }
    ?>

  </div>
  <div class="more-btn">
    <a href="courses.php" class="btn">View More</a>
  </div>
</div>

<!-------------------------benifities section --------------------------->  
<div class="benifites">
<img src="image/map.png" alt="Map Image" class="map">
   <div class="detail">
      <h1>Globally trusted by hundreds of <br> thousands of customers.</h1>
      <p>Work Smarter ☕ Create Better ⭐ Build Faster ⚡️</p>
      <a href="courses.php" class="btn">Explore Courses Now</a>
      <p>HOW WILL HISTUDY BENEFIT ME?</p>

      <div class="box-container">

         <div class="box">
            <img src="image/benefit-01.png" alt="Benefit 1">
            <p>Free Lifetime <br>Update</p>
         </div>

         <div class="box">
            <img src="image/benefit-02.png" alt="Benefit 2">
            <p>Premium Support <br>6 Months Free</p>
         </div>

         <div class="box">
            <img src="image/benefit-03.png" alt="Benefit 3">
            <p>High Speed <br>Performance</p>
         </div>

         <div class="box">
            <img src="image/benefit-04.png" alt="Benefit 4">
            <p>We Provided Premium <br>Courses</p>
         </div>

         <div class="box">
            <img src="image/benefit-05.png" alt="Benefit 5">
            <p>Developer Friendly <br>Code & Design</p>
         </div>

      </div>
   </div>

</div>

<!-------------------------lerner section --------------------------->
<div class="learners">
  <div class="heading">
    <span>Why choose us</span>
    <h1>Creating a community of <br> lifelong learners</h1>
  </div>

  <div class="box-container">
    <div class="box">
      <div class="shape"></div>
      <div class="round">
        <img src="image/counter-01.png" alt="Learners Icon">
      </div>
      <div class="box-counter">
        <p class="counter" data-speed="500">500</p>
        <i class="bx bx-plus"></i>
      </div>
      <p>Learners & counting</p>
    </div>
    <div class="box">
      <div class="shape"></div>
      <div class="round">
        <img src="image/counter-02.png" alt="Learners Icon">
      </div>
      <div class="box-counter">
        <p class="counter" data-speed="500">800</p>
        <i class="bx bx-plus"></i>
      </div>
      <p>Courses and Videos </p>
    </div>
    <div class="box">
      <div class="shape"></div>
      <div class="round">
        <img src="image/counter-03.png" alt="Learners Icon">
      </div>
      <div class="box-counter">
        <p class="counter" data-speed="500">5000</p>
        <i class="bx bx-plus"></i>
      </div>
      <p>Certified students</p>
    </div>
    <div class="box">
      <div class="shape"></div>
      <div class="round">
        <img src="image/counter-04.png" alt="Learners Icon">
      </div>
      <div class="box-counter">
        <p class="counter" data-speed="500">500</p>
        <i class="bx bx-plus"></i>
      </div>
      <p>Registered Enrolled</p>
    </div>

  </div>
</div>
<!--------------------------------- About Us Section------------------- -->
<div class="about-us">

  <div class="box-container">

    <div class="box">
      <img src="image/about (2).png" alt="About Us Image">
    </div>

    <div class="box">
      <div class="heading">
        <span>TOP-NOTCH FEATURES</span><br>
        <h1>Everything you need to succeed.</h1>
        <p>
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam fuga voluptatibus
          necessitatibus dolore aspernatur quis blanditiis dolor enim facere, pariatur totam
          tenetur voluptas qui, molestiae, commodi iusto quia nam! Expedita?
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsam fuga voluptatibus
          necessitatibus dolore aspernatur quis blanditiis dolor enim facere, pariatur totam
          tenetur voluptas qui, molestiae, commodi iusto quia nam! Expedita?
        </p>
        <a href="about.php" class="btn">Know more about us</a>
      </div>
    </div>

  </div>

</div>

<!----------------------------------Teachers----------------------------------------->
<!-- Teacher Section -->
<div class="teacher-section">

  <div class="heading">
    <span>Our Teachers</span>
    <h1>Whose inspiration you</h1>
  </div>

  <div class="box-container">
    
    <!-- Teacher Tabs -->
    <div class="teacher-tabs">
      <img src="image/team-01.jpg" class="tab-item active" data-target="#team-01">
      <img src="image/team-02.jpg" class="tab-item" data-target="#team-02">
      <img src="image/team-03.jpg" class="tab-item" data-target="#team-03">
      <img src="image/team-04.jpg" class="tab-item" data-target="#team-04">
      <img src="image/team-05.jpg" class="tab-item" data-target="#team-05">
      <img src="image/team-06.jpg" class="tab-item" data-target="#team-06">
    </div>

    <!-- Teacher Profile Tab Content -->
    <div class="tab-content active" id="team-01">
      <img src="image/team-01.jpg" alt="Teacher Image">

      <div class="detail">
        <h2>James Mary</h2>
        <span>English Teacher</span>
        <p><i class="bx bx-location-plus"></i> CO Miego, AD, USA</p>
        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>

        <div class="icons">
          <i class="bx bxl-instagram"></i>
          <i class="bx bxl-twitter"></i>
          <i class="bx bxl-facebook"></i>
          <i class="bx bxl-linkedin"></i>
        </div>

        <a href="#"><i class="bx bx-phone"></i> +1-202-555-0174</a>
        <a href="#"><i class="bx bx-envelope"></i> example@gmail.com</a>
      </div>
    </div>
    <div class="tab-content" id="team-02">
      <img src="image/team-02.jpg" alt="Teacher Image">

      <div class="detail">
        <h2>Sakshi</h2>
        <span>Computer Science Teacher</span>
        <p><i class="bx bx-location-plus"></i> CO Miego, AD, USA</p>
        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>

        <div class="icons">
          <i class="bx bxl-instagram"></i>
          <i class="bx bxl-twitter"></i>
          <i class="bx bxl-facebook"></i>
          <i class="bx bxl-linkedin"></i>
        </div>

        <a href="#"><i class="bx bx-phone"></i> +1-202-555-0174</a>
        <a href="#"><i class="bx bx-envelope"></i> example@gmail.com</a>
      </div>
    </div>
    <div class="tab-content" id="team-03">
      <img src="image/team-03.jpg" alt="Teacher Image">

      <div class="detail">
        <h2>Hemali Mary</h2>
        <span>Data Scientist</span>
        <p><i class="bx bx-location-plus"></i> CO Miego, AD, USA</p>
        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>

        <div class="icons">
          <i class="bx bxl-instagram"></i>
          <i class="bx bxl-twitter"></i>
          <i class="bx bxl-facebook"></i>
          <i class="bx bxl-linkedin"></i>
        </div>

        <a href="#"><i class="bx bx-phone"></i> +1-202-555-0174</a>
        <a href="#"><i class="bx bx-envelope"></i> example@gmail.com</a>
      </div>
    </div>
    <div class="tab-content" id="team-04">
      <img src="image/team-04.jpg" alt="Teacher Image">

      <div class="detail">
        <h2>Hidam Singh</h2>
        <span>Architechture Teacher</span>
        <p><i class="bx bx-location-plus"></i> CO Miego, AD, USA</p>
        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>

        <div class="icons">
          <i class="bx bxl-instagram"></i>
          <i class="bx bxl-twitter"></i>
          <i class="bx bxl-facebook"></i>
          <i class="bx bxl-linkedin"></i>
        </div>

        <a href="#"><i class="bx bx-phone"></i> +1-202-555-0174</a>
        <a href="#"><i class="bx bx-envelope"></i> example@gmail.com</a>
      </div>
    </div>
    <div class="tab-content" id="team-05">
      <img src="image/team-05.jpg" alt="Teacher Image">

      <div class="detail">
        <h2>Shiv kumar</h2>
        <span>Graphic Designer</span>
        <p><i class="bx bx-location-plus"></i> CO Miego, AD, USA</p>
        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>

        <div class="icons">
          <i class="bx bxl-instagram"></i>
          <i class="bx bxl-twitter"></i>
          <i class="bx bxl-facebook"></i>
          <i class="bx bxl-linkedin"></i>
        </div>

        <a href="#"><i class="bx bx-phone"></i> +1-202-555-0174</a>
        <a href="#"><i class="bx bx-envelope"></i> example@gmail.com</a>
      </div>
    </div>
    <div class="tab-content" id="team-06">
      <img src="image/team-06.jpg" alt="Teacher Image">

      <div class="detail">
        <h2>Manpreet Kaur</h2>
        <span>Operational Management</span>
        <p><i class="bx bx-location-plus"></i> CO Miego, AD, USA</p>
        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>

        <div class="icons">
          <i class="bx bxl-instagram"></i>
          <i class="bx bxl-twitter"></i>
          <i class="bx bxl-facebook"></i>
          <i class="bx bxl-linkedin"></i>
        </div>

        <a href="#"><i class="bx bx-phone"></i> +1-202-555-0174</a>
        <a href="#"><i class="bx bx-envelope"></i> example@gmail.com</a>
      </div>
    </div>

  </div> <!-- End box-container -->

</div> <!-- End teacher-section -->




    <?php include 'components/footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>
