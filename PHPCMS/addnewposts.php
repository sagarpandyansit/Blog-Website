<?php require_once('Include/DB.php'); ?>
<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>
<?php confirmlogin(); ?>
<?php 

if(isset($_POST['submit']))
{
        $title = $_POST['Title'];
        $category = $_POST['Category'];
       // $image = $_POST['Image'];
        $post = $_POST['Post'];
        
        //just for security.
        $category = mysqli_real_escape_string($connection , $category);
    $title = mysqli_real_escape_string($connection , $title);
       // $image = mysqli_real_escape_string($connection , $image);
        $post = mysqli_real_escape_string($connection , $post);
        //this is prevent from your database to lost or don't allow 
        // or filter all the stuff.
    
    date_default_timezone_set("Asia/Kolkata");
    $currTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currTime);
    $DateTime;
    $admin = $_SESSION['adminname'];
    $Image = $_FILES["Image"]['name'];
    $imagepath = "upload/".basename($Image);
    if(empty($title)) {
        $_SESSION['error_message'] = "title must be filled out.";            
        redirect_to('addnewposts.php');
            
    } elseif(strlen($title) < 2) {
        $_SESSION['error_message'] = "length must be greater than 2";
        redirect_to('addnewposts.php');
        
    } else {
        
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    
        $query = "INSERT INTO admin_panel (datetime, title, category, author, image, post) VALUES ('$DateTime', '$title', '$category', '$admin', '$Image', '$post')";
            $execute = mysqli_query($connection, $query);
            move_uploaded_file($_FILES['Image']['tmp_name'], $imagepath);
            if($execute) {
                $_SESSION['success_message'] = "Post added successfully.";
                redirect_to('addnewposts.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong";
                redirect_to('addnewposts.php');
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
                    <li class="active"><a href="addnewposts.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add new posts</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
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
                <h1>Add New Post</h1>
                <div><?php echo message(); 
                        echo SuccessMessage(); ?></div>
        <div>
            <form action="addnewposts.php" method="post" enctype="multipart/form-data">                 
              <fieldset>
               <div class="form-group">
                <label for="Title"><span class="FieldInfo">Title:</span></label>
                <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
               </div> 
               <div class="form-group">
                <label for="CategoryName"><span class="FieldInfo">Category:</span></label>
                <select name="Category" id="CategoryName" class="form-control">
                    
                 <?php 
                    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
                
                    $view_query = "SELECT * FROM category ORDER BY datetime desc";
                    $execute = mysqli_query($connection, $view_query);
                
                    while($row = mysqli_fetch_array($execute)) {
                        $name = $row['name'];
                ?>
               <option><?php echo $name ?></option>
                <?php } ?>
                </select>
                </div>
                <div class="form-group">
                    <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                    <input type="file" id="imageselect" class="form-control" name="Image">
                </div>
                <div class="form-group">
                    <label for="postarea"><span class="FieldInfo">Post:</span></label>
                    <textarea class="form-control" name="Post" id="postarea" rows="8"></textarea>
                </div>
               <br>
               <input class="btn btn-info btn-block" type="submit" name="submit" value="Add New Post"><br>
             </fieldset>
            </form>
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