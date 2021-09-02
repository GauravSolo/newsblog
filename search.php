<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                <?php
                            include "config.php";
                          
                            if(isset($_GET['page']))
                            {
                              $page = $_GET['page'];
                            }
                            else
                            {
                              $page = 1;
                            }
                            $limit = 3;
                            $offset = ($page-1)*$limit;
                            
                            $search  = mysqli_real_escape_string($conn,$_GET['search']);                           
                            
                            echo "<h2 class='page-heading'> SEARCH : {$search}</h2>";




                            $sql = "SELECT * FROM post 
                                    LEFT JOIN category ON post.category = category.category_id                             
                                    LEFT JOIN user ON post.author = user.user_id                             
                                    WHERE title LIKE '%{$search }%' OR description LIKE '%{$search}%'
                                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}
                                    ";
                            
                            //post.author = {$_SESSION['userid']} because only particular user can edit and update own post 
  
  
                            $result = mysqli_query($conn,$sql) or die("couldnt run query");
                            if(mysqli_num_rows($result) > 0)
                            {
        
                              while($rows = mysqli_fetch_assoc($result)){
                        ?>
                        
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                   <a class="post-img" href='single.php?id=<?php echo $rows['post_id'];?>'><img src="admin/upload/<?php echo $rows['post_img'];?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $rows['post_id'];?>'><?php echo $rows['title'] ;?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href="category.php?cid=<?php echo $rows['category_id']; ?>"><?php echo $rows['category_name']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?aid=<?php echo $rows['author'];?>&cid=-10'><?php echo $rows['username']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $rows['post_date']; ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo substr($rows['description'],0,150)."..."; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $rows['post_id'];?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                              }
                            }else{
                                echo " No record found!";
                            }

                    $sql1 = "SELECT * FROM post WHERE title LIKE '%{$search} %' OR description LIKE '%{$search}%'";
                    $result1 = mysqli_query($conn,$sql1) or die("couldnt run query");
                    
                    if(mysqli_num_rows($result1) > 0){
                        $total_records = mysqli_num_rows($result1);
                    
                        $total_pages = ceil(($total_records/$limit));
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1)
                        {
                            echo '<li><a href="search.php?page='.($page-1).'&search='.$search.'">PREV</a></li>';
                        }
                        
                        for($i = 1; $i <= $total_pages; $i++){

                            if($i == $page)
                                $active = "active";
                            else
                                $active = "";
                            
                            echo '<li class = "'.$active.'"><a href="search.php?page='.$i.'&search='.$search.'">'.$i.'</a></li>';
                        }
                        if($total_pages > $page)
                        {
                            echo '<li><a href="search.php?page='.($page+1).'&search='.$search.'">NEXT</a></li>';
                        }
                        
                        echo "</ul>";
                    }
                  ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
