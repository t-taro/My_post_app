<?php
  session_start();
  
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // ログインするとemailでセッションを管理する
    if (!isset($_SESSION['email'])){
      
      $stmt = $db->prepare('select * from users where email = :email');
      $email = array(':email'=>$_POST['loginEmail']);
      $stmt->execute($email);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      // dbに該当するレコードが存在するか&&パスワードが合っているか
      if ($row['email'] && password_verify($_POST['loginPassword'], $row['password'])){
        $_SESSION['email'] = $row['email'];
        $_SESSION['loginUserId'] = $row['id'];
        $_SESSION['loginUserName'] = $row['name'];
        header('Location: /posts_list.php');
      } else {
        // emailまたはパスワードに誤りがある場合、ログイン画面に戻る
        // FIXME:このときログインページには「emailまたはパスワードに誤りがあります」と表示させたい
        echo '<p>emailまたはパスワードに誤りがあります。</p>';
        echo '<a href = "/">戻る</a>';
        // header('Location: /');
      };
    };
    
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  } 