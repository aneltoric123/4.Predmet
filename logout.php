<?php
session_start();

setcookie('admin', '', time() - (86400 * 30), '/');
$_SESSION = array();
session_destroy(); 

header('Location: select_school.php');
exit();
?>