<?php
    $page = basename($_SERVER['PHP_SELF']);
    include  'config.php';

    switch($page)
    {
        case 'single.php':
            if(isset($_GET['id']))
            {
                $sql_title = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
                $result_title = mysqli_query($conn,$sql_title) or die("couldnt run query");
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title  = $row_title['title']; 
            }else{
                $page_title = 'No record found';
            }   
            break;
        case 'category.php':
            if(isset($_GET['cid']))
            {
                $sql_title = "SELECT * FROM category WHERE category_id = {$_GET['cid']}";
                $result_title = mysqli_query($conn,$sql_title) or die("couldnt run query");
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title  = $row_title['category_name']." News"; 
            }else{
                $page_title = 'No record found';
            } 
            break;
        case 'author.php':
            if(isset($_GET['aid']))
            {
                $sql_title = "SELECT * FROM user WHERE user_id = {$_GET['aid']}";
                $result_title = mysqli_query($conn,$sql_title) or die("couldnt run query");
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title  = "News By: ".$row_title['first_name'].' '.$row_title['last_name']; 
            }else{
                $page_title = 'No record found';
            } 
            break;
        case 'search.php':
            if(isset($_GET['search']))
            {
                $page_title  = $_GET['search']; 
            }else{
                $page_title = 'No record found';
            } 
            break;
        default:
                $page_title = "News site";
    }

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
                <a href="index.php" id="logo"><img src="images/news.jpg"></a>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                <?php        
                    include "config.php";

                    if(isset($_GET['cid']))
                    {
                        $cid = $_GET['cid'];
                        $active = "";
                    }else{
                        $active = "active";
                    }
                    

                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($conn,$sql) or die('couldnt run query');
                    echo "<li><a class = '{$active}' href='index.php'>Home</a></li>";
                    if(mysqli_num_rows($result) > 0)
                    {
                        $active = '';
                        while($rows = mysqli_fetch_assoc($result)){
                            if(isset($_GET['cid']))
                            {
                                if($rows['category_id'] == $cid)
                                    $active = 'active';                        
                                else
                                    $active = '';
                            }
                        
                    echo "<li ><a class = '{$active}'href='category.php?cid={$rows['category_id']}'>{$rows['category_name']}</a></li>";
                }}
                echo "<li> <a href='admin/' style='color:yellow;'>User Panel</a></li>";
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
