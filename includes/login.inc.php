<?php

session_start();

if (isset($_POST['submit'])) {
	$db = new SQLite3('crud.db');

	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];

	//Error Handlers
	//Check if inputs are empty

	if (empty($uid) || empty($pwd)) {
		header("Location: ../index.php?login=empty");
		exit();
	}else{
		$resultCheck = $db->querySingle("SELECT COUNT(*) as count FROM user WHERE uid='$uid' OR email='$uid'");            

		echo $resultCheck;

		if ($resultCheck < 1) {
			header("Location: ../index.php?login=error");
			exit();
		}else{
            $sql = "SELECT * FROM user WHERE uid='$uid'";
            $ret = $db->query($sql);
			if ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
				//De-hashing the password
				$hashedPwdCheck = password_verify($pwd, $row['pwd']);
				if ($hashedPwdCheck == false) {
					header("Location: ../index.php?login=error");
					exit();
				}elseif ($hashedPwdCheck == true) {
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
                    header("Location: ../index.php?login=success");
					exit();
				}
			}
		}
	}

}else{
	header("Location: ../index.php?login=error");
	exit();
}
