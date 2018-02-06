<?php
if (isset($_POST['submit'])) {
	
	$db = new SQLite3('crud.db');

	$first = $_POST['first'];
	$last = $_POST['last'];
	$email = $_POST['email'];
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];

	//Error Handlers
	//Check for empty fields

	if(empty($first) || empty($last) || empty($pwd) || empty($email) || empty($uid)){
		header("Location: ../signup.php?signup=empty");
		exit();
	}else{
		//Check Email valid
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: ../signup.php?signup=invalidemail");
			exit();
		}else{
            $sql = "SELECT * FROM user WHERE uid='$uid'";
            $resultCheck = $db->querySingle("SELECT COUNT(*) as count FROM user WHERE uid='$uid'");            

			if ($resultCheck > 0) {
				header("Location: ../signup.php?signup=usertaken");
				exit();
			}else{
				//Hashing password
				$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
				//Insert user into database
				$sql = "INSERT INTO user (first, last, email, uid, pwd, profile, position, header, body, side, regen) VALUES ('$first','$last', '$email', '$uid', '$hashedPwd', '0', '0', '0', '0', '0', '0');";
				$db->exec($sql);
//                
                echo 'Success';
                    $sql = "SELECT * FROM user WHERE uid='$uid'";
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
                        $_SESSION['u_reg'] = $row['regen'];
//                        header("Location: ../index.php?login=success");
//                        exit();
                        echo $row['first'].' '.$row['last'].'   '.$row['id'];
                    }
                }
            }
        }
}else{
	header("Location: ../signup.php");
	exit();
}