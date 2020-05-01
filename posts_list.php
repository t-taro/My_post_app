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
          <li class="loggedin_menu"><a href="mypage.php">マイページ</a></li>
          <li class="loggedin_menu"><a href="logout.php">ログアウト</a></li>
        </ul>
      </nav>
      
      <?php
        }
        ?>
    </header>
    
    <main>
      <div id="white-cover" class="hidden"></div>
      
      <!-- <section class="welcome">
        <?php
          foreach($usersResult as $row){
            if ($row['email'] === $_SESSION['email']){
              echo "<p>ようこそ".$row['name']."さん</p>";
            };
          };
          ?>
      </section> -->
      
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
        <h1>Post list</h1>
        <ul id="post_items">
          <?php
          foreach($postsResult as $row){
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
              
              <!-- クラス名とカスタムデータ属性によってハートマークを差し替えている -->
              <?php
                if (!is_null($likesResult[0])){
                  foreach($likesResult as $likeRow){
                    if ($likeRow['post_id'] == $row['id']){
                      $heartClass = 'fas';
                      $likeStatus = 1;
                      break; //一致するレコードがあったらforeach処理を止める
                    } else {
                      $heartClass = 'far';
                      $likeStatus = 0;
                    }
                  };
                }elseif (is_null($likesResult[0])){
                  $heartClass = 'far';
                  $likeStatus = 0;
                };
              ?>
              
              <i class="<?= $heartClass ?> fa-heart" data-like-status = <?= $likeStatus ?> data-login-user = <?= $_SESSION['loginUserId'] ?> data-post-user = <?= $row['user_id'] ?>></i>
              <p><?= $row['state']; ?></p>
            </div>
          </li>
              
          <?php
            };
          ?>
          
        </ul>
      </section>
    </main>
    
  </div> 
  <script src="new_post.js"></script> 
  <script src="like_ajax.js"></script> 
</body>
</html>