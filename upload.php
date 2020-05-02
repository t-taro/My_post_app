<?php
session_start();

// ログインしていない場合はログイン画面へ遷移する
if (!isset($_SESSION['email'])){
  header('Location: /');
};

// 画像ファイルの保存とdbにファイルパスを保存
$tempfile = $_FILES['userImage']['tmp_name'];
$filename = $_SESSION['loginUserId']."_".$_FILES['userImage']['name'];
$upload_dir = './user_images';

if (is_uploaded_file($tempfile)) {
  if (move_uploaded_file($tempfile, $upload_dir."/".$filename)){ 
    try {
      $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
      $db = new PDO($dsn, 'testuser', 'pass');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = 'update users set image = :filename where id = :userId'; 
      $stmt = $db->prepare($sql);
      
      $executeArray = array(':filename'=>$upload_dir."/".$filename, ':userId'=>$_SESSION['loginUserId']);
      
      $stmt->execute($executeArray);
      
      header('Location: /mypage.php');
    } catch (PDOException $e) {
      $errorMessage = $e->getMessage();
      exit;
    }
    
  } else {
    echo "ファイルをアップロードできません。";
  };
} else {
  echo "ファイルが選択されていません。";
};
