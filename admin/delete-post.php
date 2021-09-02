<?php

    include "config.php";

    $postid = $_GET['id'];
    $sql1 = "SELECT * FROM post WHERE post_id = {$postid}";
    $result = mysqli_query($conn,$sql1) or die("couldnt run query");

    $rows = mysqli_fetch_assoc($result);

    unlink("upload/".$rows[post_img]);
    $sql = "DELETE FROM post WHERE post_id = {$postid};";
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$rows['category']}";

    if(mysqli_multi_query($conn,$sql))
    {
        header("Location: {$host}admin/post.php");
    }
    else
    {
        echo "<div> couldnt run query </div>";
    }

?>