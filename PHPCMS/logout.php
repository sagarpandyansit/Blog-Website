<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>
<?php 

session_destroy();

$_SESSION['adminpanel'] = null;
redirect_to('adminlogin.php');


?>