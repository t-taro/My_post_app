<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="index.css">
  <script src="https://kit.fontawesome.com/ea3c053da1.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <header>
      <h1>Posts</h1>
      <?php
        if ($_SESSION['email']){
      ?>
      <nav id="loggedin_nav">
        <ul id="loggedin_menus">
          <li class="loggedin_menu"><a href="posts_list.php">メインページ</a></li>
          <li class="loggedin_menu"><a href="logout.php">ログアウト</a></li>
        </ul>
      </nav>
      
      <?php
        }
        ?>
    </header>
    
    <main>
      <section class="update_profile">
        <img src="user_images/rider.png" alt="">
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <input type="file" name="userImage">
          <input type="submit" value="update">
        </form>
        
        <form action="profile_modify.php" method="post" id="profile_items">
          <label for="userName">Name</label>
          <input type="text" name="userName" value="<?= $_SESSION['loginUserName'] ?>">
          <label for="userBirth">Birth</label>
          <input type="text" name="userBirth" value="<?= $_SESSION['loginUserName'] ?>">
          <label for="userAddress">Address</label>
          <input type="text" name="userAddress" value="<?= $_SESSION['loginUserName'] ?>">
        </form>
        
      </section>
    </main>
  </div> 
  <script src="new_post.js"></script> 
</body>
</html>