<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: index.php');
}

if(isset($_POST['like_content'])){
    if($user_id != ' '){
        $content_id = $_POST['content_id'];
        $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
        $select_content->execute([$content_id]);
        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);

        $tutor_id = $fetch_content['tutor_id'];
        $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE content_id = ? AND user_id = ? LIMIT 1");
        $select_likes->execute([$content_id, $user_id]);        

        if($select_likes->rowCount() > 0){
            $delete_like= $conn->prepare("DELETE FROM `likes` WHERE content_id = ? AND user_id = ?");
            $delete_like->execute([$content_id, $user_id]);
            $message[] = 'removed from your likes!';
        }else{
            $insert_like = $conn->prepare("INSERT INTO `likes`(user_id, content_id, tutor_id) VALUES(?,?,?)");
            $insert_like->execute([$user_id, $content_id, $tutor_id]);
            $message[] = 'added to your likes!';
        }

    }else{
        $message[] = 'please login first!';
    }
}

if(isset($_POST['add_comment'])){
     if($user_id != ' '){
        $id = unique_id();
        $content_id = $_POST['content_id'];
        $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);
        $comment_box = $_POST['comment_box'];
        $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);

        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
        $select_content->execute([$content_id]);
        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
        $tutor_id = $fetch_content['tutor_id'];

        if($select_content->rowCount()> 0){
            $select_comment = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? AND user_id = ? LIMIT 1");
            $select_comment->execute([$content_id, $user_id]);

            if($select_comment->rowCount() > 0){
                $message[] = 'comment already added!';
            }else{
                $insert_comment = $conn->prepare("INSERT INTO `comments`(id, user_id, content_id, tutor_id, comment) VALUES(?,?,?,?,?)");
                $insert_comment->execute([$id, $user_id, $content_id, $tutor_id, $comment_box]);
                $message[] = 'comment added successfully!';
            }
        }
        else{
            $message[] = 'Something went wrong!';
        }
     }
     else{
        $message[] = 'please login first!';
     }
    }
    if(isset($_POST['delete_comment'])){
        $delete_id = $_POST['comment_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND user_id = ? LIMIT 1");
        $verify_comment->execute([$delete_id, $user_id]);

        if($verify_comment->rowCount() > 0){
            $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ? AND user_id = ? LIMIT 1");
            $delete_comment->execute([$delete_id, $user_id]);
            $message[] = 'comment deleted successfully!';
        }else{
            $message[] = 'comment already deleted!';
        }
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
    <title>HiStudy- PlaylistPage</title>

    <!-- Boxicons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>
<!-- Banner Section -->
<div class="banner">
  <div class="detail">
    <div class="title">
      <a href="index.php">home</a>
      <span> <i class="bx bx-chevron-right"></i>playlist</span>
    </div>
     
<h1>My Playlist</h1>
<p style="font-size: 25px;">Dive in and learn React.js from scratch! Learn Reactjs, Hooks, Redux, React Routing,
Animations, Next.js and way more!</p>
    <div class="flex-btn">
    <a href="login.php" class="btn">login to start</a>
    <a href="contact.php" class="btn">contact us</a>
    </div>
  </div>
  
<img src="image/about.png">
</div>

<!--------------------------Playlist Section------------------->
<section class="watch-video">
    <?php
    $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? AND status = ?");
    $select_content->execute([$get_id, 'active ']);

    if ($select_content->rowCount() > 0) {
        while ($row = $select_content->fetch(PDO::FETCH_ASSOC)){
            $content_id = $row['id'];
            $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE content_id = ? AND user_id = ? LIMIT 1");
            $select_likes->execute([$content_id, $user_id]);
            $total_likes = $select_likes->rowCount();

            $verify_likes = $conn->prepare("SELECT * FROM `likes` WHERE content_id = ? AND user_id = ? LIMIT 1");
            $verify_likes->execute([$content_id, $user_id]);

            $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
            $select_tutor->execute([$row['tutor_id']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

     ?>
     <div class="video-details">
        <video src="uploaded_files/<?= $row['video'];?>" class="video" poster="uploaded_files/<?= $row['thumb'];?>" controls autoplay></video>
        <h3 class="title"><?= $row['title']; ?></h3>
        <div class="info">
        <p>
        <i class="bx bxs-calendar-alt"></i><span><?= $row['date']; ?></span>
        </p>
        <p>
        <i class="bx bxs-heart"></i><span><?= $total_likes; ?></span>
        </p>
        </div>
        <div class="tutor">
            <?php
              $tutor_img = 'uploaded_files/'.$fetch_tutor['image'];
            ?>
            <img src="<?= (file_exists($tutor_img) ? $tutor_img : 'image/logo.png'); ?>" alt="tutor image">
             <div>
             <h3 class="tutor-name"><?= $fetch_tutor['name']; ?></h3>
             <span><?= htmlspecialchars($fetch_tutor['profession'] ?? '', ENT_QUOTES); ?></span>
             </div>

        </div>
        <form action="" method ="post" class="flex">
            <input type="hidden" name="content_id" value="<?= $content_id; ?>">
            <a href="playlist.php?get_id=<?= $row['playlist_id']; ?>" class="btn">View Playlist</a>

            <?php
            if ($verify_likes->rowCount() > 0) { ?>
                <button type = "submit" name="like_content"><i class="bx bxs-heart"></i><span>liked</span></button>
            <?php } else { ?>
                <button type = "submit" name="like_content"><i class="bx bxs-heart"></i><span>like</span></button>
            <?php } ?>
        </form>
        </div>
     <?php
        } 
    }else{
        echo '<p class="empty">No video found!</p>';
    }
     ?>

   
</section>
<!--------------------------comments Section------------------->
<section class="comments">
    <div class="heading">
        <h1>add a comment</h1>
    </div>
    <form action="" method="post" class="add-comment">
        <input type="hidden" name = "content_id" value="<?=$get_id;?>">
        <textarea name="comment_box"  placeholder="write your comment here..." maxlength="1000" cols="30" rows="10"required></textarea>
        <input type="submit" value="add comment" name="add_comment" class="btn">
    </form>

     <div class="heading">
        <h1>User comments</h1>
    </div>
    <div class="show-comments">
        <?php
        $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? ORDER BY id DESC");
        $select_comments->execute([$get_id]);
        if ($select_comments->rowCount() > 0) {
            while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
                $select_commentor->execute([$fetch_comment['user_id']]);
                $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
                if (!$fetch_commentor) {
                    // default values if user not found
                    $fetch_commentor = [
                        'image' => 'default-user.png',
                        'name'  => 'Unknown'
                    ];
                }
        ?>
        <div class="comment-box" style="<?php if($fetch_comment['user_id'] == $user_id){ echo 'order:-1;'; } ?>">
            <div class="user">
                <?php
                  $user_img = 'uploaded_files/'.$fetch_commentor['image'];
                ?>
                <img src="<?= (file_exists($user_img) ? $user_img : 'image/client-01.png'); ?>" alt="user image">
             <div>
             <h3><?= htmlspecialchars($fetch_commentor['name'], ENT_QUOTES); ?></h3>
             <span><?= htmlspecialchars($fetch_comment['date'], ENT_QUOTES); ?></span>
             </div>
            </div>

            <p class="text"><?= $fetch_comment['comment'];?></p>
            <?php
            if($fetch_comment['user_id'] == $user_id){ ?>
                <form action="" method="post" class="flex-btn">
                    <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                    <button type="submit" name="edit_comment" class="btn">edit</button>
                    <button type="submit" name="delete_comment" class="btn" onclick="return confirm('delete this comment');">delete</button>
                </form>
            <?php } ?>
            </div>
        <?php
            }
        } else {
            echo '<p class="empty">No comments yet!</p>';
        }
        ?>
    </div>
</section>
  <?php include 'components/footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>