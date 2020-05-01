<?php
  session_start();
  
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'insert into users (name, email, password) values (:name, :email, :password)';
    $stmt = $db->prepare($sql);
    
    $reg_str = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
    
    if (preg_match($reg_str, $_POST['email'])){
      $userStatus = array(
                      ':name'=> $_POST['name'],
                      ':email'=> $_POST['email'],
                      ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                    );
              
      $stmt->execute($userStatus);
      
      header('Location: /');
    } else {
      echo '<p>emailが正しくありません。</p>';
      echo '<a href = "/">戻る</a>';
    }
    
    
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  } 
  