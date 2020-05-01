'use strict';

// 非同期でlike数をlike.phpに渡し、画面を更新する処理

const hearts = document.querySelectorAll('.fa-heart');
let postData = new FormData();
let likeCount;
hearts.forEach(heart => {
  heart.addEventListener('click', (e)=>{
    
    let loginUser = e.target.dataset.loginUser;
    let postUser = e.target.dataset.postUser;
    
    // 自分の投稿に対してはlikeができない仕組み
    if (loginUser !== postUser){
      
      let postId = parseInt(e.target.parentNode.parentNode.dataset.postId, 10);
      postData.append('postId', postId);
      
      let updateNum = e.target.parentNode.lastElementChild;
      likeCount = parseInt(updateNum.textContent, 10);
      
      // 現在のlikeStatusをlike.phpに渡す
      let likeStatus = e.target.dataset.likeStatus;
      postData.append('likeStatus', likeStatus);
      
      // likeStatusの状態に応じてlike数を加減
      if (likeStatus == 0){
        likeCount ++;
      } else if (likeStatus == 1) {
        likeCount --;
      };
      
      // 加減した後のlike数をdbに保存する
      postData.append('likeCount', likeCount);
      
      
      const xhr = new XMLHttpRequest();
      
      // post後の処理
      // dbが更新された後にUIが変わる
      xhr.addEventListener("load",function(e){
        if (this.readyState === 4) {
          if (this.status === 200){
            //このブロックの中にpostが完了した後の処理を書く
            
            // like数を更新
            updateNum.textContent = likeCount;
            
            // likeStatusの状態に応じてアイコンを入れ替え
            if (likeStatus == 0){
              heart.classList.remove('far');
              heart.classList.add('fas');
              heart.dataset.likeStatus = 1;
            } else if (likeStatus == 1) {
              heart.classList.remove('fas');
              heart.classList.add('far');
              heart.dataset.likeStatus = 0;
            };
          };
        };
      });
      xhr.open('POST', '/like.php'); //postを投げる先のパスを指定
      xhr.send(postData);
    };
  });
});

