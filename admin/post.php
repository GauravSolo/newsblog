<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                  
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
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
                          $limit = 5;
                          $offset = ($page-1)*$limit;

                          if($_SESSION['role'] == '1')
                          {
                            $sql = "SELECT * FROM post 
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}
                            ";
                          }elseif($_SESSION['role'] == '0')
                          {
                            $sql = "SELECT * FROM post 
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            WHERE post.author = {$_SESSION['userid']}
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}
                            ";
                          }
                          //post.author = {$_SESSION['userid']} because only particular user can edit and update own post 


                          $result = mysqli_query($conn,$sql) or die("couldnt run query");
                          if(mysqli_num_rows($result) > 0)
                          {
                              $serial = $offset + 1;
                            while($rows = mysqli_fetch_assoc($result)){
                        ?>
                          <tr>
                              <td class='id'><?php echo $serial++; ?></td>
                              <td><?php echo $rows['title']; ?></td>
                              <td><?php echo $rows['category_name']; ?></td>
                              <td><?php echo $rows['post_date']; ?></td>
                              <td><?php echo $rows['first_name']." ".$rows['last_name']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $rows['post_id'];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $rows['post_id'];?>&catid=<?php echo $rows['category'];?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php }}?>
                      </tbody>
                  </table>
                  <?php 
                    $sql1 = "SELECT * FROM post";
                    $result1 = mysqli_query($conn,$sql1) or die("couldnt run query");
                    
                    if(mysqli_num_rows($result1) > 0){
                        $total_records = mysqli_num_rows($result1);
                    
                        $total_pages = ceil(($total_records/$limit));
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1)
                        {
                            echo '<li><a href="post.php?page='.($page-1).'">PREV</a></li>';
                        }
                        
                        for($i = 1; $i <= $total_pages; $i++){

                            if($i == $page)
                                $active = "active";
                            else
                                $active = "";
                            
                            echo '<li class = "'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                        }
                        if($total_pages > $page)
                        {
                            echo '<li><a href="post.php?page='.($page+1).'">NEXT</a></li>';
                        }
                        
                        echo "</ul>";
                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
