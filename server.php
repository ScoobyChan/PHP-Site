<?php
// Initialize Variables
$name = "";
$pic = 0;
//session_start();
// Connect to database
$db = new SQLite3('includes/crud.db');
//

// Update Media
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $pic = $_POST['id'];
    
    $sql = "UPDATE media SET pic_name='$name' WHERE pic_loc='$pic'";
    
    $ret = $db->query($sql);
    header('Location: myfile.php?updated=' . $pic ); // Redirect to index page after inserting
}

// Update records
if(isset($_POST['cover'])){
    
    $name = $_POST['name'];
    $pic = $_POST['id'];
    
    $sql = "UPDATE media SET pic_cover='$name' WHERE pic_loc='$pic'";
    
    $ret = $db->query($sql);
    header('Location: vidSettings.php?file=' . $pic ); // Redirect to index page after inserting
}

// Delete records
if (isset($_GET['med'])) {
	$id = $_GET['med'];
    $filePath = 'pics/'.$id;

    // remove file if it exists
    if ( file_exists($filePath) ) {    
        $sql = "DELETE FROM media WHERE pic_loc='$id'";
        $ret = $db->query($sql);

        unlink($filePath);
        header('Location: media.php');
    }
}

// Delete records
if (isset($_GET['file'])) {    
	$id = $_GET['file'];
    $filePath = 'pics/'.$id;

    // remove file if it exists
    if ( file_exists($filePath) ) {
        $sql = "DELETE FROM media WHERE pic_loc='$id'";
        $ret = $db->query($sql);

        unlink($filePath);
        header('Location: myfile.php');
    }
}

// Update User
if(isset($_POST['updateSetting'])){
    session_start();
    $id = $_SESSION['u_id']; // ID for user
    $type = $_POST['type']; // What type needs updating
    $name = $_POST['name']; // What its getting updated to
    
    if($type == 'first'){
        $sql = "UPDATE user SET first='$name' WHERE id='$id'";
        $ret = $db->query($sql);
    }
    if($type == 'last'){
        $sql = "UPDATE user SET last='$name' WHERE id='$id'";
        $ret = $db->query($sql);
    }
    if($type == 'username'){
        $sql = "SELECT * FROM user WHERE uid='$uid'";
        $resultCheck = $db->querySingle("SELECT COUNT(*) as count FROM user WHERE uid='$name'"); 

        if ($resultCheck > 0) {
            header("Location: settings.php?change=usertaken");
            exit();
        }else{
            $sql = "UPDATE user SET uid='$name' WHERE id='$id'";
            $ret = $db->query($sql);
        }
    }
    if($type == 'email'){
        if(!filter_var($name, FILTER_VALIDATE_EMAIL)){
			header("Location: settings.php?change=invalidemail");
			exit();
		}else{
            $sql = "UPDATE user SET email='$name' WHERE id='$id'";
            $ret = $db->query($sql);
        }
    }
    include_once "includes/regen.inc.php";
}

// Create Database
if(isset($_POST['database'])){
    class MyDB extends SQLite3
    {
      function __construct()
      {
         $this->open('includes/crud.db');
      }
    }
    $db = new MyDB();

    
    if(!$db){
      echo $db->lastErrorMsg();
    } else {
      echo "Opened database successfully\n";
    }
    
    // Create Users
    $sql = "CREATE TABLE user (
        id INT(11) AUTO_INCREMENT PRIMARY KEY, 
        first VARCHAR(250) NOT NULL,
        last VARCHAR(250) NOT NULL,
        email VARCHAR(250) NOT NULL,
        uid VARCHAR(250) NOT NULL,
        pwd VARCHAR(250) NOT NULL, 
        position VARCHAR(250) NOT NULL, 
        profile VARCHAR(250) NOT NULL,
        body VARCHAR(250) NOT NULL,
        header VARCHAR(250) NOT NULL,
        side VARCHAR(250) NOT NULL,
        regen VARCHAR(250) NOT NULL
    )";

      $ret = $db->exec($sql);
       if(!$ret){
          echo $db->lastErrorMsg();
       } else {
          echo "Table created successfully\n";
       }

    // Create Pics
    $sql = "CREATE TABLE media (
        pics_id INT(11) AUTO_INCREMENT PRIMARY KEY, 
        pics_name VARCHAR(250) NOT NULL,
        pics_loc VARCHAR(250) NOT NULL,
        pics_user VARCHAR(250) NOT NULL,
        pics_cover VARCHAR(250) NOT NULL
    )";

    $ret = $db->exec($sql);
    if(!$ret){
      echo $db->lastErrorMsg();
    } else {
      echo "Table created successfully\n";
    }
    $db->close();   
}

// Position Admin - 5
if(isset($_POST['Admin'])){
    $id = $_POST['id'];
    
    $sql = "UPDATE user SET position='5' WHERE id='$id'";
    
    $ret = $db->query($sql);
    
    header("Location: users.php?user=$id");
}

// Position Anonymous - 1
if(isset($_POST['Anon'])){
    $id = $_POST['id'];
    
    $sql = "UPDATE user SET position='1' WHERE id='$id'";
    
    $ret = $db->query($sql);
    
    header("Location: users.php?user=$id");
}

// Position Moderator - 2
if(isset($_POST['Mod'])){
    $id = $_POST['id'];
    
    $sql = "UPDATE user SET position='2' WHERE id='$id'";
    $ret = $db->query($sql);
    
    header("Location: users.php?user=$id");
}

// Position Goose - 3
if(isset($_POST['Goose'])){
    $id = $_POST['id'];
    
    $sql = "UPDATE user SET position='3' WHERE id='$id';";
    $ret = $db->query($sql);
    
    header("Location: users.php?user=$id");
}

// Position Member - 0
if(isset($_POST['Member'])){
    $id = $_POST['id'];
    
    $sql = "UPDATE user SET position='0' WHERE id='$id'";
    $ret = $db->query($sql);
    
    header("Location: users.php?user=$id");
}

// Position Catfish - 4
if(isset($_POST['Catfish'])){
    $id = $_POST['id'];
    
    $sql = "UPDATE user SET position='4' WHERE id='$id';";
    $ret = $db->query($sql);
    
    header("Location: users.php?user=$id");
}

// Regenerate User
if (isset($_POST['Regen'])) {
    session_start();
    include_once "includes/regen.inc.php";

}

// Change site Colours
if (isset($_POST['colour'])) {
    session_start();
    $id = $_SESSION['u_id'];
	$body = $_POST['body'];
	$header = $_POST['header'];
    $side = $_POST['side'];
    
    if(empty($header)){
		$headerc = $_SESSION['u_header'];
	}elseif($header == '1'){
        $headerc = "#fff";
    }else{
        $headerc = $header;
    }
    
    if(empty($body)){
		$bodyc = $_SESSION['u_body'];
	}elseif($body == '1'){
        $bodyc = "#ccc";
    }else{
        $bodyc = $body;
    }
    
    if(empty($side)){
		$sidec = $_SESSION['u_side'];
	}elseif($side == '1'){
        $sidec = "#ddd";
    }else{
        $sidec = $side;
    }
    
    echo $id;
    //    Insert user into database
    $sql = "UPDATE user SET header='$headerc', body='$bodyc', side='$sidec' WHERE id='$id';";
    $ret = $db->query($sql);
    
    include_once 'includes/regen.inc.php';
}

// Reset Colours
if(isset($_POST['resetColour'])){
    session_start();
    $id = $_SESSION['u_id'];
    $sql = "UPDATE user SET header='0', body='0', side='0' WHERE id='$id';";
    $ret = $db->query($sql);
    
    $user = $id;
    include_once 'includes/regen.inc.php';
}
?>