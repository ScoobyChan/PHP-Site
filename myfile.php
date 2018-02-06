<?php 
    include_once 'header.php';
    $db = new SQLite3('includes/crud.db');
?>

<!-- File Upload Content -->
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
  ajax.open("POST", "uploadFile.php");
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
    
<?php $user = $_SESSION['u_uid']; ?>

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

<!-- Display Media -->
<section class="main-container">
    <?php
    // Includes
    include_once 'server.php';
    
    // Edit file names
            if(isset($_GET['edit'])){
                $pic = $_GET['edit'];
                $sql = "SELECT * FROM media WHERE pic_loc='$pic'";
                
                $ret = $db->query($sql);
                $record = $ret->fetchArray(SQLITE3_ASSOC);
                
                $name = $record['pic_name'];
                $pic = $record['pic_loc'];
            }
    
    //      Input Box
        echo '
        <form method="post" action="server.php">
            <input type="hidden" name="id" value="'.$pic.'">
            
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" value="'.$name.'">
            </div>
            <div class="input-group">
                <button class="btn" type="submit" name="update" style="background: #5F9EA0;" >update</button>
            </div>
        </form>
        ';
    
    $sql = "SELECT * FROM media WHERE pic_user='$user'";
    $ret = $db->query($sql);
    
    echo("<table>");
        echo '<thread>
                <tr>
                    <th>Media Preview</th>
                    <th>Picture Name</th>
                    <th cosplan="2">action</th>
                </tr> 
            </thread>
            <tbody>
            ';
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $file_ext = explode('.', $row['pic_loc']);
            $file_ext = strtolower(end($file_ext));
            
            $picture = array('jpeg', 'gif', 'jpg', 'png');
            
            if(in_array($file_ext, $picture)){
                // Displayed rows
                echo '<td><img src="pics/' . $row['pic_loc'] .'" alt="..." class="media" style="padding: 5px; margin-bottom: 0px;"></td>';
            }else{
                echo '<td><video class="media" controls><source src="pics/' . $row['pic_loc'].'" type="video/mp4"></video></td>';
            }    
            
            echo '<td>' . $row['pic_name'] . '</td>';
    //      Fetch the record to be updated
            echo '
                <td>
                    <a href="myfile.php?edit='.$row['pic_loc'].'" class="edit_btn">Edit</a>
                </td>
                <td>
                    <a href="server.php?file='.$row['pic_loc'].'" class="del_btn">Delete</a>
                </td>
                ';
            echo '</tr>';
                 
            }
        echo '</tbody>';
        //scan "uploads" folder and display them accordingly
    
    echo("</table>");
    
    ?>
</section>

<?php include_once 'footer.php'; ?>