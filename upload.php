<?php

$tempfile = $_FILES['userImage']['tmp_name'];
$filename = $_FILES['userImage']['name'];
$upload_dir = './user_images';

if (is_uploaded_file($tempfile)) {
  if (move_uploaded_file($tempfile, $upload_dir."/".$filename)){
    echo $filename . "をアップロードしました。";
  } else {
    echo "ファイルをアップロードできません。";
  };
} else {
  echo "ファイルが選択されていません。";
};