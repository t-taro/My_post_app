<?php
  session_start();
  require_once(__DIR__."/get.php");
  
  // ログインしていない場合はログイン画面へ遷移する
  if (!isset($_SESSION['email'])){
    header('Location: /');
  };
  
  function h($message){
    return htmlspecialchars($message, ENT_QUOTES);
  };
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
      <div id="white-cover" class="hidden"></div>
      
      <section class="welcome">
        <?php
          foreach($usersResult as $row){
            if ($row['email'] === $_SESSION['email']){
              echo "<p>ようこそ！こちらは".$row['name']."さんのページです</p>";
            };
          };
          ?>
      </section>
      
      <section id="profile">
        <div id="about_me">
          <ul id="about_me_items">
            <?php
              foreach($usersResult as $row){
                if ($row['id'] == $_SESSION['loginUserId']){
                  if (!is_null($row['image'])){
                    $loginUserImage = $row['image'];
                  } else {
                    $loginUserImage = './user_images/default.png';
                  };
                  
                  if (!is_null($row['name'])){
                    $loginUserName = $row['name'];
                  };
                  
                  if (!is_null($row['birth'])){
                    $sql = 'select date_format(birth, "%Y-%m-%d") as formatedBirth from users where id = ' . $_SESSION['loginUserId'];
                    $stmt = $db->query($sql);
                    $formatBirthResult = $stmt->fetch(PDO::FETCH_ASSOC);
                    $loginUserBirth = $formatBirthResult['formatedBirth'];
                  };
                  
                  if (!is_null($row['address'])){
                    $loginUserAddress = $row['address'];
                  };
                  
                };
              };
            ?>
            <div id="profile_image_frame">
              <img src="<?= $loginUserImage ?>" id="profile_image">
            </div>
            <li>Name:<?= $loginUserName ?></li>
            <li>Birth:<?= $loginUserBirth ?></li>
            <li>Address:<?= $loginUserAddress ?></li>
          </ul>
          <a href="profile_update.php" class="profile_update">update</a>
        
        </div>
        <div id="post_status">
          <ul id="post_status_items"> 
            <li>
              <h1>Number of post</h1>
              <p><?= $myPostsCountResult[0]['post_cnt'] ?></p>
            </li>
            <li>
              <h1>Number of like</h1>
              <p><?= $myPostsCountResult[0]['sum_of_like'] ?></p>
            </li>
            <li>
              <h1>My like posts</h1>
              <p><?= $myLikeCountResult[0]['cnt'] ?></p>
            </li>
          </ul>
        </div>
      </section>
      
      <section id="add_new_post">
        <p id="open_post_area">New post</p>
        <div id="post-area" class="hidden">
          <form action="post_message.php" method="post">
            <i class="far fa-window-close"></i>
            <label for="new_post_title">Title</label>
            <input type="text" name="newPostTitle" id="new_post_title">
            <label for="new_post_title">Message</label>
            <textarea type="text" name="newPostMessage" id="new_post_title" rows="5"></textarea>
            <input type="submit" value="add new post">
          </form>
        </div>
      </section>
      
      <section id="posts_list">
        <h1>My Post list</h1>
        <ul id="post_items">
          <?php
          foreach($postsResult as $row){
            if ($row['user_id'] == $_SESSION['loginUserId']){
          ?>
          <li data-post-id = <?= $row['id']; ?>>
            <div class="post_item title">
              <h2>Title</h2>
              <p><?= h($row['title']); ?></p>
            </div>
            <div class="post_item message">
              <h2>Message</h2>
              <p><?= nl2br(h($row['message'])); ?></p>
            </div>
            <div class="post_item post_user">
              <h2>Post user</h2>
              <p><?= h($row['name']); ?></p>
            </div>
            <div class="post_item like">
              <i class="far fa-heart"></i>
              <p><?= $row['state']; ?></p>
            </div>
          </li>
              
          <?php
              }
            };
          ?>
          
        </ul>
      </section>
    </main>
    
  </div> 
  <script src="new_post.js"></script> 
</body>
</html>