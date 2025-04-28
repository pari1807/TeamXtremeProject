<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}



?>
<style>
    <?php include 'css/user_style.css'; ?>
</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HiStudy- Courses Page</title>

    <!-- Boxicons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<!---------------------------------- banner section------------------------------------- -->
<div class="banner">
  <div class="detail">
    <div class="title">
      <a href="index.php">home</a>
      <span> <i class="bx bx-chevron-right"></i> about </span>
    </div>
    <h1>Our Courses</h1>
    <p>Dive in and learn React.js from scratch! Learn Reactjs, Hooks, Redux, React Routing, Animations, Next.js and way more!</p>
    <div class="flex-btn">
      <a href="login.php" class="btn">login to start</a>
      <a href="contact.php" class="btn">contact us</a>
    </div>
  </div>
  <img src="image/about.png">
</div>

<!---------------------------courses----------------------------------->
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
        if (!$fetch_tutor) {
            $fetch_tutor = ['image' => 'default.png', 'name' => 'Unknown Tutor', 'profession' => ''];
        }
    ?>

    <div class="box">

      <div class="tutor">
        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="Tutor Image">
        <div>
          <h3><?= htmlspecialchars($fetch_tutor['name']); ?></h3>
          <span><?= htmlspecialchars($fetch_courses['date']); ?></span>
        </div>
      </div>

      <img src="uploaded_files/<?= $fetch_courses['thumb']; ?>" class="thumb" alt="Course Image">
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
</div>



    <?php include 'components/footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>
