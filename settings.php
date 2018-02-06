<?php include_once 'header.php' ?>
<section class="main-container">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  
  <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>


  <script>
    function _(el){
      return document.getElementById(el);
    }
    function uploadFile(){
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


    $(function() {
          $(".meter > span").each(function() {
            $(this)
              .data("origWidth", $(this).width())
              .width(0)
              .animate({
                width: $(this).data("origWidth")
              }, 1200);
          });
        });
  </script>
  <div class="page">
    
    <div class="box">
        <input type="file" name="file1" id="file1" method="post" onclick="enableBtn()" class="inputfile inputfile-4" style="width: 0px; height: 0px" >
        
        <label for="file1" style="margin-left: 200px"><span>Select File</span></label>
    </div>

    <script src="js/custom-file-input.js"></script>

    <input id="uploadBtn" type="button" value="Upload File" onclick="uploadFile()" style="margin-left: 200px" class="btn" disabled><br>
    


    <div class="meter red">
      <span id="progressBar"></span>
    </div>

  <h3 id="status"></h3>
	</div>    
</section>
<section>
    <div class="main-wrapper">
        <div class="box" style="float: right">
            <form method="post" action="server.php">
                <button id="uploadBtn" class="btn" style="float: left" type="submit" name="Regen" onclick="uploadProf">Regenerate Page</button>
            </form>
        </div>

        <div style="float: left;">
            <form method="post" action="server.php">
                <input type="text" name="header" placeholder="Header Color">
                <input type="text" name="body" placeholder="Body Color">
                <input type="text" name="side" placeholder="SideBar Color">
                <button type="submit" name="colour">Update Colours</button>
                <button type="submit" name="resetColour">Reset</button>
            </form>
        </div>
    </div>
</section>

<section>
    <?php
    $name = "";
    $detail = "";
    $id = "";
    if (isset($_GET['edit'])){
        $id = $_SESSION['u_id'];
        $detail = $_GET['edit'];
        if($detail == "first"){
            $detail = $_GET['edit'];
            $name = $_SESSION['u_first'];
        }
        if($detail == "last"){
            $detail = $_GET['edit'];
            $name = $_SESSION['u_last'];
        }
        if($detail == "email"){
            $detail = $_GET['edit'];
            $name = $_SESSION['u_email'];
        }
        if($detail == "username"){
            $detail = $_GET['edit'];
            $name = $_SESSION['u_uid'];
        }
    }
    
    echo("<table>");
        echo '<thread style="margin-top: 30px;">
                <tr>
                    <th cosplan="4">Actions for Editing</th>
                </tr> 
            </thread>
            <tbody>
            ';
            echo '
                <td>
                    <a href="settings.php?edit=first" class="edit_btn">Edit First Name</a>
                </td>
                <td>
                    <a href="settings.php?edit=last" class="edit_btn">Edit Last Name</a>
                </td>
                <td>
                    <a href="settings.php?edit=email" class="edit_btn">Edit Email</a>
                </td>
                <td>
                    <a href="settings.php?edit=username" class="edit_btn">Edit Username</a>
                </td>
                ';
            echo '</tr>';
        echo '</tbody>';
        //scan "uploads" folder and display them accordingly
    
    echo("</table>");
    echo '
        <form method="post" action="server.php">
            <input type="hidden" name="id" value="'.$id.'"> <!-- Need to Select User/ Dont Change -->
            <input type="hidden" name="type" value="'.$detail.'"> <!-- Need to know what to update -->
            
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" value="'.$name.'">
            </div>
            <div class="input-group">
                <button class="btn" type="submit" name="updateSetting" style="background: #5F9EA0;" >update</button>
            </div>
        </form>
        ';
    ?>
</section>
<?php include_once 'footer.php' ?>