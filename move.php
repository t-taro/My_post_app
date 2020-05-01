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
    </header>
    <section>
      <p>
        <?php
          if (!isset($_SESSION['count'])){
            $_SESSION['count'] = 0;
          } else {
            $_SESSION['count']++;
          }
          
          echo $_SESSION['count'];
          echo $_SESSION['name'];
        ?>
      </p>
      
      <p class="sessionID">
        <?php
          // $sessionID = session_id();
          // echo $sessionID;
          var_dump($_SESSION);
        ?>
      </p>
      
      <a href="/">戻る</a>
    </section>
  </div>
</body>
</html>