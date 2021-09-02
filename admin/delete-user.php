<?php

            if($_SESSION['role'] == '0')
            {
                header("Location: {$host}admin/post.php");
            }

            
            include "config.php";
            $userid = $_GET['id'];

            $sql = "DELETE FROM user WHERE user_id = {$userid}";
            $result = mysqli_query($conn,$sql) or die("couldnt run query");

            if(!mysqli_query($conn,$sql))
            {
                echo "<p  style = 'color: yellow; font-size:150%;'> cant delete user account</p>";
            }
            header("Location: {$host}admin/users.php");
            mysqli_close($conn);
?>