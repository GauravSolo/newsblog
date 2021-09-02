<?php
    include "header.php";

    if($_SESSION['role'] == '0')
    {
        header("Location: {$host}admin/post.php");
    }

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
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
                          $sql = "SELECT * FROM user ORDER BY user_id ASC LIMIT {$offset}, {$limit}";
                          $result = mysqli_query($conn,$sql) or die("couldnt run query");
                          if(mysqli_num_rows($result) > 0)
                          {
                            $serial = $offset + 1;
                            while($rows = mysqli_fetch_assoc($result)){
                        ?>
                          <tr>
                              <td class='id'><?php echo $serial++; ?></td>
                              <td><?php echo $rows["first_name"]." ".$rows["last_name"]; ?></td>
                              <td><?php echo $rows["username"] ?></td>
                              <td><?php echo $rows["role"] ?></td>
                              <td class='edit'><a href="update-user.php?id=<?php echo $rows['user_id'];?>"><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href="delete-user.php?id=<?php echo $rows['user_id'];?>"><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                        <?php }}?>
                      </tbody>
                  </table>
                  <?php 
                    $sql1 = "SELECT * FROM user";
                    $result1 = mysqli_query($conn,$sql1) or die("couldnt run query");
                    
                    if(mysqli_num_rows($result1) > 0){
                        $total_records = mysqli_num_rows($result1);
                    
                        $total_pages = ceil(($total_records/$limit));
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1)
                        {
                            echo '<li><a href="users.php?page='.($page-1).'">PREV</a></li>';
                        }
                        
                        for($i = 1; $i <= $total_pages; $i++){

                            if($i == $page)
                                $active = "active";
                            else
                                $active = "";
                            
                            echo '<li class = "'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                        }
                        if($total_pages > $page)
                        {
                            echo '<li><a href="users.php?page='.($page+1).'">NEXT</a></li>';
                        }
                        
                        echo "</ul>";
                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
