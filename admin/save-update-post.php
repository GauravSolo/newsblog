<?php
    include "config.php";
    
 
    if(empty($_FILES['new-image']['name']))
    {
       $file_name = $_POST['old_image'];
       $image_name = $file_name;

    }else
    {   
        $file_name  = $_FILES['new-image']['name'];
        $file_size  = $_FILES['new-image']['size'];
        $file_tmp  = $_FILES['new-image']['tmp_name'];
        $filetype  = $_FILES['new-image']['type'];
        $file_ext  = strtolower(end(explode('.',$file_name)));
        $extension = array('jpeg','jpg','png');

        $error = array();

        if(in_array($file_ext,$extension) === false)
        {
            $error[] = "This extenstion file not allowed. Please choose a PNG or JPG file";
        }

        // if($file_size > 2097152)
        // {
        //     $error[] = "File size must be 2mb or lower";
        // }

        $new_name = time().'-'.basename($file_name);
        $image_name = $new_name;
        if(empty($error))
        {
            $target = "upload/". $image_name;
            move_uploaded_file($file_tmp,$target);
        }else{
            print_r($error);
            die();
        }
    }

    

    $title = mysqli_real_escape_string($conn,$_POST['post_title']);
    $postdesc = mysqli_real_escape_string($conn,$_POST['postdesc']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);


    $sql = "UPDATE post SET title = '{$title}', description='{$postdesc}',category={$category},post_img='{$image_name}' WHERE post_id = {$_POST['post_id']};";
    
    if($_POST['old_category'] != $category){
        $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
        $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";
    }
    
    if(mysqli_multi_query($conn,$sql)){
        header("Location: {$host}admin/post.php");
    }
    else{
        echo "<div class = 'alert alert-danger'>couldnt run query</div>";
    }
    mysqli_close($conn);
?>