<?php require_once('Include/DB.php'); ?>
<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>
<?php confirmlogin(); ?>
<?php 

if(isset($_POST['submit']))
{
        $category = $_POST['Category'];
        echo $category;
        //just for security.
        $category = mysqli_real_escape_string($connection , $category);
        //this is prevent from your database to lost or don't allow 
        // or filter all the stuff.
    
    date_default_timezone_set("Asia/Kolkata");
    $currTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currTime);
    $DateTime;
    $admin = $_SESSION['adminname'];
    if(empty($category)) {
        $_SESSION['error_message'] = "all fields must be filled out.";            
        redirect_to('categories.php');
            
    } elseif(strlen($category) > 99) {
        $_SESSION['error_message'] = "length must be less than 100";
        redirect_to('categories.php');
        
    } else {
        
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $query = "INSERT INTO category (datetime, name, creatorname) VALUES ('$DateTime', '$category', '$admin')";
           // $execute = mysqli_query($connection, $query);
            if(mysqli_query($connection, $query)) {
                $_SESSION['success_message'] = "Category added successfully.";
                redirect_to('categories.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong";
                redirect_to('categories.php');
            }
        }
}  
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
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
                    <li class="active"><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
                    <li><a href="admins.php"><span class="glyphicon glyphicon-user"></span> &nbsp;Manage admins</a></li>
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
                <h1>Manage Categories</h1>
                <div><?php echo message(); 
                        echo SuccessMessage(); ?></div>
        <div>
            <form action="categories.php" method="post">                 
              <fieldset>
               <div class="form-group">
                <label for="categoryname"><span class="FieldInfo">Name:</span></label>
                <input class="form-control" type="text" name="Category" id="categoryname" placeholder="name">
               </div> 
               <br>
               <input class="btn btn-info btn-block" type="submit" name="submit" value="Add New Category"><br>
             </fieldset>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Sr. No.</th>
                    <th>Date & Time</th>
                    <th>Category Name</th>
                    <th>Creator Name</th>
                    <th>Action</th>
                </tr>
            <?php 
                $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
                
                $view_query = "SELECT * FROM category ORDER BY datetime desc";
                $execute = mysqli_query($connection, $view_query);
                $srno = 0;
                while($row = mysqli_fetch_array($execute)) {
                    $categoryid = $row['id'];
                    $datetime = $row['datetime'];
                    $name = $row['name'];
                    $creatorname = $row['creatorname'];
                    $srno++;
            ?>
            <tr>
                <td><?php echo $srno ?></td>
                <td><?php echo $datetime ?></td>
                <td><?php echo $name ?></td>
                <td><?php echo $creatorname ?></td>
                <td><a href="deletecategory.php?id=<?php echo $categoryid; ?>"><span class="btn btn-danger">Delete</span></a></td>
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