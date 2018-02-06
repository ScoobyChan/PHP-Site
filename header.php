<?php
    session_start();
    $db = new SQLite3('includes/crud.db');
?>


<html>
    <head>
        <link rel="shortcut icon" href="bird.ico">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> MySite </title>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/sidebar.css" rel="stylesheet">
        
        <?php
            if (isset($_SESSION['u_id'])) {
                if($_SESSION['u_body'] == '0'){
                    $body = '#ccc';
                }else{
                    $body = $_SESSION['u_body'];
                }
            }else{
                $body = '#ccc';
            }
            
            if (isset($_SESSION['u_id'])) {
                if($_SESSION['u_header'] == '0'){
                    $header = '#fff';
                }else{
                    $header = $_SESSION['u_header'];
                }
            }else{
                $header = '#fff';
            }
        
            if (isset($_SESSION['u_id'])) {
                if($_SESSION['u_side'] == '0'){
                    $side = '#ddd';
                }else{
                    $side = $_SESSION['u_side'];
                }
            }else{
                $side = '#ddd';
            }
        ?>
        
        <style>
            body{
                background-color: <?php echo $body?>;
            }
/*Changed*/
            header nav{
                width: 100%;
                height: 40px;
                background-color: <?php echo $header ?>;
            }
/*            */
            .openbtn{
                line-height: 35px;    
                float: left;
                list-style: none;
                display: block;
                width: 80px;
                border: none;
                margin-right: 40px;
                background-color: #fff;
                font-size: 16px;
                font-family: arial;
                color: #111;
                margin-left: 160px;
            }
            
            .sidenav h2 {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: #111;
                display: block;
                margin-left: 30px;
                transition: 0.3s;
            }

            
            /*      SideBar      */
            .sidenav {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: <?php echo $side ?>;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 40px;
            }
            
            .sidenav a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }
        </style>
        
        <script>
            function w3_open() {
                document.getElementById("main").style.marginLeft = "15%";
                document.getElementById("mySidenav").style.width = "25%";                
            }
            function w3_close() {
                document.getElementById("main").style.marginLeft = "-5%";
                document.getElementById("openNav").style.display = "inline-block";
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>
    </head>
<body>

<header>
	<nav>
		<div class="main-wrapper">
<!--     SideBar       -->
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="w3_close()">&times;</a>
                <a href="index.php">Home</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
                <a href="media.php">Media</a>
                    <?php
                        if (isset($_SESSION['u_id'])) {
                            if($_SESSION['u_pos'] == '2' || $_SESSION['u_pos'] == '1'){
                                echo '<a href="query.php">Testing Page</a>';
                            }
                        }
                    ?>
                <h2 style="margin-left: 50px;">Users</h2>
                
                <div>
                    <?php
                    // Access Database
                    $db = new SQLite3('includes/crud.db');
                    
                    $query="SELECT * FROM user";
                    echo("<table>");
                    $ret = $db->query($query);
                    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){

                    
                        if ($row['position'] == '1'){
                            $pic = 'anonymous.png';
                            $name = 'Anonymous';
                        }elseif($row['position'] == '4'){
                            $pic = 'CatFish.jpg';
                            $name = 'C@tFish';
                        }elseif($row['position'] == '3'){
                            $pic = 'goose.png';
                            $name = 'The Almighty Goose';
                        }else{
                            if($row['profile'] == '0'){
                                $pic = 'default.png';
                            }else{
                                $pic = $row['profile'];
                            }
                            $name = $row['uid'];
                        }                            
                        
                        
                        
                        echo '<td><img src="profile/' . $pic .'" alt="..." class="media" style="padding: 5px; margin-right: 20px; border-radius: 50%;"></td>';
                        echo '<td><a href="users.php?user='.$row['id'].'">' . $name . '</a></td>';
                //      Fetch the record to be updated
                        echo '</tr>';

                        }
                    echo '</tbody>';
                    //scan "uploads" folder and display them accordingly

                echo("</table>");
                ?>
                    </div>
              
            </div>
<!--     Be inside id="main" to be moved by scripts       -->
            <div id="main" style="margin-left: -80">
                <ul>
                    <button id="openNav" class="openbtn" onclick="w3_open()">Menu</button>
                    <li style="margin-top: 15px;">MySite</li>
                    <li><img src="bird.ico" style="width: 30px; height: 30px; margin-top: 5px; margin-left: 5px; border-radius: 50%;"></li>
                </ul>
            </div>
            
			<div class="nav-login">        
                    <?php
					if (!isset($_SESSION['u_id'])) {
						echo '<form action="includes/login.inc.php" method="POST">
								<input type="text" name="uid" placeholder="Username">
								<input type="password" name="pwd" placeholder="Password">
								<button type="submit" name="submit">Login</button>
								</form>
							 <a href="signup.php">Sign up</a>';
                        }
                    ?>
                </div>
                
                <div class="nav-login">
                <?php
                    if(isset($_SESSION['u_id'])){
                        if($_SESSION['u_prof'] == 0){
                            $prof = 'default.png';
                        }else{
                            $prof = $_SESSION['u_prof'];
                        }
                    echo '
                    <div class="dropdown" style="margin-right: 50px;">
                        <div>
                            <img src="profile/' . $prof . '" style="width: 30px; height: 30px; margin-top: 3px; margin-left: 5px; border-radius: 50%;">
                            <h2 style="margin-left: 40px; margin-top: -20px">'. $_SESSION['u_uid'] .'</h2>
                        </div>
                        <div class="dropdown-content" style="margin-top: 5px;">
                            <h2 style="padding: 10px;">' . $_SESSION['u_first'] . ' ' . $_SESSION['u_last'] . '</h2>
                            <a href="users.php?user='.$_SESSION['u_id'].'" style="width: 160px;">Profile</a>
                            <!-- <a href="pic.php" style="width: 160px;">Picture Upload</a> -->
                           <!--  <a href="vid.php" style="width: 160px;">Video Upload</a> -->
                            <a href="myfile.php" style="width: 160px;">My Files</a>
                            <a href="settings.php" style="width: 160px;">Settings</a>
                            <a href="includes/logout.inc.php" style="width: 160px;">Logout</a>
                        </div>
                    </div>
                    ';
                }
                ?>    
            </div>    
		</div>
        
	</nav>
</header>