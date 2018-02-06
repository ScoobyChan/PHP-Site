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

    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    $picture = array('jpeg', 'gif', 'jpg', 'png');
    if(in_array($file_ext, $allowed)){
        if($file_error === 0){  
            $file_name_new = uniqid('', true) . "." . $file_ext;
            $id = $_SESSION['u_id'];
            $pof = $_SESSION['u_prof'];
            $db = new SQLite3('includes/crud.db');

            if($pof != '0'){
                
                $filePath = 'profile/'.$pof;
                // remove file if it exists
                if ( file_exists($filePath) ) {
                    unlink($filePath);
                }
            }
            
            $file_destination = 'profile/' . $file_name_new;
            
            $sql = "UPDATE user SET profile='$file_name_new' WHERE id='$id'";
            $ret = $db->query($sql);
            
      if(move_uploaded_file($fileTmpLoc, $file_destination)){
          
          // Check destroyed time-stamp
            if (isset($_SESSION['destroyed'])
                && $_SESSION['destroyed'] < time() - 300) {
                // Should not happen usually. This could be attack or due to unstable network.
                // Remove all authentication status of this users session.
                remove_all_authentication_flag_from_active_sessions($_SESSION['u_id']);
                throw(new DestroyedSessionAccessException);
            }
            $id = $_SESSION['u_id'];

            $SesID = uniqid('', true);
            $db = new SQLite3('includes/crud.db');

            $sql = "UPDATE user SET regen='$SesID' WHERE id='$id'";
            $ret = $db->query($sql);

            // Set destroyed timestamp
            $_SESSION['destroyed'] = time(); // Since PHP 7.0.0 and up, session_regenerate_id() saves old session data

            // New session does not need destroyed timestamp
            unset($_SESSION['destroyed']);

            $sql = "SELECT * FROM user WHERE regen = '$SesID'";
            $ret = $db->query($sql);

            if ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                //log in user
                $_SESSION['u_id'] = $row['id'];
                $_SESSION['u_first'] = $row['first'];
                $_SESSION['u_last'] = $row['last'];
                $_SESSION['u_email'] = $row['email'];
                $_SESSION['u_uid'] = $row['uid'];
                $_SESSION['u_pos'] = $row['position'];
                $_SESSION['u_prof'] = $row['profile'];
                $_SESSION['u_header'] = $row['header'];
                $_SESSION['u_body'] = $row['body'];
                $_SESSION['u_side'] = $row['side'];

                $user = $_SESSION['u_id'];
            }
          header("Refresh: 10");
          exit();
      }

    } else {
      echo "There is an error";
    }
  }else{
    echo "You can not upload files of this type";
  }
?>