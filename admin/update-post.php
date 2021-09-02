<?php include "header.php"; 

    include "config.php";
    $postid = $_GET['id'];

    if($_SESSION['role'] == 0)
    {
        $sql1 = "SELECT * FROM post WHERE post_id = {$postid}";
        $result1 = mysqli_query($conn,$sql1) or die("couldnt run query");   
        $rows1 = mysqli_fetch_assoc($result1);
        if($_SESSION['userid'] != $rows1['author'])
        {
            header("Location: {$host}admin/post.php");
            
        }
    }



    $sql = "SELECT post.post_id,post.title,post.description,post.post_img,category.category_name,post.category FROM post
            LEFT JOIN  category ON post.category = category.category_id
            RIGHT JOIN user ON post.author = user.user_id
            WHERE post.post_id = {$postid}";
    $result = mysqli_query($conn,$sql) or die("couldnt run query");

    if(mysqli_num_rows($result) > 0)
    {   
       $rows = mysqli_fetch_assoc($result);
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="old_category" value="<?php echo $rows['category'];?>">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $rows['post_id'];?> " placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $rows['title'];?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                <?php echo $rows['description'];?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                <?php
                            include "config.php";
                             $sql1 = "SELECT * FROM category";
                             $result1 = mysqli_query($conn,$sql1) or die("couldnt run query");
                        
                             if(mysqli_num_rows($result1) > 0)
                             {
                                 while($rows1 = mysqli_fetch_assoc($result1)){
                                     if($rows1['category_id'] == $rows['category'])
                                        $select = "selected";
                                    else
                                        $select = "";
                                    echo "<option value='".$rows1['category_id']."' {$select}>".$rows1['category_name']."</option>";
                                }
                             }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
            
                <img  src="upload/<?php echo $rows['post_img'];?>" height="150px">
                <input type="hidden" name="old_image" value="<?php echo $rows['post_img'];?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php }else{
    echo "Post not found";
    }?>
<?php include "footer.php"; ?>
