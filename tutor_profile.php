<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
 
if(isset($_POST['tutor_fetch'])){
    $tutor_email = $_POST['tutor_email'];
    $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? LIMIT 1");
    $select_tutor->execute([$tutor_email]);

    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    $tutor_id = $fetch_tutor['id'];

    $count_playlists = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
    $count_playlists->execute([$tutor_id]);
    $total_playlists = $count_playlists->rowCount();

    $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
    $count_contents->execute([$tutor_id]);
    $total_contents = $count_contents->rowCount();

    $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
    $count_likes->execute([$tutor_id]);
    $total_likes = $count_likes->rowCount();
    $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
    $count_comments->execute([$tutor_id]);
    $total_comments = $count_comments->rowCount();
}
else{
    header('location: teachers.php');
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
    <title>HiStudy- Teachers Page</title>

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
      <span> <i class="bx bx-chevron-right"></i> teacher profile </span>
    </div>
    <h1>Teachers</h1>
    <p>Dive in and learn React.js from scratch! Learn Reactjs, Hooks, Redux, React Routing, Animations, Next.js and way more!</p>
    <div class="flex-btn">
      <a href="login.php" class="btn">login to start</a>
      <a href="contact.php" class="btn">contact us</a>
    </div>
  </div>
  <img src="image/about.png">
</div>

<!--------------------------registration section----------------------------------->
<section class="tutor-profile">
    <div class="heading">
        <h1>Tutor Profile Details</h1>
    </div>

    <div class="details">
        <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image'];?>" alt="">
            <h3><?= $fetch_tutor['name']?></h3>
            <span><?= $fetch_tutor['profession']?></span>
        </div>
        <div class="flex">
        <p>playlist: <span><?= $total_playlists; ?></span></p>
        <p>total contents: <span><?= $total_contents; ?></span></p>
        <p>total likes: <span><?= $total_likes; ?></span></p>
        <p>total comments: <span><?= $total_comments; ?></span></p>

        </div>
    </div>
    
</section>

 <!--------------------------courses section----------------------------------->
 <div class="courses">

  <div class="heading">
    <span>Top Popular Courses</span>
    <h1>HiStudy course students <br> can join with us</h1>
  </div>

  <div class="box-container">

    <?php
    $select_courses = $conn->prepare("SELECT * FROM playlist WHERE tutor_id = ? AND status = ?");
    $select_courses->execute([$tutor_id,'active']);

    if ($select_courses->rowCount() > 0) {
      while ($fetch_courses = $select_courses->fetch(PDO::FETCH_ASSOC)) {
        $course_id = $fetch_courses['id'];

        $select_tutor = $conn->prepare("SELECT * FROM tutors WHERE id = ?");
        $select_tutor->execute([$fetch_courses['tutor_id']]);
        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
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