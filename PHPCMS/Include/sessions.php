<?php

session_start();
function message() {
    if(isset($_SESSION['error_message'])) {
        $output = "<div class=\"alert alert-danger\">";
        $output.=htmlentities($_SESSION['error_message']);
        $output.="</div>";
        $_SESSION['error_message'] = null;
        return $output;
    }
}

function successMessage() {
    if(isset($_SESSION['success_message'])) {
        $output = "<div class=\"alert alert-success\">";
        $output.=htmlentities($_SESSION['success_message']);
        $output.="</div>";
        $_SESSION['success_message'] = null;
        return $output;
    }
}

?>