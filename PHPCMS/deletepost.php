<?php require_once('Include/DB.php'); ?>
<?php require_once('Include/sessions.php'); ?>
<?php require_once('Include/functions.php'); ?>
<?php confirmlogin(); ?>
<?php 

if(isset($_POST['submit']))
{
       
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
        $deleteid = $_GET['delete'];
        $query = "DELETE FROM admin_panel WHERE id='$deleteid'";
        
        $execute = mysqli_query($connection, $query);
            
            if($execute) {
                $_SESSION['success_message'] = "Post updated successfully.";
                redirect_to('dashboard.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong";
                redirect_to('dashboard.php');
            }
}  
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete post</title>
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
                <br><br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li class="active"><a href="addnewposts.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add new posts</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-user"></span> &nbsp;Manage admins</a></li>
                    <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> &nbsp;Comments</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-equalizer"></span> &nbsp;Live Blog</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout</a></li>
                </ul>
            </div> <!-- ending of sidearea -->
            
            <!-- strarting of main area -->     
            <div class="col-sm-10">
                <h1>Delete Post</h1>
                <div><?php echo message(); 
                        echo SuccessMessage(); ?></div>
                        
        <div>
           <?php 
            
            $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
            
            if(isset($_GET['delete'])) { $postid = $_GET['delete']; }
            else { $postid = 9; }
            
            $viewquery = "SELECT * FROM admin_panel where id='$postid'";
            $execute = mysqli_query($connection, $viewquery);
            while($row = mysqli_fetch_array($execute)) {
                $title = $row['title'];
                $category = $row['category'];
                $image = $row['image'];
                $post = $row['post'];
            }
            
            ?>
            <form action="deletepost.php?delete=<?php echo $postid; ?>" method="post" enctype="multipart/form-data">                 
              <fieldset>
               <div class="form-group">
                <label for="Title"><span class="FieldInfo">Title:</span></label>
                <input class="form-control" type="text" name="Title" id="title" placeholder="Title" value="<?php echo $title; ?>" disabled>
               </div> 
               <div class="form-group">
                <span class="FieldInfo">Existing Category:</span>
                <?php echo $category; ?><br>
                <label for="CategoryName"><span class="FieldInfo">Category:</span></label>
                <select disabled name="Category" id="CategoryName" class="form-control">
                    
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
                <span class="FieldInfo">Existing Image:</span>
                <img src="../PHPCMS/upload/<?php echo $image; ?>" alt="" height="70px" width="170px"><br>
                    <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                    <input disabled type="file" id="imageselect" class="form-control" name="Image">
                </div>
                <div class="form-group">
                    <label for="postarea"><span class="FieldInfo">Post:</span></label>
                    <textarea disabled class="form-control" name="Post" id="postarea">
                        <?php echo $post; ?>
                    </textarea>
                </div>
               <br>
               <input class="btn btn-danger btn-block" type="submit" name="submit" value="Delete Post"><br>
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