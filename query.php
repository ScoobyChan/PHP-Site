<?php
$db = new SQLite3('includes/crud.db');

$results = $db->query('SELECT * FROM user WHERE id="3"');
while ($row = $results->fetchArray()) {
    echo $row['uid'];
}
?>