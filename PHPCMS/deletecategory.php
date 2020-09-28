<?php require_once('Include/DB.php'); ?>
<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>

<?php

    if(isset($_GET['id'])){
        
        $categoryid = $_GET['id'];
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $query = "DELETE FROM category WHERE id='$categoryid'";
            $execute = mysqli_query($connection, $query);
            if($execute) {
                $_SESSION['success_message'] = "Category Deleted successfully.";
                redirect_to('categories.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong";
                redirect_to('categories.php');
            }

}
?>