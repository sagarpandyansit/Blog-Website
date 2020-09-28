<?php require_once('Include/DB.php'); ?>
<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>

<?php

    if(isset($_GET['id'])){
        
        $adminid = $_GET['id'];
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $query = "DELETE FROM registration WHERE id='$adminid'";
            $execute = mysqli_query($connection, $query);
            if($execute) {
                $_SESSION['success_message'] = "Admin Deleted successfully.";
                redirect_to('admins.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong";
                redirect_to('admins.php');
            }

}
?>