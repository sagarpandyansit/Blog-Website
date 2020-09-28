
<?php include('includes/indexheader.php'); ?>
	<!-- End header Area -->

	<!-- Start banner Area -->
	<section class="banner-area">
		<div class="container box_1170">
			<div class="row fullscreen d-flex align-items-center justify-content-center">
				<div class="banner-content text-center col-lg-8">
					<h1>
						welcome <br>
						This is the right place to show your experience.
					</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->

	<!-- Start Post Silder Area -->
	<section class="post-slider-area">
		<div class="container box_1170">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="owl-carousel active-post-carusel">
						<div class="post-box mb-30">
							<div class="d-flex">
								<div>
									<a href="#">
										<img src="img/author/a1.png" alt="">
									</a>
								</div>
								<div class="post-meta">
									<div class="meta-head">
										<a href="#">Sagar Pandya</a>
									</div>
									<div class="meta-details">
										<ul>
											<li>
												<a href="#">
													<span class="lnr lnr-calendar-full"></span>
													13th Oct, 2018
												</a>
											</li>
											<li>
												<a href="#">
													<span class="lnr lnr-picture"></span>
													Image Post
												</a>
											</li>
											<li>
												<a href="#">
													<span class="lnr lnr-coffee-cup"></span>
													Food & Travel
												</a>
											</li>
											<li>
												<a href="#">
													<span class="lnr lnr-bubble"></span>
													03 Comments
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus dolorem dolores cum qui consequuntur aliquid magni aperiam, vitae molestiae delectus iure vero rem, unde natus consectetur autem sapiente facere maxime?</p>
							<div class="post-btn">
								<a href="#" class="primary-btn text-uppercase">Read More</a>
							</div>
						</div>

						<div class="post-box mb-30">
							<div class="d-flex">
								<div>
									<a href="#">
										<img src="img/author/a1.png" alt="">
									</a>
								</div>
								<div class="post-meta">
									<div class="meta-head">
										<a href="#">Sagar Pandya</a>
									</div>
									<div class="meta-details">
										<ul>
											<li>
												<a href="#">
													<span class="lnr lnr-calendar-full"></span>
													13th Oct, 2018
												</a>
											</li>
											<li>
												<a href="#">
													<span class="lnr lnr-picture"></span>
													Image Post
												</a>
											</li>
											<li>
												<a href="#">
													<span class="lnr lnr-coffee-cup"></span>
													Food & Travel
												</a>
											</li>
											<li>
												<a href="#">
													<span class="lnr lnr-bubble"></span>
													03 Comments
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
								dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
							<div class="post-btn">
								<a href="#" class="primary-btn text-uppercase">Read More</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Post Silder Area -->

	<!-- Start main body Area -->

	<div class="main-body section-gap mt--30">
		<div class="container box_1170">
			<div class="row">
				<div class="col-lg-8 post-list">
					<!-- Start Post Area -->
<?php
                    $connection = mysqli_connect('localhost', 'root', '', 'phpcms');
                    if(isset($_GET["searchbutton"])) {
                      
                        $search = $_GET['search'];
                        $viewquery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' OR author like '%$search%'"; 
                    
                    } elseif(isset($_GET['category'])){
                        
                        $category = $_GET['category'];
                        $viewquery = "SELECT * FROM admin_panel WHERE category='$category' ORDER BY datetime DESC"; 
                    
                    } else {
                        if(isset($_GET["page"])) {
                        
                            $page = $_GET["page"];
                            if($page <= 0){

                                $pagefrom = 0;
                            } else {
                                    $pagefrom = ($page*5)-5;
                            }
                            $viewquery = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT $pagefrom, 5";
                    
                        } else {
                            
                            $page = 1;
                            $pagefrom = 0;
                            $viewquery = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0,5";
                        
                        }
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
					<section class="post-area">
						<div class="single-post-item">
							<figure>
								<img class="post-img img-fluid" src="../PHPCMS/upload/<?php echo $postimage; ?>" height="340px" width="700px" alt="">
							</figure>
							<h3>
								<a href="blog-details.php?id=<?php echo $postid ?>"><?php echo htmlentities($posttitle);  ?></a>
							</h3>
							<p><?php 
                                if(strlen($postcontent) > 200) {
                                    $postcontent = substr($postcontent, 0, 200).'...';
                                } echo $postcontent; ?></p>
							<a href="blog-details.php?id=<?php echo $postid; ?>" class="primary-btn text-uppercase mt-15">continue Reading</a>
							<div class="post-box">
								<div class="d-flex">
									<div>
										<a href="#">
											<img src="img/author/IMAGE0002_2.JPG" alt="" height="50px" width="50px">
										</a>
									</div>
									<div class="post-meta">
										<div class="meta-head">
											<a href="#"><?php echo htmlentities($postauthor); ?></a>
										</div>
										<div class="meta-details">
											<ul>
												<li>
<!--													<a href="#">-->
														<span class="lnr lnr-calendar-full"></span>
														<?php echo htmlentities($postdatetime); ?>
<!--													</a>-->
												</li>
												<li>
<!--													<a href="#">-->
														<span class="lnr lnr-picture"></span>
														Image Post
<!--													</a>-->
												</li>
												<li>
													<a href="index.php?category=<?php echo $postcategory; ?>">
														<span class="lnr lnr-coffee-cup"></span>
														<?php echo htmlentities($postcategory); ?>
													</a>
												</li>
												<li>
													<a href="blog-details.php?id=<?php echo $postid; ?>#comment">
														<span class="lnr lnr-bubble"></span>
													<?php
                    
                                                        $totalquery = "SELECT COUNT(*) FROM comments WHERE admin_panel_id={$postid} AND status='ON'";
                                                        $totalexecute = mysqli_query($connection, $totalquery);
                                                        $rowcomment = mysqli_fetch_array($totalexecute);
                                                        $totalcomment = array_shift($rowcomment);
                                                        
                                                        echo $totalcomment . " comments";
                                                    ?>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
                    <?php } ?>
                
                        
						<nav class="blog-pagination justify-content-center d-flex">
							<ul class="pagination">
						<?php
                            if(isset($page) && $page > 1) {        
                        ?>
								<li class="page-item">
									<a href="index.php?page=<?php echo $page-1 ?>" class="page-link" aria-label="Previous">
										<span aria-hidden="true">
											<span class="lnr lnr-arrow-left"></span>
										</span>
									</a>
								</li>
				        <?php } ?>
				        <?php 
                        
                            $connection = mysqli_connect("localhost", "root", "", "phpcms");
                        
                            $querypagination = "SELECT COUNT(*) From admin_panel";
                            $executepagination = mysqli_query($connection, $querypagination);
                            $rowpagination = mysqli_fetch_array($executepagination);
                            $totalpost = array_shift($rowpagination);

                            $totalpage = $totalpost/5;
                            $totalpage = ceil($totalpage);
                        
                            for($i = 1; $i <= $totalpage; $i++) {
                        ?>
								
								<?php     
                                
                                    if(isset($page)){
                                        if($page == $i){  ?>
                                            <li class="page-item active"><a href="index.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a></li>
                                <?php  } else {  ?>
                                            <li class="page-item"><a href="index.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a></li>
                                <?php  }    } }   ?>
								
								<?php
                            if(isset($page) && $page < $totalpage) {        
                        ?>
								<li class="page-item">
									<a href="index.php?page=<?php echo $page+1 ?>" class="page-link" aria-label="Next">
										<span aria-hidden="true">
											<span class="lnr lnr-arrow-right"></span>
										</span>
									</a>
								</li>
				        <?php } ?>
							</ul>
						</nav>
				
						
					</section>
					<!-- Start Post Area -->
				</div>
    
    
        <!-- starting of side bar -->
				
               <?php include('includes/sidebar.php'); ?>
                
        <!-- Ending of  Sidebar -->
				
			</div>
		</div>
	</div>
	<!-- Start main body Area -->

	<!-- start footer Area -->
	<?php include('includes/footer.php'); ?>