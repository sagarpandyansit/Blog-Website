<?php require_once("Include/sessions.php"); ?>
<?php require_once('Include/functions.php'); ?>

<?php 

if(isset($_POST['submit']))
{
    
    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        
        //just for security.
        $username = mysqli_real_escape_string($connection , $username);
        $password = mysqli_real_escape_string($connection , $password);
        //this is prevent from your database to lost or don't allow 
        // or filter all the stuff.
    
   
    if(empty($username) || empty($password)) {
        $_SESSION['error_message'] = "All fields must be filled out.";            
       // redirect_to('adminlogin.php');
            
    } else {
        $foundacc = loginattempt($username, $password);
        if($foundacc){
            $_SESSION['adminid'] = $foundacc['id'];
            $_SESSION['adminname'] = $foundacc['username'];
            $_SESSION['success_message'] = "Welcome ".$username;
            redirect_to('dashboard.php');
        } else {
            $_SESSION['error_message'] = "Your credentials are wrong.";
            redirect_to('adminlogin.php');
        }
    }

}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="css/adminstyle.css">
    
    <style>
        
.FieldInfo {
    color: #1ab394;
    font-family: Bitter,Georgia,"Times New Roman", Times, serif;
    font-size: 1.2em;
}
body {
    background-color: #ffffff;            
}
        
    </style>
</head>
<body>
    <nav class="navbar nav-primary">
   <a class="navbar-brand" href="../ruft/index.php"><img style="margin-top; -12px;" src="../ruft/img/logo.png"></a>
    </nav>
       <div class="container-fluid">
        <div class="row">
            
           
            <!-- strarting of main area -->     
            <div class="col-sm-offset-4 col-sm-4">
                <br>
                <div><?php echo message(); 
                        echo SuccessMessage(); ?>
                </div>
                
                <h2>Admin Login</h2>
        <div>
            <form action="adminlogin.php" method="post">                 
              <fieldset>
               <div class="form-group">
               
                <label for="Username"><span class="FieldInfo">UserName:</span></label>
               <div class="input-group input-group-lg">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope text-primary"></span></span>
                 <input class="form-control" type="text" name="Username" id="Username" placeholder="UserName">
               </div>
               </div>
               <div class="form-group">
                <label for="Password"><span class="FieldInfo">Password:</span></label>
                <div class="input-group input-group-lg">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock text-primary"></span></span>
                 <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
                </div>
               </div>
               <br>
               <input class="btn btn-info btn-block" type="submit" name="submit" value="Login"><br>
             </fieldset>
            </form>
        </div>
            </div><!-- ending of main area -->
        </div><!-- ending of row -->
    </div><!-- ending of container fluid -->
    
    
</body>
</html>