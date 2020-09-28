<?php require_once("Include/sessions.php"); ?>
<?php require_once('Include/functions.php'); ?>
<?php confirmlogin(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>
   
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-sm-2">
               <a class="navbar-brand" href="../ruft/index.php"><img style="margin-top; -12px;" src="../ruft/img/logo.png"></a>
                <br><br><br><br><br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li><a href="addnewposts.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add new posts</a></li>
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
                <h1>Admin Dashboard</h1>
                <div><?php echo message(); 
                        echo successMessage(); ?></div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>No.</td>
                            <td>Post Title</td>
                            <td>Date & Time</td>
                            <td>Author</td>
                            <td>Category</td>
                            <td>Banner</td>
                            <td>Comments</td>
                            <td>Action</td>
                            <td>Detail</td>
                        </tr>
                   
<?php
    
    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    $viewquery = "SELECT * FROM admin_panel ORDER BY datetime DESC";
    $execute = mysqli_query($connection, $viewquery);
    $srno = 0;
    while($row = mysqli_fetch_array($execute)) {
        $id = $row['id'];
        $datetime = $row['datetime'];
        $title = $row['title'];
        $category = $row['category'];
        $author = $row['author'];
        $image = $row['image'];
        $post = $row['post'];
        $srno++;
?>
       <tr>
           <td><?php echo $srno; ?></td>
           <td style="color: #5e5eff;"><?php
                if(strlen($title) > 20) { $title = substr($title, 0, 20).'...';}
            echo $title; ?></td>
           <td><?php
                if(strlen($datetime) > 11) { $datetime = substr($datetime, 0, 11); }
            echo $datetime; ?></td>
           <td><?php
                if(strlen($author) > 6) { $author = substr($author, 0, 6).'..'; }
            echo $author; ?></td>
           <td><?php
                if(strlen($category) > 9) { $category = substr($category, 0, 6).'..'; }
            echo $category; ?></td>
           <td><img src="../PHPCMS/upload/<?php echo $image; ?>" alt="" width="170px" height="50px"></td>
           <td>
               
    <?php
        
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
        $queryapproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='ON'";
        $approvedexecute = mysqli_query($connection, $queryapproved);
        $approvedrow = mysqli_fetch_array($approvedexecute);
        $totalapproved =  array_shift($approvedrow);
    ?>
        <?php if($totalapproved > 0) { ?>
        <span class="label pull-right label-success"><?php echo $totalapproved; ?></span>
        <?php } ?>
        
    <?php
        
        $queryunapproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='OFF'";
        $unapprovedexecute = mysqli_query($connection, $queryunapproved);
        $unapprovedrow = mysqli_fetch_array($unapprovedexecute);
        $totalunapproved =  array_shift($unapprovedrow);
    ?>
        <?php if($totalunapproved > 0) { ?> 
        <span class="label pull-left label-danger"><?php echo $totalunapproved; ?></span>
        <?php } ?>
       </td>

           <td>
               <a href="editpost.php?edit=<?php echo $id; ?>">
               <span class="btn btn-warning">Edit</span>
               </a>
               <a href="deletepost.php?delete=<?php echo $id; ?>">
               <span class="btn btn-danger">Delete</span>
               </a>             
           </td>
           <td>
               <a href="../ruft/blog-details.php?id=<?php echo $id; ?>"><span class="btn btn-primary">Live Preview</span></a>
           </td>
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