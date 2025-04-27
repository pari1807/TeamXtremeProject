<?php
if (isset($message)) {
   foreach($message as $msg) {
      echo '
         <div class="message">
            <span>' . $msg . '</span>
            <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
         </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php">
         <img src="image/logo.png" width="130px" alt="Logo">
      </a>

      <nav class="navbar">
         <a href="index.php"><span>Home</span></a>
         <a href="about.php"><span>About Us</span></a>
         <a href="courses.php"><span>Courses</span></a>
         <a href="teachers.php"><span>Teachers</span></a>
         <a href="Dashboard/LearnEase.html"><span>LearnEase</span></a>
      </nav>

      <form action="search_course.php" method="post" class="search-form">
         <input 
            type="text" 
            name="search_course" 
            placeholder="Search course..." 
            required 
            maxlength="100"
         >
         <button type="submit" name="search_course_btn" title="Search">
            <i class="bx bx-search-alt-2"></i>
         </button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="bx bx-list-plus" title="Menu"></div>
         <div id="search-btn" class="bx bx-search-alt-2" title="Search"></div>
         <div id="user-btn" class="bx bxs-user" title="User"></div>
      </div>
      <div class="profile">
         <?php
            // Ensure $tutor_id is defined before using it
            if (!isset($tutor_id)) {
               $tutor_id = 0;
            }

            $select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $select_profile->execute([$user_id]);

            if ($select_profile->rowCount() > 0) {
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
               <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="<?= htmlspecialchars($fetch_profile['name']); ?>'s profile image">
               <h3><?= $fetch_profile['name']; ?></h3>
               <span>Student</span><br>

               <div id="flex-btn">
                  <a href="profile.php" class="btn">view profile</a>
                  <a href="components/admin_logout.php" onclick="return confirm('logout from this website?');" class="btn">logout</a>
               </div>

         <?php } else { ?>
               <h3>please login or register</h3>
               <div id="flex-btn">
                  <a href="admin/login.php" class="btn">login</a>
                  <a href="register.php" class="btn">register</a>
               </div>
         <?php } ?>
      </div>




   </section>

</header>
