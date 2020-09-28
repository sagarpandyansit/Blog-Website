<?php require_once("Include/sessions.php"); ?>
<?php require_once('Include/functions.php'); ?>
<?php confirmlogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Comments</title>
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
                    <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li><a href="addnewposts.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add new posts</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Categories</a></li>
                    <li><a href="admins.php"><span class="glyphicon glyphicon-user"></span> &nbsp;Manage admins</a></li>
                    <li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> &nbsp;Comments
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
                <h1>Un-Approved Comments</h1>
                <div><?php echo message(); 
                        echo successMessage(); ?></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
<?php
    
    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    $viewquery = "SELECT * FROM comments WHERE status='OFF' ORDER BY datetime DESC";
    $execute = mysqli_query($connection, $viewquery);
    $srno = 0;
    while($row = mysqli_fetch_array($execute)) {
        $commentid = $row['id'];
        $commentdatetime = $row['datetime'];
        $commentname = $row['name'];
        $comment = $row['comment'];
        $commentpostid = $row['admin_panel_id'];
        $srno++;
        
        if(strlen($commentdatetime) > 11) { $commentdatetime = substr($commentdatetime, 0, 11); }
        if(strlen($commentname) > 12) { $commentname = substr($commentname, 0, 12).'...';}
?>        
                <tr>
                    <td><?php echo $srno; ?></td>
                    <td><?php echo $commentname; ?></td>
                    <td><?php echo $commentdatetime;?></td>
                    <td><?php echo $comment; ?></td>
                    <td><a href="approvecomment.php?id=<?php echo $commentid; ?>"><span class="btn btn-success">Approve</span></a></td>
                    <td><a href="deletecomment.php?id=<?php echo $commentid; ?>"><span class="btn btn-danger">Delete</span></a></td>
                    <td><a href="../ruft/blog-details.php?id=<?php echo $commentpostid; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                </tr>
 <?php } ?>                       
                    </table>
           
             </div>
                
            
                <h1>Approved Comments</h1>
                <div><?php echo message(); 
                        echo successMessage(); ?></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <th>Approved By</th>
                            <th>Revert Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
<?php
    
    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
    $viewquery = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime DESC";
    $execute = mysqli_query($connection, $viewquery);
    $srno = 0;
    while($row = mysqli_fetch_array($execute)) {
        $commentid = $row['id'];
        $commentdatetime = $row['datetime'];
        $commentname = $row['name'];
        $comment = $row['comment'];
        $commentpostid = $row['admin_panel_id'];
        $srno++;
        
        $admin = $_SESSION['adminname'];
        
        if(strlen($commentdatetime) > 11) { $commentdatetime = substr($commentdatetime, 0, 11); }
        if(strlen($commentname) > 12) { $commentname = substr($commentname, 0, 12).'...';}
?>        
                <tr>
                    <td><?php echo $srno; ?></td>
                    <td><?php echo $commentname; ?></td>
                    <td><?php echo $commentdatetime;?></td>
                    <td><?php echo $comment; ?></td>
                    <td><?php echo $admin; ?></td>
                    <td><a href="disapprovecomment.php?id=<?php echo $commentid; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
                    <td><a href="deletecomment.php?id=<?php echo $commentid; ?>"><span class="btn btn-danger">Delete</span></a></td>
                    <td><a href="../ruft/blog-details.php?id=<?php echo $commentpostid; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                </tr>
 <?php } ?>                       
                    </table>
           
             </div>
                
                
            </div>
            
            
            
            <!-- ending of main area -->
        </div><!-- ending of row -->
    </div><!-- ending of container fluid -->
    
    <div id="Footer">
        <hr><p>Theme By | Sagar Pandya | &copy;2019-2024 --- All right reserved. </p>
        <a style="color: white; text-decoration: none; cursor: pointer; font-weight:body;" href=""></a>
    </div>
    <div style="height: 10px; background: #27AAE1;"></div>
    
</body>
</html>