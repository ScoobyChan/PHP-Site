<?php
// NOTE: This code is not fully working code, but an example!
session_start();
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
    header("Location: settings.php?user=$user");
    exit();
}
?>