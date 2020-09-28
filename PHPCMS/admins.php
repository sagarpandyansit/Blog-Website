<?php require_once('Include/DB.php'); ?>
<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>
<?php confirmlogin(); ?>
<?php 

if(isset($_POST['submit']))
{
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $confirmpassword = $_POST['ConfirmPassword'];
    
        //just for security.
        $username = mysqli_real_escape_string($connection , $username);
        $password = mysqli_real_escape_string($connection , $password);
        $confirmpassword = mysqli_real_escape_string($connection , $confirmpassword);
        //this is prevent from your database to lost or don't allow 
        // or filter all the stuff.
    
    date_default_timezone_set("Asia/Kolkata");
    $currTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currTime);
    $DateTime;
    $admin = $_SESSION['adminname'];
    if(empty($username) || empty($password)) {
        $_SESSION['error_message'] = "All fields must be filled out.";            
        redirect_to('admins.php');
            
    } elseif(strlen($password) < 6) {
        $_SESSION['error_message'] = "password must be greter than 6 character.";
        redirect_to('admins.php');
    
    } elseif($password !== $confirmpassword) {
        $_SESSION['error_message'] = "password / confirm password does not match.";
        redirect_to('admins.php');
        
    } else {
        
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $query = "INSERT INTO registration (datetime, username, password, addedby) VALUES ('$DateTime', '$username', '$password', '$admin')";
           // $execute = mysqli_query($connection, $query);
            if(mysqli_query($connection, $query)) {
                $_SESSION['success_message'] = "Admin added successfully.";
                redirect_to('admins.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong";
               redirect_to('admins.php');
            }
        }
}  
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
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
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-sm-2">
                <a class="navbar-brand" href="../ruft/index.php"><img style="margin-top; -12px;" src="../ruft/img/logo.png"></a>
                <br><br><br><br><br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li><a href="addnewposts.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add new posts</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
                    <li class="active"><a href="admins.php"><span class="glyphicon glyphicon-user"></span> &nbsp;Manage admins</a></li>
                    <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> &nbsp;Comments
              <?php
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
        $querytotal = "SELECT COUNT(*) FROM comments WHERE status='OFF'";
        $totalexecute = mysqli_query($connection, $querytotal);
        $totalrow = mysqli_fetch_array($totalexecute);
        $total =  array_shift($totalrow);
    ?>
        <?php if($total > 0) { ?> 
        <span class="label pull-right label-warning"><?php echo $total ?></span>
        <?php } ?>
                    
                    </a></li>
                    <li><a href="../ruft/index.php" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> &nbsp;Live Blog</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout</a></li>
                </ul>
            </div> <!-- ending of sidearea -->
            
            <!-- strarting of main area -->     
            <div class="col-sm-10">
                <h1>Manage Admin Access</h1>
                <div><?php echo message(); 
                        echo SuccessMessage(); ?></div>
        <div>
            <form action="admins.php" method="post">                 
              <fieldset>
               <div class="form-group">
                <label for="Username"><span class="FieldInfo">UserName:</span></label>
                <input class="form-control" type="text" name="Username" id="Username" placeholder="UserName">
               </div>
               <div class="form-group">
                <label for="Password"><span class="FieldInfo">Password:</span></label>
                <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
               </div>
               <div class="form-group">
                <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
                <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="retype same password">
               </div> 
               <br>
               <input class="btn btn-info btn-block" type="submit" name="submit" value="Add New Admin"><br>
             </fieldset>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Sr. No.</th>
                    <th>Date & Time</th>
                    <th>Admin Name</th>
                    <th>Added By</th>
                    <th>Action</th>
                </tr>
            <?php 
                $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
                
                $view_query = "SELECT * FROM registration ORDER BY datetime desc";
                $execute = mysqli_query($connection, $view_query);
                $srno = 0;
                while($row = mysqli_fetch_array($execute)) {
                    $adminid = $row['id'];
                    $datetime = $row['datetime'];
                    $username = $row['username'];
                    $addedby = $row['addedby'];
                    $srno++;
            ?>
            <tr>
                <td><?php echo $srno ?></td>
                <td><?php echo $datetime ?></td>
                <td><?php echo $username ?></td>
                <td><?php echo $addedby ?></td>
                <td><a href="deleteadmin.php?id=<?php echo $adminid; ?>"><span class="btn btn-danger">Delete</span></a></td>
            </tr>
            
            <?php } ?>
            </table>
        </div>
            </div><!-- ending of main area -->
        </div><!-- ending of row -->
    </div><!-- ending of container fluid -->
    
    <div id="Footer">
        <hr><p>Theme By | Sagar Pandya | &copy;2019-2024 --- All right reserved. </p>
        <a style="color: white; text-decoration: none; cursor: pointer; font-weight:body;" href=""></a>
    </div>
    <div style="height: 10px; background: #27AAE1;"></div>
    
</body>
</html>