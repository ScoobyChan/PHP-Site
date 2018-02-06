<?php
session_start();
$file_name = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$file_error= $_FILES["file1"]["error"]; // 0 for false... and 1 for true
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
 // File Extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov');
    $picture = array('jpeg', 'gif', 'jpg', 'png');
    $db = new SQLite3('includes/crud.db');
    if(in_array($file_ext, $allowed)){
        if($file_error === 0){  
            $file_name_new = uniqid('', true) . "." . $file_ext;
            $picuser = $_SESSION['u_uid'];
            $loc = $file_name_new;
            $name = $file_name;
            
            $file_destination = 'pics/' . $file_name_new;
            
            $sql = "INSERT INTO media (pic_name, pic_loc, pic_user, pic_cover) VALUES ('$name', '$loc', '$picuser', '0');";
            $ret = $db->query($sql);
            
      if(move_uploaded_file($fileTmpLoc, $file_destination)){
          echo 'success please reload page';
      }

    } else {
      echo "There is an error";
    }
  }else{
    echo "You can not upload files of this type";
  }
?>