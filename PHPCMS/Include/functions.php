<?php

function redirect_to($new_location) {
    header("Location:".$new_location);
    exit;
}

function loginattempt($username, $password) {
    
    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $query = "SELECT * FROM registration WHERE username='$username' AND password='$password'";
            $execute = mysqli_query($connection, $query);
            if($admin=mysqli_fetch_assoc($execute)) {
                return $admin;
            } else {
                return null;
            }
}

function islogin() { 
    if(isset($_SESSION['adminid'])) {
        return true;
    } else {
        return false;
    }
}

function confirmlogin() {
    if(!islogin()) {
        $_SESSION['error_message'] = "Login Required";
        redirect_to('adminlogin.php');
    }
}

?>
