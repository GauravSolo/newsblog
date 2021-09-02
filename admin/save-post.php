<?php
    include "config.php";
    if(isset($_FILES['fileToUpload']))
    {   
        $file_name  = $_FILES['fileToUpload']['name'];
        $file_size  = $_FILES['fileToUpload']['size'];
        $file_tmp  = $_FILES['fileToUpload']['tmp_name'];
        $filetype  = $_FILES['fileToUpload']['type'];
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
    else
    {
        echo "please upload image!";
        die();
    }
    session_start();
    $title = mysqli_real_escape_string($conn,$_POST['post_title']);
    $postdesc = mysqli_real_escape_string($conn,$_POST['postdesc']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $author = $_SESSION['userid'];
    $date = date('d M,Y');

    $sql = "INSERT INTO post(title,description,category,post_date,author,post_img) VALUES('{$title}','{$postdesc}',{$category},'{$date}',{$author},'{$image_name}');";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";
    if(mysqli_multi_query($conn,$sql)){
        header("Location: {$host}admin/post.php");

    }
    else{
        echo "<div class = 'alert alert-danger'>couldnt run query</div>";
    }
    mysqli_close($conn);
?>