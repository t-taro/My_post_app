<?php
  session_start();
  
  // 既にログイン後の場合はログイン後の画面へ遷移する
  if (isset($_SESSION['email'])){
    header('Location: /posts_list.php');
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
    </header>
    
    <section class="login">
      <p>ログイン</p>
      <form action="login.php" method="post">
        <label>e-mail<input type="text" name="loginEmail" id="loginEmail"></label>
        <label>password<input type="password" name="loginPassword" id="loginPassword"></label>
        <input type="submit" value="Login">
      </form>
    </section>
    <div id="go-to-signin">
      <a href="/signin.html">新規登録はこちら</a>
    </div>
  </div>
</body>
</html>