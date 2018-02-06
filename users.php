<?php
    include_once 'header.php';
    $db = new SQLite3('includes/crud.db');
?>

<script>
    function _(el){
      return document.getElementById(el);
    }
    function uploadProf(){
      var file = _("file1").files[0];
      // alert(file.name+" | "+file.size+" | "+file.type);
      var formdata = new FormData();
      formdata.append("file1", file);
      var ajax = new XMLHttpRequest();
      ajax.upload.addEventListener("progress", progressHandler, false);
      ajax.addEventListener("load", completeHandler, false);
      ajax.addEventListener("error", errorHandler, false);
      ajax.addEventListener("abort", abortHandler, false);
      ajax.open("POST", "uploadProf.php");
      ajax.send(formdata);
    }
    function progressHandler(event){
      var percent = (event.loaded / event.total) * 100;
      $('.red > span').css('width', Math.round(percent) + '%');
      _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
    }
    function completeHandler(event){
      _("status").innerHTML = event.target.responseText;
      $('.red > span').css('width', '100%');
    }
    function errorHandler(event){
      _("status").innerHTML = "Upload Failed";
    }
    function abortHandler(event){
      _("status").innerHTML = "Upload Aborted";
    }

    function enableBtn(){
      document.getElementById("uploadBtn").disabled = false;
    }
</script>   
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

<section>
<?php
if(isset($_GET['user'])){
    $id = $_GET['user'];
    $results = $db->query("SELECT * FROM user WHERE id='$id'"); 
    $row = $results->fetchArray(SQLITE3_ASSOC);
    
}
?>

<div>
    <div class="grid">
        <?php

        $username = $row['position'];
        $prof = $row['profile'];
        
        if($username == 1){
            $posit = 'Anonymous';
            $user = 'Anonymous';
            $name = 'Not who you expect';
            $lname = '';
            $email = 'anonymous@gmail.com';
            if($_SESSION['u_id'] == $row['id']){
                $prof = $_SESSION['u_prof'];
                if($prof == '0'){
                    $prof = 'anonymous.png';
                }else{
                    $prof = $_SESSION['u_prof'];
                }
            }else{
                $prof = 'anonymous.png';
            }
        }elseif($username == 2){
            $posit = 'Moderator';
            $user = $row['uid'];
            if($prof == '0'){
                $prof = 'default.png';
            }else{
                $prof = $row['profile'];
            }
            $name = $row['first'];
            $lname = $row['last'];
            $email = $row['email'];
        }elseif($username == 3){
            $posit = 'Goose';
            $user = 'Goose Master';
            if($prof == '0'){
                $prof = 'default.png';
            }else{
                $prof = $row['profile'];
            }
            $name = 'The Real Goose';
            $lname = '';
            $email = $row['email'];
        }elseif($username == 4){
            $posit = 'CatFish';
            $user = $row['uid'];
            $prof = 'CatFish.jpg';
            $name = 'CatFish';
            $lname = '';
            $email = $row['email'];
        }elseif($username == 5){
            $posit = 'Admin';
            $user = $row['uid'];
            if($prof == '0'){
                $prof = 'default.png';
            }else{
                $prof = $row['profile'];
            }
            $name = $row['first'];
            $lname = $row['last'];
            $email = $row['email'];
        }else{
            $posit = 'Member';
            $user = $row['uid'];
            $name = $row['first'];
            $lname = $row['last'];
            $email = $row['email'];
            if($prof == '0'){
                $prof = 'default.png';
            }else{
                $prof = $row['profile'];
            }
        }
        
        echo '
        <h2 class="right vid" style="margin-top: 75px;">Name: ' . $name . ' ' . $lname . '</h2><br>
        <h2 class="right vid">Email: ' . $email . ' </h2><br>
        <h2 class="right vid">Username: ' . $user . ' </h2><br>
        <h2 class="right vid">Site Position: ' . $posit . ' </h2><br>
        <img src="profile/' . $prof . '" style="width: 400px; height: 400px; margin-top: -200px; border-radius: 50%; padding-left: 20px; padding: 20px;" class="left pic">';
        ?>
        
        <?php
            if($_SESSION['u_id'] == $row['id']){
                echo '<a href="settings.php" style="width: 160px; height: 5px; margin-left: 260px;" class="setting">Settings</a>';
            }
        ?>
    </div>
</div>
</section>
<!-- Administrator Section -->
<section>
    <div>
        <?php
            if($_SESSION['u_pos'] == '1' || $_SESSION['u_pos'] == '5'){
                echo '
                    <div class="dropdown">
                            <div>
                                <h2 style="margin-left: 40px; margin-top: -20px">Site Position</h2>
                            </div>
                            <div class="dropdown-content">
                                <form method="post" action="server.php">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button type="submit" name="Admin">Admin</button>
                                    <button type="submit" name="Anon">Anonymous</button>
                                    <button type="submit" name="Mod">Moderator</button>
                                    <button type="submit" name="Goose">Goose</button>
                                    <button type="submit" name="Member">Member</button>
                                    <button type="submit" name="Catfish">Catfish</button>
                                </form>
                            </div>
                        </div>
                ';
            }
        ?>
    </div>
</section>

<?php
    include_once 'footer.php';
?>