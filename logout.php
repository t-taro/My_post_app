<?php
  session_start();
  
  $_SESSION = array();

  // セッションを切断するにはセッションクッキーも削除する。
  // Note: セッション情報だけでなくセッションを破壊する。
  //session_get_cookie_params():セッションクッキーのパラメータを得る
  //setcookie():クッキーを送信する
  //session_name():現在のセッション名を取得または設定する（デフォルトはPHPSESSID）
  //session_get_cookie_params()で現在のパラメータを取得して、setcookie関数の中ではクッキーを削除するために過去の時間を指定している。
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  };
  
  // 最終的に、セッションを破壊する
  session_destroy();
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
      
      <p id="logout"><a href="logout.php">ログアウト</a></p>
      
      <?php
        }
      ?>
    </header>
    
    <section>
      <p>ログアウトが完了しました。</p>
      <a href="/">ログインページへ戻る</a>
    </section>
  </div>  
</body>
</html>