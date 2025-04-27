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
      <span> <i class="bx bx-chevron-right"></i> teachers </span>
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
<section class="teachers">
    <div class="heading">
        <h1>Expert Tutors</h1>
    </div>

    <form action="search-tutor.php" method="post" class="search-tutor">
        <input type="text" name="search_tutor" placeholder="search tutors..." maxlength="100"class="box">
        <button type="submit" class="search_tutor_btn" class="bx bx-search-alt-2">Search</button>
    </form>
    <div class="box-container">
        <div class="box">
            <h3>become a tutor</h3>
            <p style="margin-bottom: 1.5rem;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quaerat, officiis porro aut tempora quae hic doloribus </p>
            <a href="admin/register.php" class="btn" style="margin-top: 1.5rem;">get started</a>
        </div>
        <?php
         $select_tutor = $conn->prepare("SELECT * FROM `tutors`");
            $select_tutor->execute();
            if ($select_tutor->rowCount() > 0) {
                while ($fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC)) {
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
        ?>
        <div class="box">
            <div class="tutor">
                  <img src="uploaded_files/<?= $fetch_tutor['image']?>" alt="">
                    <div>
                        <h3><?= $fetch_tutor['name']?></h3>
                        <span><?= $fetch_tutor['profession']?></span>
                    </div>
                </div>
                <p>playlist: <span><?= $total_playlists; ?></span></p>
                <p>total contents: <span><?= $total_contents; ?></span></p>
                <p>total likes: <span><?= $total_likes; ?></span></p>
                <p>total comments: <span><?= $total_comments; ?></span></p>
            <form action="tutor_profile.php" method="post">
                <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']?>">
                <input type="submit" value="view profile" class="btn" name="tutor_fetch">
            </form>
        </div>
        <?php
                }
                }else {
                    echo '<p class="empty">no tutors found!</p>';
                }
 
        ?>
    </div>
</section>
    <?php include 'components/footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>