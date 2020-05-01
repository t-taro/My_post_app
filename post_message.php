<?php
  session_start();
  
    try {
      $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
      $db = new PDO($dsn, 'testuser', 'pass');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $newPostTitle = $_POST['newPostTitle'];
      $newPostMessage = $_POST['newPostMessage'];
      $loginUserId = $_SESSION['loginUserId'];
      
      $sql = 'insert into posts (title, message, user_id) values (:newPostTitle, :newPostMessage, :loginUserId)';  
      $stmt = $db->prepare($sql);
      
      $executeArray = array(':newPostTitle'=>$newPostTitle, ':newPostMessage'=>$newPostMessage, ':loginUserId'=>$loginUserId);
      
      $stmt->execute($executeArray);
      
      header('Location: /posts_list.php');
    } catch (PDOException $e) {
      $errorMessage = $e->getMessage();
      
      // if ($e->errorInfo[1] = 1064){
      //   echo 'Error：すでに『'.$newTitle.'』は登録されています。';  
      // }
        
      exit;
    }