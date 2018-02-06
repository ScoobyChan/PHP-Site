<?php include_once 'header.php' ?>

<section class="main-container">
<?php
    //-----------------------
    // Database
    $db = new SQLite3('includes/crud.db');
    //-----------------------
    $sql = "SELECT * FROM media";
    $ret = $db->query($sql);

    echo("<table>");
        echo '<thread>
                <tr>
                    <th>Media Preview</th>
                    <th>Picture Name</th>
                    <th>Picture User</th>
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
            echo '<td>' . $row['pic_user'] . '</td>';
    //      Fetch the record to be updated
            echo '</tr>';

            }
        echo '</tbody>';
        //scan "uploads" folder and display them accordingly

    echo("</table>");
?>
</section>

<?php include_once 'footer.php' ?>