<?php
session_start();

// ログインしていない場合はログイン画面へ遷移する
if (!isset($_SESSION['email'])){
  header('Location: /');
};

// ユーザーネーム、誕生日、住所を更新

if ($_POST["userName"] || $_POST["userBirth"] || $_POST["userAddress"]){
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $updateName = $_POST["userName"];
    $updateBirth = $_POST["userBirth"];
    $updateAddress = $_POST["userAddress"];
    
    $executeArray = array(':userId'=>$_SESSION['loginUserId']);
    $custom;
    
    if ($updateName){
      $custom = ' name = :updateName';
      $executeArray[':updateName'] = $updateName;
    };
    
    if ($updateBirth && $custom){
      $custom = $custom . ', ' . ' birth = :updateBirth';
      $executeArray[':updateBirth'] = $updateBirth;
    } elseif ($updateBirth){
      $custom = $custom . ' birth = :updateBirth';
      $executeArray[':updateBirth'] = $updateBirth;
    };
    
    if ($updateAddress && $custom){
      $custom = $custom . ', ' . ' address = :updateAddress';
      $executeArray[':updateAddress'] = $updateAddress;
    } elseif ($updateAddress){
      $custom = $custom . ' address = :updateAddress';
      $executeArray[':updateAddress'] = $updateAddress;
    };
    
    $sql = 'update users set' . $custom . ' where id = :userId'; 
    $stmt = $db->prepare($sql);
    
    $stmt->execute($executeArray);
    
    header('Location: /mypage.php');
    
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    exit;
  };
} else {
  echo "miss";
};