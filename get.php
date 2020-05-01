<?php
  session_start();
  
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'select * from users';
    $stmt = $db->query($sql);
    $usersResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
  } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
  }
  
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'select posts.id, title, message, posts.state, posts.created_at, posts.updated_at, posts.user_id, users.name  from posts join users on posts.user_id = users.id order by posts.created_at desc';
    $stmt = $db->query($sql);
    $postsResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
  }
  
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'select * from likes where user_id = :loginUserId';
    $executeArray = array(':loginUserId'=>$_SESSION['loginUserId']);
    $stmt = $db->prepare($sql);
    $stmt->execute($executeArray);
    $likesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
  
  // ログインしているユーザーがpostした数とlikeされた数
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $sql = 'select user_id, count(user_id) as post_cnt, ifnull(sum(state), 0) as sum_of_like from posts where user_id = :loginUserId';
    $executeArray = array(':loginUserId'=>$_SESSION['loginUserId']);
    $stmt = $db->prepare($sql);
    $stmt->execute($executeArray);
    
    $myPostsCountResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
  }
  
  // ログインしているユーザーがlikeした数
  try {
    $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
    $db = new PDO($dsn, 'testuser', 'pass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'select user_id, count(post_id) as cnt from likes where user_id = :loginUserId';
    $executeArray = array(':loginUserId'=>$_SESSION['loginUserId']);
    $stmt = $db->prepare($sql);
    $stmt->execute($executeArray);
    
    $myLikeCountResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
  }
  
  
  