<?php
  session_start();
  // like_ajax.jsから受け取ったlike数でDBを更新する

  try {
      $dsn = "mysql:host=post_mysql;dbname=post_app_db;";
      $db = new PDO($dsn, 'testuser', 'pass');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $postId = $_POST['postId'];
      $likeStatus = $_POST['likeStatus'];
      $likeCount = $_POST['likeCount'];
      
      // postsテーブルのlikeカウントの更新
      $sql = 'update posts set state = :likeCount where id = :postId';  
      $stmt = $db->prepare($sql);
      
      $executeArray = array(':likeCount'=>$likeCount, ':postId'=>$postId);
      
      $stmt->execute($executeArray);
      
      // likesテーブルに登録
      if ($likeStatus == 0){
        $sql = 'insert into likes (post_id, user_id) values (:post_id, :loginUserId)';
        $executeArray = array(':post_id'=>$postId, ':loginUserId'=>$_SESSION['loginUserId']);
      } else if ($likeStatus == 1){
        $sql = 'delete from likes where post_id = :post_id and user_id = :loginUserId';
        $executeArray = array(':post_id'=>$postId, ':loginUserId'=>$_SESSION['loginUserId']);
      };
      
      $stmt = $db->prepare($sql);
      
      $stmt->execute($executeArray);
      
    } catch (PDOException $e) {
      $errorMessage = $e->getMessage();
      
      // if ($e->errorInfo[1] = 1064){
      //   echo 'Error：すでに『'.$newTitle.'』は登録されています。';  
      // }
        
      exit;
    }