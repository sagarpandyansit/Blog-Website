<?php require_once('../PHPCMS/Include/functions.php'); ?>
<?php require_once('../PHPCMS/Include/sessions.php'); ?>

<?php 

if(!isset($_GET['id'])) { $postid = 9; }
else { $postid = $_GET['id']; }

if(isset($_POST['submit']))
{
    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
        $name = $_POST['name'];
        $email = $_POST['email'];
       // $image = $_POST['Image'];
        $message = $_POST['message'];
        

        //just for security.
        $name = mysqli_real_escape_string($connection , $name);
    $email = mysqli_real_escape_string($connection , $email);
       // $image = mysqli_real_escape_string($connection , $image);
        $message = mysqli_real_escape_string($connection , $message);
        //this is prevent from your database to lost or don't allow 
        // or filter all the stuff.
    
    date_default_timezone_set("Asia/Kolkata");
    $currTime = time();
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currTime);
    $dateTime;
    
    if(strlen($message) > 500) {
        $_SESSION['error_message'] = "only 500 characters are allowed.";
        
        
    } else {
        
        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
        
        $query = "INSERT INTO comments (datetime, name, email, comment, approvedby, status, admin_panel_id) VALUES ('$dateTime', '$name', '$email', '$message', 'pending', 'OFF', '$postid')";
            $execute = mysqli_query($connection, $query);
            
            if($execute) {
                $_SESSION['success_message'] = "Comment Submitted Successfully to Admin For Review. You can see once it approved.";
                redirect_to("blog-details.php?id={$postid}");
            } else {
                $_SESSION['error_message'] = "Something went wrong";
                redirect_to("blog-details.php?id={$postid}");
            }
        }
}


?>
   
   <?php include('includes/header.php'); ?>
    <!-- End header Area -->

    <!-- start banner Area -->
    <section class="banner-area relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        Blog Details
                    </h1>
                    <p class="text-white link-nav"><a href="index.php">Home </a> <span class="lnr lnr-arrow-right"></span>
                        <a href="blog-details.php">
                            Blog Details</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Blog Area -->
    
    <section class="blog_area section-gap single-post-area">
        <div class="container">
            <div class="row"> 
                <div class="col-lg-8">
                <?php echo message();
                      echo SuccessMessage();
                ?>
                <?php
                    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
                    
                    if(isset($_GET["searchbutton"])) {
                        $search = $_GET['search'];
                        $viewquery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' OR author like '%$search%'"; 
                    } else {
                    
                        $viewquery = "SELECT * FROM admin_panel WHERE id='$postid' ORDER BY datetime DESC";
                    }
                    
                    $execute = mysqli_query($connection, $viewquery);
                    while($row = mysqli_fetch_array($execute)) {
                        $postid = $row['id'];
                        $postdatetime = $row['datetime'];
                        $posttitle = $row['title'];
                        $postcategory = $row['category'];
                        $postauthor = $row['author'];
                        $postimage = $row['image'];
                        $postcontent = $row['post'];
                  
                    
                ?>
                    <div class="main_blog_details">
                        <img class="img-fluid" src="../PHPCMS/upload/<?php echo $postimage; ?>" alt="">
                        <h4><?php echo $posttitle; ?></h4>
                        
                        
                        <div class="user_details">
                            <div class="float-left">
                                <a href="index.php?search=<?php echo $postcategory ?>&searchbutton="><?php echo $postcategory; ?></a>
                            </div>
                            <div class="float-right">
                                <div class="media">
                                    <div class="media-body">
                                        <h5><?php echo $postauthor; ?></h5>
                                        <p><?php echo $postdatetime; ?></p>
                                    </div>
                                    <div class="d-flex">
                                        <img src="img/blog/user-img.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                      <p><?php echo nl2br($postcontent); ?></p>
                      <br>
                <?php } ?>
                             <?php
                              
                              $totalquery = "SELECT COUNT(*) FROM comments WHERE admin_panel_id={$postid} AND status='ON'";
                        $totalexecute = mysqli_query($connection, $totalquery);
                        $rowcomment = mysqli_fetch_array($totalexecute);
                        $totalcomment = array_shift($rowcomment);
                             
                             ?>
                              
                        <div class="news_d_footer">
                            <a href="#"><i class="lnr lnr lnr-heart"></i>Lily and 4 people like this</a>
                            <a class="justify-content-center ml-auto" href="#"><i class="lnr lnr lnr-bubble"></i><?php echo htmlentities($totalcomment) ?>
                                Comments</a>
                            <div class="news_socail ml-auto">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-rss"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="navigation-area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                <div class="thumb">
                                    <a href="#"><img class="img-fluid" src="img/blog/prev.jpg" alt=""></a>
                                </div>
                                <div class="arrow">
                                    <a href="#"><span class="lnr text-white lnr-arrow-left"></span></a>
                                </div>
                                <div class="detials">
                                    <p>Prev Post</p>
                                    <a href="#">
                                        <h4>A Discount Toner</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                                <div class="detials">
                                    <p>Next Post</p>
                                    <a href="#">
                                        <h4>Cartridge Is Better</h4>
                                    </a>
                                </div>
                                <div class="arrow">
                                    <a href="#"><span class="lnr text-white lnr-arrow-right"></span></a>
                                </div>
                                <div class="thumb">
                                    <a href="#"><img class="img-fluid" src="img/blog/next.jpg" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="comments-area">
                        
                        
                        <?php
                    
                        $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
                        $viewquery = "SELECT * FROM comments WHERE admin_panel_id={$postid} AND status='ON'";
                        $execute = mysqli_query($connection, $viewquery);
                        
                        echo "<h4>$totalcomment Comments</h4>";
                        
                        while($row = mysqli_fetch_array($execute)) {
                            $name = $row['name'];
                            $datetime = $row['datetime'];
                            $comment = $row['comment'];
                        
                    ?>
                       
                        <div class="comment-list" id="comment">
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="thumb">
                                        <img src="img/blog/c1.jpg" alt="">
                                    </div>
                                    <div class="desc">
                                        <h5><a href="#"><?php echo $name; ?></a></h5>
                                        <p class="date"><?php echo $datetime; ?> </p>
                                        <p class="comment">
                                            <?php echo nl2br($comment); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="reply-btn">
                                    <a href="" class="btn-reply text-uppercase">reply</a>
                                </div>
                            </div>
                        </div>
<!--
                        <div class="comment-list left-padding">
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="thumb">
                                        <img src="img/blog/c2.jpg" alt="">
                                    </div>
                                    <div class="desc">
                                        <h5><a href="#">Elsie Cunningham</a></h5>
                                        <p class="date">December 4, 2017 at 3:12 pm </p>
                                        <p class="comment">
                                            Never say goodbye till the end comes!
                                        </p>
                                    </div>
                                </div>
                                <div class="reply-btn">
                                    <a href="" class="btn-reply text-uppercase">reply</a>
                                </div>
                            </div>
                        </div>
-->
<!--
                        <div class="comment-list left-padding">
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="thumb">
                                        <img src="img/blog/c3.jpg" alt="">
                                    </div>
                                    <div class="desc">
                                        <h5><a href="#">Annie Stephens</a></h5>
                                        <p class="date">December 4, 2017 at 3:12 pm </p>
                                        <p class="comment">
                                            Never say goodbye till the end comes!
                                        </p>
                                    </div>
                                </div>
                                <div class="reply-btn">
                                    <a href="" class="btn-reply text-uppercase">reply</a>
                                </div>
                            </div>
                        </div>
-->
                    <?php } ?>
                    
                     </div>
                   
                    <div class="comment-form">
                        <h4>Leave a Reply</h4>
                        
                        <form action="blog-details.php?id=<?php echo $postid; ?>" method="post">
                            <div class="form-group form-inline">
                                <div class="form-group col-lg-6 col-md-6 name">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 email">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
                            </div>
                            <input type="submit" name="submit" class="primary-btn submit_btn text-uppercase" value="Send Message">
                        </form>
                    </div>
                </div>

                <!-- starting of side bar --> 
				
              <?php include("includes/sidebar.php") ?>
               
        <!-- Ending of  Sidebar -->
           
            </div>
        </div>
    </section>
    <!-- Blog Area -->

    <!-- start footer Area -->
    <?php include('includes/footer.php');  ?>